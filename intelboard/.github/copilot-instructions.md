# Copilot Project Instructions (Intelboard)

This project uses **Laravel + Blade** templates.

**Rules for GitHub Copilot:**

1. Never write CSS directly inside Blade files.
2. Always place all CSS in `public/build/assets/custom.css` and reference classes only.
3. Follow Laravel best practices and PSR-12 coding style.
4. Use English + French translations (no hardcoded text).
5. Keep code clean, production-ready, and mobile-friendly.
6. Avoid adding custom workarounds unless explicitly requested.
7. Never modify `.env` or sensitive credentials.
   Dont use php artisan serve, this is a vps server the app is viewed through https://intelboard.ca/
8. Ensure all routes are properly registered in `routes/web.php`.
