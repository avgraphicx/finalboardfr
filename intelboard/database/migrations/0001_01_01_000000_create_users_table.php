<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('google_id')->nullable();
            $table->string('name');
            $table->string('full_name')->nullable(); // Kept for backwards compatibility
            $table->string('email')->unique();
            $table->string('password')->nullable(); // Nullable for OAuth users
            $table->string('phone_number', 50)->nullable();
            $table->tinyInteger('role')->default(3); // 1=Admin, 2=Broker, 3=Supervisor
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('joining_date')->nullable();
            $table->boolean('active')->default(true);
            $table->string('company_name')->nullable(); // For brokers only
            $table->string('logo')->nullable(); // File path or URL
            $table->string('subscription_tier')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
