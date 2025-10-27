# Hardcoded Text Audit - Intelboard Views

## Overview

This document lists all Blade template pages that contain hardcoded text that should be converted to translation keys for multi-language support.

---

## Pages with Hardcoded Text

### 1. **resources/views/pages/invoices/index.blade.php**

-   **Line 46:** `<p class="text-muted">Search by Name or Driver ID</p>`
-   **Line 67:** `<p class="text-muted">Upload Invoice PDF for selected driver</p>`
-   **Status:** NEEDS TRANSLATION

### 2. **resources/views/pages/drivers/show.blade.php**

-   **Line 227:** `'<div class="text-center text-muted py-5">No valid data for chart</div>'` (JavaScript)
-   **Status:** NEEDS TRANSLATION

### 3. **resources/views/landing.blade.php**

-   **Line 254:** `<h5 class="fw-semibold">Real-time Monitoring</h5>`
-   **Note:** Names (John Smith, Emily Johnson, Sarah Davis) are intentional and should remain hardcoded
-   **Status:** NEEDS TRANSLATION (title only)

### 4. **resources/views/pages/sign-up-basic.blade.php**

-   **Line 28:** `<h4 class="mb-1 fw-semibold">Sign Up</h4>`
-   **Line 29:** `<p class="mb-4 text-muted fw-normal">Join us by creating a free account !</p>`
-   **Line 33:** `<label for="signin-email" class="form-label text-default">Email</label>`
-   **Line 34:** `placeholder="Enter Email"`
-   **Line 38:** `<label for="signin-password" class="form-label text-default d-block">Password</label>`
-   **Line 41:** `placeholder="Enter Password"`
-   **Line 49:** `<a href="{{ url('index') }}" class="btn btn-primary">Create Account</a>`
-   **Line 52:** `<span class="op-4 fs-13">OR</span>`
-   **Line 60:** `<span class="lh-1 ms-2 fs-13 text-default fw-medium">Signup with Google</span>`
-   **Line 67:** `<span class="lh-1 ms-2 fs-13 text-default fw-medium">Signup with Facebook</span>`
-   **Line 71:** `Already have a account? <a href="{{ url('sign-in-basic') }}" class="text-primary">Sign In</a>`
-   **Status:** NEEDS TRANSLATION

### 5. **resources/views/pages/driver.blade.php**

-   **Line 378:** `<label>Full Name</label>`
-   **Line 381:** `<label>Driver ID</label>`
-   **Line 383:** `<div id="inputHelp" class="form-text">Format : X1111</div>`
-   **Line 385:** `<label>Phone Number</label>`
-   **Line 387:** `<div id="inputHelp" class="form-text">Format : 1234567890</div>`
-   **Line 389:** `<label>License Number</label>`
-   **Line 392:** `<label>SSN</label>`
-   **Line 394:** `<div id="inputHelp" class="form-text">Format : 123456789</div>`
-   **Line 396:** `<label>Default Percentage</label>`
-   **Line 399:** `<label>Default Rental Price</label>`
-   **Line 401:** `<button type="submit" class="btn btn-primary">Save Changes</button>`
-   **Status:** NEEDS TRANSLATION

### 6. **resources/views/pages/empty.blade.php**

-   **Line 10:** `<h1 class="page-title fw-medium fs-18 mb-0">Empty</h1>`
-   **Line 12:** `<li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>`
-   **Line 13:** `<li class="breadcrumb-item active" aria-current="page">Empty</li>`
-   **Line 24:** `<h6 class="mb-0">Empty Card</h6>`
-   **Status:** NEEDS TRANSLATION

### 7. **resources/views/layouts/components/footer.blade.php**

-   **Line 3:** `<a href="javascript:void(0);" class="text-dark fw-medium">Intelboard</a>`
-   **Note:** Brand name - may want to keep hardcoded or translate
-   **Status:** OPTIONAL (Brand name)

### 8. **resources/views/pages/profile.blade.php**

-   **Line 159:** `placeholder="••••••••"` (Password field)
-   **Line 164:** `placeholder="••••••••"` (Password field)
-   **Status:** ACCEPTABLE (Password placeholders are standard)

### 9. **resources/views/layouts/components/switcher.blade.php**

-   Multiple hardcoded configuration labels for theme switcher
-   **Status:** CONFIGURATION UI (May skip or translate)

### 10. **resources/views/layouts/components/custom-switcher.blade.php**

-   Multiple hardcoded configuration labels for theme switcher
-   **Status:** CONFIGURATION UI (May skip or translate)

### 11. **resources/views/welcome.blade.php**

-   **Line 7:** `<title>Laravel</title>`
-   **Line 55:** `<h1 class="mb-1 font-medium">Let's get started</h1>`
-   **Line 56:** `<p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">Laravel has an incredibly rich ecosystem. <br>We suggest starting with the following.</p>`
-   **Status:** DEFAULT LARAVEL PAGE (Can be replaced with proper landing redirect)

### 12. **resources/views/layouts/components/main-header.blade.php**

-   **Line 110:** `<p class="mb-0 fs-16">Notifications</p>`
-   **Line 111:** `<a href="javascript:void(0);" class="badge bg-light text-default border">Clear All</a>`
-   **Status:** NEEDS TRANSLATION

### 13. **resources/views/layouts/components/modal.blade.php**

-   **Line 7:** `placeholder="Search Anything ..."`
-   **Status:** NEEDS TRANSLATION

---

## Priority Classification

### HIGH PRIORITY (User-facing text)

1. pages/invoices/index.blade.php - Search and upload descriptions
2. pages/sign-up-basic.blade.php - Full registration form
3. pages/driver.blade.php - Driver form labels
4. pages/drivers/show.blade.php - Chart error message
5. pages/empty.blade.php - Page titles
6. layouts/components/main-header.blade.php - Notifications
7. layouts/components/modal.blade.php - Search placeholder
8. landing.blade.php - "Real-time Monitoring" title

### MEDIUM PRIORITY (Admin/Configuration)

1. layouts/components/switcher.blade.php - Theme switcher labels
2. layouts/components/custom-switcher.blade.php - Theme switcher labels

### LOW PRIORITY (Optional)

1. layouts/components/footer.blade.php - Brand name
2. welcome.blade.php - Default Laravel page (can be replaced)

### NOT REQUIRED (Standard)

1. pages/profile.blade.php - Password placeholders (••••••)

---

## Summary Statistics

-   **Total Pages with Hardcoded Text:** 13
-   **High Priority Pages:** 8
-   **Medium Priority Pages:** 2
-   **Low Priority Pages:** 2
-   **Optional Pages:** 1

---

## Recommendations

1. **Create Translation Keys:** For all HIGH PRIORITY items first
2. **Update Views:** Replace hardcoded text with `{{ __('messages.key_name') }}`
3. **Test Languages:** Verify language switching works for all updated views
4. **Phase 2:** Handle MEDIUM and LOW priority items
5. **Documentation:** Update translation key reference guide

---

## Translation Key Template

For each hardcoded text, create a key following this pattern:

```php
'page_name_field_name' => 'English Text',
'page_name_field_name_fr' => 'Texte Français',
```

Example:

```php
// messages.php
'invoice_index_search_placeholder' => 'Search by Name or Driver ID',
'invoice_index_upload_description' => 'Upload Invoice PDF for selected driver',
```

Then use in views:

```blade
<p class="text-muted">{{ __('messages.invoice_index_search_placeholder') }}</p>
```
