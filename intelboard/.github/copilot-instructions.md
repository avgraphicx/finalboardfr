# Copilot Project Instructions (Intelboard)

This project uses **Laravel + Blade** templates.

**Rules for GitHub Copilot:**

Never write CSS directly inside Blade files.

Always place all CSS in public/build/assets/custom.css and reference classes only.

Follow Laravel best practices and PSR-12 coding style.

Use English and French translations — no hardcoded text.

Keep code clean, production-ready, and mobile-friendly.

Avoid adding custom workarounds unless explicitly requested.

Never modify .env or sensitive credentials.

Do not use php artisan serve; this project runs on a VPS and is accessed via https://intelboard.ca/

Ensure all routes are properly registered in routes/web.php.

Never use interactive shells like php artisan tinker or php artisan db that wait for user input. When updating or modifying data, always use non-interactive statements. For Laravel, prefer this format:
php artisan db --statement="SQL_QUERY_HERE"
Example:
php artisan db --statement="UPDATE subscriptions SET broker_id = 1 WHERE id = 1;"
If creating fixes or scripts, use Artisan commands or database seeders instead of opening interactive shells.
