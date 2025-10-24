# API Endpoints Reference

## Authentication Endpoints

### Public Routes (No Auth Required)

```
GET  /login                          - Show login form
POST /login                          - Handle login submission
GET  /auth/google/redirect           - Redirect to Google OAuth
GET  /auth/google/callback           - Handle Google OAuth callback
POST /logout                         - Logout user
GET  /register/complete              - Complete OAuth registration
GET  /lang/{locale}                  - Switch language (en/fr)
```

---

## Protected Routes (Auth Required)

### Dashboard & Home

```
GET  /                               - Dashboard with statistics
POST /dashboard/refresh-stats        - Refresh dashboard statistics
```

---

## Profile Management

```
GET  /profile                        - Show profile
GET  /profile/edit                   - Show profile edit form
PUT  /profile                        - Update profile information
GET  /profile/password               - Show password change form
PUT  /profile/password               - Update password
PUT  /profile/preferences            - Update user preferences (language/theme)
GET  /profile/login-activity         - View login activity history
```

---

## Drivers Management

```
GET  /drivers                        - List all drivers (paginated)
GET  /drivers/data                   - AJAX endpoint for driver data with filtering
GET  /drivers/create                 - Show create driver form
POST /drivers                        - Create new driver
GET  /drivers/{driver}               - Show driver details
GET  /drivers/{driver}/edit          - Show edit driver form
PUT  /drivers/{driver}               - Update driver
DELETE /drivers/{driver}             - Delete driver
DELETE /drivers/bulk-destroy         - Delete multiple drivers
PATCH /drivers/{driver}/toggle-active - Toggle driver active/inactive status
GET  /drivers/{driver}/earnings      - View driver earnings for current week
```

---

## Invoices Management

```
GET  /invoices                       - List all invoices (paginated)
GET  /invoices/create                - Show create invoice form
POST /invoices                       - Create new invoice
GET  /invoices/{invoice}             - Show invoice details
GET  /invoices/{invoice}/edit        - Show edit invoice form
PUT  /invoices/{invoice}             - Update invoice
DELETE /invoices/{invoice}           - Delete invoice
POST /invoices/{invoice}/mark-paid   - Mark single invoice as paid
POST /invoices/mark-paid-bulk        - Mark multiple invoices as paid
```

---

## Statistics & Analytics

```
GET  /stats/weekly                   - Weekly statistics dashboard
GET  /stats/drivers                  - Driver performance statistics
GET  /stats/averages                 - Average metrics for current week
GET  /stats/earnings-by-week         - Earnings breakdown by week (last 12 weeks)
```

---

## Admin-Only Routes (Requires Admin Role)

### User Management

```
GET  /users                          - List all users (paginated)
GET  /users/create                   - Show create user form
POST /users                          - Create new user
GET  /users/{user}                   - Show user details
GET  /users/{user}/edit              - Show edit user form
PUT  /users/{user}                   - Update user
DELETE /users/{user}                 - Delete user
```

### Subscription Management

```
GET  /subscriptions                  - List all subscriptions (paginated)
GET  /subscriptions/create           - Show create subscription form
POST /subscriptions                  - Create new subscription
GET  /subscriptions/{subscription}   - Show subscription details
GET  /subscriptions/{subscription}/edit - Show edit subscription form
PUT  /subscriptions/{subscription}   - Update subscription
DELETE /subscriptions/{subscription} - Delete subscription
```

### Audit Logs

```
GET  /audits                         - List audit logs with filtering
GET  /audits/{audit}                 - Show audit log details
GET  /audits/export/csv              - Export audit logs to CSV
```

---

## Response Codes

| Code | Meaning           |
| ---- | ----------------- |
| 200  | Success           |
| 201  | Created           |
| 204  | No Content        |
| 400  | Bad Request       |
| 401  | Unauthorized      |
| 403  | Forbidden         |
| 404  | Not Found         |
| 422  | Validation Failed |
| 500  | Server Error      |

---

## Common Request Parameters

### Pagination

```
?page=1           - Page number (default: 1)
?per_page=15      - Items per page (default: 15)
```

### Filtering (where supported)

```
?search=text      - Search term
?active_only=true - Show only active items
?status=paid      - Filter by status
```

### AJAX Endpoints

```
/drivers/data     - Supports: page, limit, search, active_only
```

---

## HTTP Methods

-   **GET** - Retrieve data
-   **POST** - Create new resource
-   **PUT** - Update resource
-   **PATCH** - Partial update
-   **DELETE** - Delete resource

---

## Authentication Methods

1. **Email/Password Login**

    - Standard form-based authentication
    - Session stored in cookies

2. **Google OAuth**

    - Single sign-on via Google
    - Automatic account creation/linking

3. **Session-Based**
    - All requests require valid session
    - CSRF protection enabled

---

## Role-Based Access

| Role       | Level | Permissions                          |
| ---------- | ----- | ------------------------------------ |
| Admin      | 1     | Full access to all features          |
| Broker     | 2     | Manage drivers, invoices, view stats |
| Supervisor | 3     | View dashboards, limited management  |

---

## Error Response Format

```json
{
    "message": "Error description",
    "errors": {
        "field_name": ["Error message 1", "Error message 2"]
    }
}
```

---

## Successful Response Examples

### List Response

```json
{
    "data": [
        { "id": 1, "name": "Item 1" },
        { "id": 2, "name": "Item 2" }
    ],
    "meta": {
        "current_page": 1,
        "per_page": 15,
        "total": 50
    }
}
```

### Single Item Response

```json
{
    "id": 1,
    "name": "Item Name",
    "email": "user@example.com",
    "created_at": "2025-10-24T12:00:00Z",
    "updated_at": "2025-10-24T12:00:00Z"
}
```

---

## Rate Limiting

No rate limiting configured by default. Add in middleware if needed:

```php
Route::middleware(['throttle:60,1'])->group(function () {
    // Routes here limited to 60 requests per minute
});
```

---

## CORS & Security Headers

-   CSRF Protection: Enabled on all POST/PUT/DELETE requests
-   Session Timeout: Configurable in `config/session.php`
-   Password Hashing: bcrypt (cost: 12)
-   HTTPS: Recommended for production
