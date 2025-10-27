<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateFromLegacyDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:legacy {file? : Path to the old database SQL file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from legacy database to new schema (preserving original IDs)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file') ?? storage_path('iboard (4).sql');

        if (!file_exists($file)) {
            $this->error("SQL file not found: {$file}");
            return 1;
        }

        try {
            $this->info('🔧 Starting legacy database migration...\n');

            // Import legacy database
            $this->importLegacyDatabase($file);

            // Run migrations
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            $this->migrateUsers();
            $this->migrateDrivers();
            $this->migrateInvoices();
            $this->migrateSubscriptions();
            $this->migrateSubscriptionTypes();
            $this->createMigrationAuditLog();

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            $this->info("\n✅ Migration completed successfully!");
            $this->printMigrationSummary();

            return 0;

        } catch (\Exception $e) {
            $this->error("\n❌ Migration failed: {$e->getMessage()}");
            try {
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            } catch (\Exception $ex) {
                // Ignore cleanup errors
            }
            return 1;
        }
    }

    /**
     * Import legacy database from SQL file
     */
    private function importLegacyDatabase(string $file): void
    {
        $dbName = 'iboard_legacy_' . time();
        $host = env('DB_HOST');
        $user = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $port = env('DB_PORT', 3306);

        $this->info("📦 Creating temporary database: {$dbName}");

        // Create database using Laravel DB connection
        try {
            DB::statement("DROP DATABASE IF EXISTS `{$dbName}`");
            DB::statement("CREATE DATABASE `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        } catch (\Exception $e) {
            throw new \Exception("Failed to create temporary database: " . $e->getMessage());
        }

        $this->info("📥 Importing SQL file...");

        // Build mysql command with proper password handling
        $cmd = "mysql -h" . escapeshellarg($host) . " -P" . $port . " -u" . escapeshellarg($user);
        if ($password) {
            $cmd .= " -p" . escapeshellarg($password);
        }
        $cmd .= " " . escapeshellarg($dbName) . " < " . escapeshellarg($file) . " 2>&1";

        $output = [];
        $returnCode = 0;
        exec($cmd, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \Exception("Failed to import SQL file:\n" . implode("\n", $output) . "\nCommand: " . str_replace($password, "***", $cmd));
        }

        $this->legacyDbName = $dbName;
        $this->info("✓ Legacy database ready: {$dbName}\n");
    }

    /**
     * Migrate users
     */
    private function migrateUsers(): void
    {
        $db = $this->legacyDbName;

        $query = "
            INSERT INTO users (id, name, email, password, remember_token, created_at, updated_at, role, status, broker_id, company_name, phone_number, google_id, last_login_at)
            SELECT
                u.id,
                u.full_name,
                u.email,
                u.password,
                u.remember_token,
                u.created_at,
                u.updated_at,
                u.role,
                u.status,
                u.broker_id,
                COALESCE(b.company_name, NULL),
                u.phone_number,
                u.google_id,
                u.last_login_at
            FROM `{$db}`.users u
            LEFT JOIN `{$db}`.brokers b ON u.id = b.user_id
            WHERE u.id NOT IN (SELECT id FROM users)
        ";

        DB::statement($query);
        $count = DB::table('users')->count();
        $this->info("✓ Migrated {$count} users");
    }

    /**
     * Migrate drivers
     */
    private function migrateDrivers(): void
    {
        $db = $this->legacyDbName;

        // Get all drivers with calculated fields
        $oldDrivers = DB::select("
            SELECT
                id, full_name, phone_number, driver_id, license_number, ssn,
                default_percentage, default_rental_price, added_by, active, created_at, updated_at
            FROM `{$db}`.drivers
        ");

        foreach ($oldDrivers as $driver) {
            if (DB::table('drivers')->where('id', $driver->id)->exists()) {
                continue;
            }

            $names = $this->splitName($driver->full_name);
            $brokerId = null;

            if ($driver->added_by) {
                $user = DB::table('users')->find($driver->added_by);
                $brokerId = $user ? $user->broker_id : null;
            }

            DB::table('drivers')->insert([
                'id' => $driver->id,
                'broker_id' => $brokerId,
                'first_name' => $names['first'],
                'last_name' => $names['last'],
                'phone_number' => $driver->phone_number,
                'email' => null,
                'license_number' => $driver->license_number,
                'ssn' => $driver->ssn,
                'driver_id' => $driver->driver_id,
                'percentage' => $driver->default_percentage,
                'rental_price' => $driver->default_rental_price,
                'active' => (bool)$driver->active,
                'created_by' => $driver->added_by,
                'created_at' => $driver->created_at,
                'updated_at' => $driver->updated_at,
            ]);
        }

        $count = DB::table('drivers')->count();
        $this->info("✓ Migrated {$count} drivers");
    }

    /**
     * Migrate invoices
     */
    private function migrateInvoices(): void
    {
        $db = $this->legacyDbName;

        $oldPayments = DB::select("
            SELECT
                id, driver_id, week_number, total_invoice,
                broker_van_cut, broker_pay_cut, final_amount,
                bonus, cash_advance, paid, paid_at, pdf_path, created_at, updated_at
            FROM `{$db}`.payments
        ");

        foreach ($oldPayments as $payment) {
            if (DB::table('invoices')->where('id', $payment->id)->exists()) {
                continue;
            }

            $brokerCut = ($payment->broker_van_cut ?? 0) + ($payment->broker_pay_cut ?? 0);
            $driverPay = ($payment->final_amount ?? 0) - $brokerCut;

            DB::table('invoices')->insert([
                'id' => $payment->id,
                'driver_id' => $payment->driver_id,
                'week' => $payment->week_number,
                'total_amount' => $payment->total_invoice,
                'broker_cut' => $brokerCut,
                'driver_pay' => $driverPay,
                'bonus' => $payment->bonus ?? 0,
                'cash_advance' => $payment->cash_advance ?? 0,
                'paid' => (bool)$payment->paid,
                'paid_at' => $payment->paid_at,
                'invoice_number' => 'INV-' . $payment->id,
                'pdf_path' => $payment->pdf_path,
                'created_at' => $payment->created_at,
                'updated_at' => $payment->updated_at,
            ]);
        }

        $count = DB::table('invoices')->count();
        $this->info("✓ Migrated {$count} invoices");
    }

    /**
     * Migrate subscriptions
     */
    private function migrateSubscriptions(): void
    {
        $db = $this->legacyDbName;

        $oldSubs = DB::select("
            SELECT s.id, s.broker_id, s.stripe_id, s.stripe_status,
                   s.created_at, s.updated_at, s.ends_at,
                   b.user_id, b.subscription_type_id
            FROM `{$db}`.subscriptions s
            LEFT JOIN `{$db}`.brokers b ON s.broker_id = b.id
        ");

        foreach ($oldSubs as $sub) {
            if (!$sub->user_id) {
                continue;
            }

            if (DB::table('subscriptions')->where('id', $sub->id)->exists()) {
                continue;
            }

            DB::table('subscriptions')->insert([
                'id' => $sub->id,
                'user_id' => $sub->user_id,
                'subscription_type_id' => $sub->subscription_type_id ?? 1,
                'stripe_id' => $sub->stripe_id,
                'stripe_status' => $sub->stripe_status,
                'started_at' => $sub->created_at,
                'ends_at' => $sub->ends_at,
                'created_at' => $sub->created_at,
                'updated_at' => $sub->updated_at,
            ]);
        }

        $count = DB::table('subscriptions')->count();
        $this->info("✓ Migrated {$count} subscriptions");
    }

    /**
     * Migrate subscription types
     */
    private function migrateSubscriptionTypes(): void
    {
        $db = $this->legacyDbName;

        $oldTypes = DB::select("
            SELECT id, name, max_files, add_supervisor, max_drivers, custom_invoice
            FROM `{$db}`.subscription_type
        ");

        foreach ($oldTypes as $type) {
            DB::table('subscription_types')->updateOrInsert(
                ['id' => $type->id],
                [
                    'name' => $type->name,
                    'max_drivers' => $type->max_drivers,
                    'price' => 0,
                    'features' => json_encode([
                        'max_files' => $type->max_files,
                        'add_supervisor' => (bool)$type->add_supervisor,
                        'custom_invoice' => (bool)$type->custom_invoice,
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $count = DB::table('subscription_types')->count();
        $this->info("✓ Migrated {$count} subscription types");
    }

    /**
     * Create audit log entry
     */
    private function createMigrationAuditLog(): void
    {
        DB::table('audit_logs')->insert([
            'user_id' => 1,
            'action' => 'data_migration',
            'description' => 'Legacy database migration completed successfully',
            'model_type' => 'System',
            'model_id' => 0,
            'old_data' => json_encode(['event' => 'migration_start']),
            'new_data' => json_encode([
                'event' => 'migration_complete',
                'tables_migrated' => [
                    'users' => DB::table('users')->count(),
                    'drivers' => DB::table('drivers')->count(),
                    'invoices' => DB::table('invoices')->count(),
                    'subscriptions' => DB::table('subscriptions')->count(),
                ],
            ]),
            'ip_address' => '127.0.0.1',
            'created_at' => now(),
        ]);

        $this->info("✓ Audit log created");
    }

    /**
     * Split full name
     */
    private function splitName(string $fullName): array
    {
        $parts = explode(' ', trim($fullName), 2);
        return [
            'first' => $parts[0] ?? '',
            'last' => $parts[1] ?? '',
        ];
    }

    /**
     * Print migration summary
     */
    private function printMigrationSummary(): void
    {
        $this->line("\n📊 Final Data Summary:");
        $this->line("  👥 Users: " . DB::table('users')->count());
        $this->line("  🚗 Drivers: " . DB::table('drivers')->count());
        $this->line("  📄 Invoices: " . DB::table('invoices')->count());
        $this->line("  📦 Subscriptions: " . DB::table('subscriptions')->count());
        $this->line("  💳 Subscription Types: " . DB::table('subscription_types')->count());
    }
}
