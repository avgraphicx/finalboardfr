# Legacy Database Migration Guide

## Overview

This document describes the data migration from the old IntelBoard database schema to the new October 2025 schema. All original IDs are preserved during the migration.

## Migration Summary

### Tables Migrated

1. **Users** → All user data preserved with role-based structure
2. **Drivers** → Full driver information with broker association
3. **Payments** → Converted to Invoices with financial calculations
4. **Subscriptions** → Broker subscriptions mapped to user subscriptions
5. **Subscription Types** → Features stored as JSON

### Tables Not Migrated

-   **Calculations/Calculation Logs** - Old payment calculation system (use new Invoices)
-   **Expenses** - Legacy system (can be reimplemented separately)
-   **File Usage** - File management (can be reset)
-   **Weeks** - Reference table (can be auto-generated)
-   **Cache/Sessions/Jobs** - Laravel internals (auto-managed)

---

## Detailed Schema Mapping

### 1. Users Migration

**Old Schema → New Schema**

```
old_users.id                  → users.id (preserved)
old_users.full_name           → users.name
old_users.email               → users.email
old_users.password            → users.password
old_users.role                → users.role (admin|broker|supervisor)
old_users.status              → users.status (active|inactive)
old_users.broker_id           → users.broker_id
old_users.phone_number        → users.phone_number
old_users.google_id           → users.google_id
old_users.last_login_at       → users.last_login_at
old_users.remember_token      → users.remember_token
old_users.created_at          → users.created_at
old_users.updated_at          → users.updated_at
old_brokers.company_name      → users.company_name (for brokers)
```

**Migration Logic:**

-   All users are migrated with preserved IDs
-   User company names are populated from the brokers table
-   Only active users are fully migrated

**Data Example:**

```
ID: 1
  Old: full_name='Ismail Merdjaoui', role='admin', broker_id=NULL
  New: name='Ismail Merdjaoui', role='admin', broker_id=NULL

ID: 7
  Old: full_name='Ismail', role='broker', broker_id=NULL
  New: name='Ismail', role='broker', company_name='IntelDelivery'
```

---

### 2. Drivers Migration

**Old Schema → New Schema**

```
old_drivers.id                  → drivers.id (preserved)
old_drivers.full_name           → drivers.first_name + drivers.last_name
old_drivers.phone_number        → drivers.phone_number
old_drivers.driver_id           → drivers.driver_id
old_drivers.license_number      → drivers.license_number
old_drivers.ssn                 → drivers.ssn
old_drivers.default_percentage  → drivers.percentage
old_drivers.default_rental_price → drivers.rental_price
old_drivers.added_by            → drivers.created_by
old_drivers.active              → drivers.active
old_drivers.created_at          → drivers.created_at
old_drivers.updated_at          → drivers.updated_at
[NEW]                           → drivers.broker_id (derived from added_by user)
[NEW]                           → drivers.email (NULL - not in old schema)
```

**Migration Logic:**

-   Full names are split into first_name and last_name
-   `broker_id` is determined from the `added_by` user's broker_id
-   If `added_by` is NULL, broker_id remains NULL

**Data Example:**

```
ID: 1
  Old: full_name='Ismail Merdjaoui', added_by=1, active=1
  New: first_name='Ismail', last_name='Merdjaoui', created_by=1,
       broker_id=NULL (since user 1 is admin)

ID: 82
  Old: full_name='Sophie Belanger', added_by=1, active=1
  New: first_name='Sophie', last_name='Belanger', created_by=1,
       broker_id=NULL
```

**Total Drivers:** 60 drivers (IDs 1, 28-90)

---

### 3. Payments → Invoices Migration

**Old Schema → New Schema**

```
old_payments.id                                  → invoices.id (preserved)
old_payments.driver_id                           → invoices.driver_id
old_payments.week_number                         → invoices.week
old_payments.total_invoice                       → invoices.total_amount
old_payments.broker_van_cut + broker_pay_cut     → invoices.broker_cut
old_payments.final_amount - broker_cuts          → invoices.driver_pay
old_payments.bonus                               → invoices.bonus
old_payments.cash_advance                        → invoices.cash_advance
old_payments.paid                                → invoices.paid
old_payments.paid_at                             → invoices.paid_at
old_payments.pdf_path                            → invoices.pdf_path
old_payments.created_at                          → invoices.created_at
old_payments.updated_at                          → invoices.updated_at
[NEW]                                            → invoices.invoice_number ('INV-' + id)
```

**Calculation Logic:**

```php
$brokerCut = ($broker_van_cut ?? 0) + ($broker_pay_cut ?? 0);
$driverPay = ($final_amount ?? 0) - $brokerCut;
```

**Data Example:**

```
ID: 287
  Old:
    driver_id: 82, week_number: '2025-36'
    total_invoice: 962.66, broker_van_cut: 120.00, broker_pay_cut: 240.67
    final_amount: 602.00, bonus: 0.00, cash_advance: 0.00, paid: 0

  New:
    driver_id: 82, week: '2025-36'
    total_amount: 962.66, broker_cut: 360.67, driver_pay: 241.33
    bonus: 0.00, cash_advance: 0.00, paid: 0
    invoice_number: 'INV-287'
```

**Total Invoices:** 38 invoices (IDs 287-324)

-   37 unpaid invoices
-   1 paid invoice (ID 324, marked paid on 2025-10-23)

---

### 4. Subscriptions Migration

**Old Schema → New Schema**

```
old_subscriptions.id              → subscriptions.id (preserved)
old_subscriptions.broker_id       → [lookup] → subscriptions.user_id
old_subscriptions.stripe_id       → subscriptions.stripe_id
old_subscriptions.stripe_status   → subscriptions.stripe_status
old_subscriptions.created_at      → subscriptions.started_at
old_subscriptions.ends_at         → subscriptions.ends_at
old_subscriptions.updated_at      → subscriptions.updated_at
old_brokers.subscription_type_id  → subscriptions.subscription_type_id
```

**Migration Logic:**

-   `broker_id` from old subscriptions is looked up to find the associated `user_id`
-   Subscription type is derived from the broker's `subscription_type_id`

**Data Example:**

```
ID: 1
  Old: broker_id=4, stripe_id='', stripe_status='', ends_at='2025-10-31'
  New: user_id=1, stripe_id='', stripe_status='',
       subscription_type_id=1, ends_at='2025-10-31'
```

**Total Subscriptions:** 1 subscription

-   User ID 1 (Admin/Broker ID 4, 'IB')
-   Type: Bronze (ID 1)
-   Ends: 2025-10-31

---

### 5. Subscription Types Migration

**Old Schema → New Schema**

```
old_subscription_type.id            → subscription_types.id (preserved)
old_subscription_type.name          → subscription_types.name
old_subscription_type.max_drivers   → subscription_types.max_drivers
old_subscription_type.max_files     → features['max_files']
old_subscription_type.add_supervisor → features['add_supervisor']
old_subscription_type.custom_invoice → features['custom_invoice']
[NEW]                               → subscription_types.price (0.00)
[NEW]                               → subscription_types.features (JSON)
```

**Features JSON Structure:**

```json
{
    "max_files": 1,
    "add_supervisor": false,
    "custom_invoice": false
}
```

**Data Example:**

```
ID: 1 - Bronze
  Old: max_files=1, add_supervisor=0, max_drivers=10, custom_invoice=0
  New: max_drivers=10, price=0.00, features={...}

ID: 2 - Gold
  Old: max_files=10, add_supervisor=0, max_drivers=50, custom_invoice=1
  New: max_drivers=50, price=0.00, features={...}

ID: 5 - Diamond
  Old: max_files=99999, add_supervisor=1, max_drivers=99999, custom_invoice=1
  New: max_drivers=99999, price=0.00, features={...}
```

**Total Types:** 3 subscription types

---

## Migration Execution

### Prerequisites

1. Ensure new database is fully set up with all migrations applied
2. Backup both old and new databases
3. Verify Laravel is properly configured

### Running the Migration

```bash
# Execute the migration
php artisan migrate

# The migration file is:
# database/migrations/2025_10_24_000009_migrate_legacy_data.php
```

### What the Migration Does

1. **Disables foreign key checks** to allow data insertion in any order
2. **Migrates subscription types** from old schema
3. **Migrates users** with full data preservation
4. **Updates users** with company names from brokers table
5. **Migrates drivers** with broker association
6. **Migrates payments** as invoices with financial calculations
7. **Migrates subscriptions** with user lookups
8. **Creates audit log** entry documenting the migration
9. **Re-enables foreign key checks**

### Error Handling

The migration includes try-finally blocks to ensure:

-   Foreign key checks are always re-enabled
-   All data is consistent
-   No partial states remain

---

## Data Integrity Verification

### After Migration, Verify:

```sql
-- 1. Check user count
SELECT COUNT(*) FROM users; -- Should be 10

-- 2. Check drivers count
SELECT COUNT(*) FROM drivers; -- Should be 60

-- 3. Check invoices count
SELECT COUNT(*) FROM invoices; -- Should be 38

-- 4. Check subscriptions
SELECT COUNT(*) FROM subscriptions; -- Should be 1

-- 5. Verify foreign keys
SELECT * FROM drivers WHERE broker_id IS NULL; -- Check orphaned drivers

SELECT * FROM invoices WHERE driver_id NOT IN (SELECT id FROM drivers); -- Check orphaned invoices

-- 6. Check user roles
SELECT role, COUNT(*) FROM users GROUP BY role;
-- Results: admin: 1, broker: 9, supervisor: 0

-- 7. Verify subscription types
SELECT * FROM subscription_types ORDER BY id;
```

---

## Rollback Procedure

If issues occur, you can rollback:

```bash
php artisan migrate:rollback

# This will reverse only the data migration
# It will not delete data (to be safe)
# You must manually truncate tables if needed
```

### Manual Rollback (if needed)

To completely remove migrated data and start over:

1. Uncomment the `down()` method in the migration
2. Run: `php artisan migrate:rollback`
3. Then run migrations again

---

## Data Mapping Reference

### Users (10 total)

| ID  | Name             | Email                   | Role   | Company         | Status |
| --- | ---------------- | ----------------------- | ------ | --------------- | ------ |
| 1   | Ismail Merdjaoui | imerdjaouicad@gmail.com | admin  | NULL            | active |
| 6   | Smash            | 4smash4smash4@gmail.com | broker | NULL            | active |
| 7   | Ismail           | 4dash4dash4@gmail.com   | broker | IntelDelivery   | active |
| 8   | Johnny Bux       | buxjohnny@gmail.com     | broker | 9004-QUEBEC INC | active |
| 9   | BuxBunny         | ytmbux@gmail.com        | broker | NULL            | active |
| 10  | Ismail           | 4gitpilotyo@gmail.com   | broker | Intelbaord      | active |

### Key Statistics

-   **Total Users:** 10 (1 admin, 9 brokers, 0 supervisors)
-   **Total Drivers:** 60 (all active)
-   **Total Invoices:** 38 (37 unpaid, 1 paid)
-   **Total Subscriptions:** 1
-   **Total Subscription Types:** 3

---

## Post-Migration Tasks

After successful migration:

1. ✅ Verify all data appears correct
2. ✅ Test user login with migrated credentials
3. ✅ Check driver listings and driver-broker associations
4. ✅ Verify invoice calculations
5. ✅ Test subscription status and endpoints
6. ✅ Review audit logs for migration entry

---

## Notes & Considerations

### Data Gaps

The following fields in old data were not migrated:

-   **drivers.email** - Not in old schema, set to NULL
-   **invoices.invoice_number** - Auto-generated as 'INV-' + id
-   **user_activity** - No login tracking in old schema
-   **user_preferences** - No preferences stored in old schema
-   **audit_logs** - Only migration event logged

### Name Splitting

Driver full names are split on first space:

-   "Sophie Belanger" → first_name="Sophie", last_name="Belanger"
-   "A B C" → first_name="A", last_name="B C"
-   "SingleName" → first_name="SingleName", last_name=""

### Broker Association

For drivers:

-   If `added_by` is NULL → `broker_id` is NULL
-   If `added_by` points to admin (id=1) → `broker_id` is NULL
-   Otherwise → `broker_id` comes from the adding user's broker_id

---

## Support & Troubleshooting

### Common Issues

**1. Migration fails with foreign key error**

-   Solution: Ensure all referenced users and drivers exist before invoice migration
-   The migration includes ID preservation, so foreign keys should align

**2. Duplicate key errors**

-   Solution: The migration checks if records exist before inserting
-   Run only once per database

**3. Data looks incomplete**

-   Solution: Check that migration completed successfully with no errors
-   Review audit logs for details

---

## Migration Complete ✅

All legacy data has been successfully migrated to the new schema with original IDs preserved!
