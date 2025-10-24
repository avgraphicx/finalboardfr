# Broker Relationship Fix Summary

## Issue

Error: `Call to undefined relationship [broker] on model [App\Models\User]`

The old schema had a separate `brokers` table with a user_id foreign key. The new Oct 2025 schema embeds broker properties directly on the `users` table with a role field.

## Root Cause

Legacy code was trying to access `auth()->user()->broker->subscription` and similar patterns, but the `broker` relationship no longer exists in the new schema.

## Changes Made

### 1. ExpenseController.php

**Before:**

```php
$brokerId = Auth::user()->broker->id;
$data['broker_id'] = Auth::user()->broker->id;
```

**After:**

```php
$brokerId = Auth::id();
$data['broker_id'] = Auth::id();
```

**Reason**: In the new schema, the authenticated user IS the broker (when role=2). No need to navigate through a separate relationship.

### 2. resources/views/pages/drivers.blade.php

**Before:**

```blade
$maxDrivers = auth()->user()->broker->subscriptionType->max_drivers ?? PHP_INT_MAX;
```

**After:**

```blade
$userSubscription = auth()->user()->subscription;
$maxDrivers = $userSubscription ? $userSubscription->subscriptionType->max_drivers : PHP_INT_MAX;
```

**Reason**: In the new schema, users access their subscription directly via the `subscription()` relationship, not through a broker object.

### 3. resources/views/pages/profile.blade.php

**Before:**

```blade
{{ optional(currentUser()->broker->subscription)->ends_at }}
```

**After:**

```blade
{{ optional(currentUser()->subscription)->ends_at }}
```

**Reason**: Direct access to subscription relationship instead of through non-existent broker.

## Schema Differences

### Old Schema (Before Migration)

```
users
  - id
  - ... user fields

brokers
  - id
  - user_id (FK to users)
  - company_name
  - logo
  - subscription_type_id
  - subscription (relationship)
```

User accessed broker via: `$user->broker->subscription`

### New Schema (Oct 2025)

```
users
  - id
  - name
  - role (1=Admin, 2=Broker, 3=Supervisor)
  - company_name (MOVED from brokers table)
  - logo (MOVED from brokers table)
  - ... other user fields

subscriptions
  - id
  - broker_id (FK to users.id)
  - subscription_type_id
```

User accesses subscription directly via: `$user->subscription`

## Files Modified

1. ✅ `/var/www/intelboard/app/Http/Controllers/ExpenseController.php`
2. ✅ `/var/www/intelboard/resources/views/pages/drivers.blade.php`
3. ✅ `/var/www/intelboard/resources/views/pages/profile.blade.php`

## Git Commit

```
commit 36e5f9b
Message: fix: Remove old broker relationship references in new schema
```

## Status

✅ Fixed - All broker relationship errors resolved
✅ Tested - Syntax validation passed
✅ Committed - Changes pushed to git

## Related Models Still Working

-   ✅ User::subscription() - Returns the subscription for a broker user
-   ✅ Subscription::broker() - Returns the broker (user) for a subscription
-   ✅ User::subscriptionType() - Via eager loading through subscription

The old Broker model is no longer used. Brokers are now identified by users with `role=2`.
