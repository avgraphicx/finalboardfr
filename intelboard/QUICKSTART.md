# Quick Start Guide

## System Requirements

-   **PHP:** 8.4+
-   **MySQL:** 8.0+
-   **Composer:** Latest version
-   **Node.js:** 18+ (for front-end assets, optional)

## Installation & Setup

### 1. Environment Configuration

```bash
# Copy environment template
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 2. Database Setup

```bash
# Run migrations and seeders
php artisan migrate:fresh --seed

# Or run migrations only
php artisan migrate

# Run seeders only
php artisan db:seed
```

### 3. Start Development Server

```bash
# Option 1: Built-in PHP server
php artisan serve

# Option 2: Custom port
php artisan serve --port=8001

# Option 3: Bind to all interfaces
php artisan serve --host=0.0.0.0 --port=8000
```

### 4. Access Application

```
URL: http://localhost:8000
```

---

## Test Credentials

Three pre-configured test users are available after running seeders:

### Admin User

```
Email:    admin@example.com
Password: password
Role:     Administrator (full access)
```

### Broker User

```
Email:    broker@example.com
Password: password
Role:     Broker
Company:  Test Logistics
```

### Supervisor User

```
Email:    supervisor@example.com
Password: password
Role:     Supervisor
```

---

## Common Commands

### Database Commands

```bash
# Fresh migration with seeding
php artisan migrate:fresh --seed

# Rollback migrations
php artisan migrate:rollback

# Status of migrations
php artisan migrate:status

# Create seeder
php artisan make:seeder TestSeeder

# Refresh without seeding
php artisan migrate:refresh
```

### Code Generation

```bash
# Create controller
php artisan make:controller NameController --model=ModelName

# Create model with migration
php artisan make:model ModelName -m

# Create migration
php artisan make:migration create_table_name --create=table_name

# Create middleware
php artisan make:middleware MiddlewareName
```

### Cache & Optimization

```bash
# Clear all caches
php artisan cache:clear

# Clear view cache
php artisan view:clear

# Optimize auto-loader
php artisan optimize
```

### Useful Utilities

```bash
# Check routes
php artisan route:list

# Get environment info
php artisan env

# Run tinker (interactive shell)
php artisan tinker
```

---

## Project Structure

```
intelboard/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # All application controllers
│   │   ├── Middleware/         # HTTP middleware
│   │   └── Requests/           # Form request validation (optional)
│   ├── Models/                 # Eloquent models
│   └── Services/               # Business logic layer (optional)
├── bootstrap/
│   ├── app.php                 # Application bootstrap/configuration
│   └── cache/                  # Cached bootstrap files
├── config/                     # Configuration files
├── database/
│   ├── migrations/             # Database migrations
│   ├── seeders/                # Database seeders
│   └── factories/              # Model factories
├── public/
│   ├── index.php               # Application entry point
│   ├── js/                     # JavaScript assets
│   ├── css/                    # CSS assets
│   └── images/                 # Image assets
├── resources/
│   └── views/                  # Blade templates
├── routes/
│   ├── web.php                 # Web routes
│   └── api.php                 # API routes (if applicable)
├── storage/
│   ├── app/                    # Application files
│   ├── logs/                   # Application logs
│   └── framework/              # Framework generated files
├── tests/                      # Application tests
├── vendor/                     # Composer dependencies
├── .env                        # Environment variables
├── .env.example                # Example environment file
├── artisan                     # Laravel CLI
├── composer.json               # Composer configuration
└── package.json                # NPM configuration
```

---

## Configuration Files

### Key Configuration Files

-   `.env` - Environment-specific settings (database, mail, cache, etc.)
-   `config/app.php` - Application name, timezone, locale
-   `config/database.php` - Database connections
-   `config/auth.php` - Authentication configuration
-   `config/session.php` - Session configuration
-   `config/cache.php` - Cache driver configuration
-   `config/queue.php` - Queue job configuration
-   `config/mail.php` - Mail configuration

### Edit .env for Your Environment

```env
APP_NAME=Intelboard
APP_DEBUG=true                 # Set to false in production
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=intelboard
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password

GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_secret
```

---

## Development Workflow

### 1. Create a Migration

```bash
php artisan make:migration create_table_name --create=table_name
```

### 2. Create a Model

```bash
php artisan make:model ModelName -m
```

### 3. Create a Controller

```bash
php artisan make:controller NameController --model=ModelName
```

### 4. Define Routes

```php
// In routes/web.php
Route::resource('items', ItemController::class);
```

### 5. Create Views (in resources/views/)

```blade
@extends('layouts.app')

@section('content')
    {{-- Your content here --}}
@endsection
```

### 6. Run Migration

```bash
php artisan migrate
```

### 7. Test

```bash
# Manual testing via browser or API client
# Or run tests:
php artisan test
```

---

## Debugging Tips

### Enable Debug Mode

Edit `.env`:

```env
APP_DEBUG=true
```

### View Laravel Logs

```bash
# Real-time log viewing
tail -f storage/logs/laravel.log

# Or use Laravel Log Viewer (install package first)
```

### Using Tinker

```bash
php artisan tinker

# Inside tinker:
>>> App\Models\User::all();
>>> $user = App\Models\User::find(1);
>>> $user->email;
```

### SQL Query Debugging

```php
// In controller or model
DB::listen(function ($query) {
    echo $query->sql;
    echo json_encode($query->bindings);
});
```

---

## Production Deployment

### Pre-Deployment Checklist

1. **Environment Setup**

    ```bash
    cp .env.example .env
    # Edit .env with production values
    php artisan key:generate
    ```

2. **Dependencies**

    ```bash
    composer install --no-dev --optimize-autoloader
    ```

3. **Assets**

    ```bash
    npm install
    npm run build  # or: npm run prod
    ```

4. **Database**

    ```bash
    php artisan migrate --force
    ```

5. **Caching**

    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

6. **Permissions**
    ```bash
    chmod -R 775 storage
    chmod -R 775 bootstrap/cache
    ```

### Production .env Settings

```env
APP_DEBUG=false
APP_ENV=production
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

---

## Troubleshooting

### Common Issues

**Problem:** "PHP Fatal error: Uncaught Error: Class not found"
**Solution:** Run `composer dump-autoload`

**Problem:** "SQLSTATE[HY000] [2002] Connection refused"
**Solution:** Check database credentials in `.env` and ensure MySQL is running

**Problem:** "The storage path is not writable"
**Solution:** Run `chmod -R 775 storage bootstrap/cache`

**Problem:** "Route not found"
**Solution:** Run `php artisan route:clear` and `php artisan route:cache`

**Problem:** "419 Page Expired"
**Solution:** Clear sessions: `php artisan session:table` then `php artisan migrate`

---

## Performance Optimization

### Enable Caching

```bash
# Config caching
php artisan config:cache

# Route caching
php artisan route:cache

# View caching
php artisan view:cache
```

### Database Optimization

```bash
# Add database indexes in migrations
$table->index('column_name');

# Use eager loading to prevent N+1 queries
User::with('drivers', 'invoices')->get();
```

### Session Configuration

```env
SESSION_DRIVER=file  # or: database, redis, cookie
CACHE_DRIVER=file    # or: database, redis, memcached
```

---

## Additional Resources

-   **Laravel Documentation:** https://laravel.com/docs
-   **API Documentation:** See `API_ENDPOINTS.md`
-   **Implementation Summary:** See `IMPLEMENTATION_SUMMARY.md`
-   **Eloquent Documentation:** https://laravel.com/docs/eloquent
-   **Blade Templates:** https://laravel.com/docs/blade

---

## Support & Questions

For issues or questions:

1. Check Laravel documentation
2. Review `IMPLEMENTATION_SUMMARY.md` for architecture overview
3. Check `API_ENDPOINTS.md` for endpoint reference
4. Review controller comments for implementation details
5. Check model relationships and scopes

---

**Last Updated:** October 24, 2025
**Laravel Version:** 12
**PHP Version:** 8.4
