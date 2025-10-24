-- Data Migration Script: iboard_old → iboardnew (Oct 2025 Schema)
-- Preserves all original IDs from legacy database

SET FOREIGN_KEY_CHECKS=0;

-- ============================================================
-- 1. MIGRATE USERS
-- ============================================================
INSERT INTO iboardnew.users (id, name, email, password, phone_number, role, active, company_name, remember_token, created_at, updated_at, google_id, full_name, joining_date)
SELECT
    u.id,
    u.full_name as name,
    u.email,
    u.password,
    u.phone_number,
    CASE
        WHEN u.role = 'admin' THEN 1
        WHEN u.role = 'broker' THEN 2
        WHEN u.role = 'supervisor' THEN 3
        ELSE 3
    END as role,
    CASE WHEN u.status = 'active' THEN 1 ELSE 0 END as active,
    COALESCE(b.company_name, NULL) as company_name,
    u.remember_token,
    u.created_at,
    u.updated_at,
    u.google_id,
    u.full_name,
    u.joined_date as joining_date
FROM iboard_old.users u
LEFT JOIN iboard_old.brokers b ON u.id = b.user_id
WHERE u.id NOT IN (SELECT id FROM iboardnew.users);

-- ============================================================
-- 2. MIGRATE SUBSCRIPTION TYPES
-- ============================================================
INSERT INTO iboardnew.subscription_types (id, name, max_drivers, add_supervisor, custom_invoice, price, created_at, updated_at)
SELECT
    id,
    name,
    max_drivers,
    add_supervisor,
    custom_invoice,
    0 as price,
    IF(UNIX_TIMESTAMP(created_at) = 0, NOW(), created_at) as created_at,
    IF(UNIX_TIMESTAMP(updated_at) = 0, NOW(), updated_at) as updated_at
FROM iboard_old.subscription_type
WHERE id NOT IN (SELECT id FROM iboardnew.subscription_types)
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    max_drivers = VALUES(max_drivers),
    add_supervisor = VALUES(add_supervisor),
    custom_invoice = VALUES(custom_invoice);

-- ============================================================
-- 3. MIGRATE DRIVERS
-- ============================================================
INSERT INTO iboardnew.drivers (id, driver_id, full_name, phone_number, license_number, ssn, default_percentage, default_rental_price, active, created_by, created_at, updated_at)
SELECT
    d.id,
    d.driver_id,
    d.full_name,
    d.phone_number,
    d.license_number,
    d.ssn,
    d.default_percentage,
    d.default_rental_price,
    d.active,
    d.added_by as created_by,
    d.created_at,
    d.updated_at
FROM iboard_old.drivers d
WHERE d.id NOT IN (SELECT id FROM iboardnew.drivers);

-- ============================================================
-- 4. MIGRATE PAYMENTS AS INVOICES
-- ============================================================
INSERT INTO iboardnew.invoices (
    id, broker_id, driver_id, week_number, warehouse_name, invoice_total,
    days_worked, total_parcels, vehicle_rental_price, driver_percentage,
    bonus, cash_advance, penalty, amount_to_pay_driver, broker_share,
    is_paid, pdf_path, paid_at, created_at, updated_at
)
SELECT
    p.id,
    0 as broker_id,
    p.driver_id,
    CAST(SUBSTRING_INDEX(p.week_number, '-', -1) AS UNSIGNED) as week_number,
    COALESCE(p.warehouse, 'Unknown') as warehouse_name,
    COALESCE(p.total_invoice, 0) as invoice_total,
    COALESCE(p.parcel_rows_count, 0) as days_worked,
    COALESCE(p.total_parcels, 0) as total_parcels,
    COALESCE(p.vehicule_rental_price, 0) as vehicle_rental_price,
    COALESCE(p.broker_percentage, 0) as driver_percentage,
    COALESCE(p.bonus, 0) as bonus,
    COALESCE(p.cash_advance, 0) as cash_advance,
    0 as penalty,
    COALESCE(p.final_amount, 0) as amount_to_pay_driver,
    COALESCE(p.broker_van_cut, 0) + COALESCE(p.broker_pay_cut, 0) as broker_share,
    p.paid as is_paid,
    p.pdf_path,
    p.paid_at,
    p.created_at,
    p.updated_at
FROM iboard_old.payments p
WHERE p.id NOT IN (SELECT id FROM iboardnew.invoices);

-- ============================================================
-- 5. MIGRATE SUBSCRIPTIONS
-- ============================================================
INSERT INTO iboardnew.subscriptions (id, broker_id, subscription_type_id, stripe_subscription_id, stripe_status, started_at, ends_at, price_paid, auto_renew, created_at, updated_at)
SELECT
    s.id,
    s.broker_id,
    COALESCE(b.subscription_type_id, 1) as subscription_type_id,
    s.stripe_id as stripe_subscription_id,
    s.stripe_status,
    COALESCE(DATE(s.created_at), CURDATE()) as started_at,
    COALESCE(DATE(s.ends_at), DATE_ADD(CURDATE(), INTERVAL 1 YEAR)) as ends_at,
    0 as price_paid,
    1 as auto_renew,
    s.created_at,
    s.updated_at
FROM iboard_old.subscriptions s
LEFT JOIN iboard_old.brokers b ON s.broker_id = b.id
WHERE s.id NOT IN (SELECT id FROM iboardnew.subscriptions);

-- ============================================================
-- 6. CREATE MIGRATION AUDIT LOG ENTRY
-- ============================================================
INSERT INTO iboardnew.audit_logs (user_id, action, description, model_type, model_id, old_data, new_data, ip_address, created_at)
VALUES (
    1,
    'data_migration',
    'Legacy database migration completed successfully',
    'System',
    0,
    JSON_OBJECT('status', 'pending'),
    JSON_OBJECT(
        'status', 'completed',
        'timestamp', NOW(),
        'tables_migrated', JSON_ARRAY('users', 'drivers', 'invoices', 'subscriptions', 'subscription_types')
    ),
    '127.0.0.1',
    NOW()
);

SET FOREIGN_KEY_CHECKS=1;

-- ============================================================
-- VERIFICATION QUERIES
-- ============================================================
SELECT 'MIGRATION SUMMARY' as report;
SELECT 'USERS' as table_name, COUNT(*) as migrated FROM iboardnew.users
UNION ALL
SELECT 'DRIVERS', COUNT(*) FROM iboardnew.drivers
UNION ALL
SELECT 'INVOICES', COUNT(*) FROM iboardnew.invoices
UNION ALL
SELECT 'SUBSCRIPTIONS', COUNT(*) FROM iboardnew.subscriptions
UNION ALL
SELECT 'SUBSCRIPTION_TYPES', COUNT(*) FROM iboardnew.subscription_types;

SELECT 'DATA INTEGRITY CHECKS' as check_type;
SELECT COUNT(*) as missing_driver_refs FROM iboardnew.invoices
WHERE driver_id NOT IN (SELECT id FROM iboardnew.drivers);
