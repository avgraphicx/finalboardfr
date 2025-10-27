# Theme Control Code - Detailed Comments

This document explains the responsible code in each of the 5 key theme files.

---

## FILE 1: `public/build/assets/main.js`

### PURPOSE: Theme Initialization on Page Load

**Key Functions:**

```javascript
// ========== THEME INITIALIZATION LOGIC ==========

// 1. CHECK FOR DARK THEME IN LOCALSTORAGE (on page load)
if (localStorage.getItem("vyzordarktheme")) {
    document.querySelector("html").setAttribute("data-theme-mode", "dark");
    document.querySelector("html").setAttribute("data-menu-styles", "transparent");
    document.querySelector("html").setAttribute("data-header-styles", "transparent");
}
// PURPOSE: If user previously selected dark theme, apply it immediately
// LOCALSTORAGE KEY: "vyzordarktheme"
// SETS: data-theme-mode, data-menu-styles, data-header-styles attributes

// 2. CHECK FOR RTL LAYOUT
if (localStorage.vyzorrtl) {
    let html = document.querySelector("html");
    html.setAttribute("dir", "rtl");
    document.querySelector("#style")?.setAttribute("href", "build/assets/libs/bootstrap/css/bootstrap.rtl.min.css");
}
// PURPOSE: Restore right-to-left layout preference

// 3. CHECK FOR HORIZONTAL LAYOUT
if (localStorage.vyzorlayout) {
    let html = document.querySelector("html");
    html.setAttribute("data-nav-layout", "horizontal");
    document.querySelector("html").setAttribute("data-menu-styles", "transparent");
    html.setAttribute("data-vertical-style", "");
}
// PURPOSE: Restore horizontal navigation layout if previously set

// 4. LOCALSTORAGEBACKUP() FUNCTION
function localStorageBackup() {
    // Restore Primary RGB Color
    if (localStorage.primaryRGB) {
        document.querySelector("html").style.setProperty("--primary-rgb", localStorage.primaryRGB);
    }

    // Restore Background RGB Colors (for dark theme)
    if (localStorage.bodyBgRGB && localStorage.bodylightRGB) {
        document.querySelector("html").style.setProperty("--body-bg-rgb", localStorage.bodyBgRGB);
        document.querySelector("html").style.setProperty("--body-bg-rgb2", localStorage.bodylightRGB);
        document.querySelector("html").style.setProperty("--light-rgb", localStorage.bodylightRGB);
        document.querySelector("html").style.setProperty("--form-control-bg", `rgb(${localStorage.bodylightRGB})`);
        // Also set theme-mode to dark when custom bg colors exist
        let html = document.querySelector("html");
        html.setAttribute("data-theme-mode", "dark");
    }

    // Restore Dark Theme Flag
    if (localStorage.vyzordarktheme) {
        let html = document.querySelector("html");
        html.setAttribute("data-theme-mode", "dark");
    }
}

// PURPOSE: Restore all theme preferences from localStorage before page fully renders
```

---

## FILE 2: `public/build/assets/custom-switcher-D53C3_If.js` (Minified)

### PURPOSE: Real-time Theme Switching via UI Controls

**Key Theme Functions (Extracted from Minified Code):**

```javascript
// ========== LIGHT THEME FUNCTION Be() ==========
function Be() {
    let t = document.querySelector("html");
    t.setAttribute("data-theme-mode", "light");
    t.setAttribute("data-header-styles", "transparent");
    t.setAttribute("data-menu-styles", "transparent");
    // Remove dark theme CSS variables
    t.style.removeProperty("--body-bg-rgb");
    t.style.removeProperty("--body-bg-rgb2");
    t.style.removeProperty("--light-rgb");
    t.style.removeProperty("--form-control-bg");
    t.style.removeProperty("--gray-3");
    t.style.removeProperty("--input-border");
    // Clear localStorage dark theme keys
    localStorage.removeItem("vyzordarktheme");
    // Update checkboxes
    document.querySelector("#switcher-light-theme").checked = true;
    document.querySelector("#switcher-menu-transparent").checked = true;
    document.querySelector("#switcher-header-transparent").checked = true;
    p(); // Call checkOptions() to refresh UI
}

// TRIGGERED BY: Click on #switcher-light-theme button
// LOCALSTORAGE REMOVED: "vyzordarktheme"
// ATTRIBUTES SET: data-theme-mode="light", data-header-styles="transparent", data-menu-styles="transparent"

// ========== DARK THEME FUNCTION et() ==========
function et() {
    let t = document.querySelector("html");
    t.setAttribute("data-theme-mode", "dark");
    t.setAttribute("data-header-styles", "transparent");
    t.setAttribute("data-menu-styles", "dark");
    // Save dark theme flag to localStorage
    localStorage.setItem("vyzordarktheme", true);
    // Update checkboxes
    document.querySelector("#switcher-dark-theme").checked = true;
    document.querySelector("#switcher-menu-dark").checked = true;
    document.querySelector("#switcher-header-dark").checked = true;
    p(); // Call checkOptions() to refresh UI
}

// TRIGGERED BY: Click on #switcher-dark-theme button
// LOCALSTORAGE SET: "vyzordarktheme" = true
// ATTRIBUTES SET: data-theme-mode="dark", data-menu-styles="dark"

// ========== BACKGROUND COLOR CUSTOMIZATION (5 Dark Variants) ==========
// Each background color listener:
de.addEventListener("click", () => {
    // Background Color 1: Deep Blue
    localStorage.setItem("bodyBgRGB", "0,8,52");
    localStorage.setItem("bodylightRGB", "14,22,66");
    c.setAttribute("data-theme-mode", "dark");
    c.setAttribute("data-menu-styles", "dark");
    c.setAttribute("data-header-styles", "dark");
    document.querySelector("html").style.setProperty("--body-bg-rgb", localStorage.bodyBgRGB);
    document.querySelector("html").style.setProperty("--body-bg-rgb2", localStorage.bodylightRGB);
    document.querySelector("html").style.setProperty("--light-rgb", "14,22,66");
    localStorage.setItem("vyzorMenu", "dark");
    localStorage.setItem("vyzorHeader", "dark");
});
// SIMILAR PATTERNS FOR: ue, me, ye, he (5 different color presets)
// ATTRIBUTES SET: data-theme-mode="dark" + specific RGB color values
// LOCALSTORAGE KEYS: bodyBgRGB, bodylightRGB, vyzorMenu, vyzorHeader

// ========== MENU STYLING OPTIONS ==========
// Light Menu
x.addEventListener("click", () => {
    c.setAttribute("data-menu-styles", "light");
    localStorage.setItem("vyzorMenu", "light");
});

// Dark Menu
I.addEventListener("click", () => {
    c.setAttribute("data-menu-styles", "dark");
    localStorage.setItem("vyzorMenu", "dark");
});

// Transparent Menu
O.addEventListener("click", () => {
    c.setAttribute("data-menu-styles", "transparent");
    localStorage.setItem("vyzorMenu", "transparent");
});
// PURPOSE: Control menu sidebar appearance
// ATTRIBUTE: data-menu-styles="light|dark|transparent|color|gradient"
// LOCALSTORAGE: vyzorMenu

// ========== HEADER STYLING OPTIONS ==========
// Light Header
M.addEventListener("click", () => {
    c.setAttribute("data-header-styles", "light");
    localStorage.setItem("vyzorHeader", "light");
});

// Dark Header
E.addEventListener("click", () => {
    c.setAttribute("data-header-styles", "dark");
    localStorage.setItem("vyzorHeader", "dark");
});

// Transparent Header
U.addEventListener("click", () => {
    c.setAttribute("data-header-styles", "transparent");
    localStorage.setItem("vyzorHeader", "transparent");
});
// PURPOSE: Control header appearance
// ATTRIBUTE: data-header-styles="light|dark|transparent|color|gradient"
// LOCALSTORAGE: vyzorHeader

// ========== RESTORE OPTIONS FROM LOCALSTORAGE FUNCTION p() ==========
function p() {
    // Check and apply dark theme from localStorage
    if (localStorage.getItem("vyzordarktheme")) {
        document.querySelector("#switcher-dark-theme").checked = true;
    }

    // Check and apply header color from localStorage
    if (localStorage.getItem("vyzorHeader") === "light") {
        document.querySelector("#switcher-header-light").checked = true;
    }
    if (localStorage.getItem("vyzorHeader") === "dark") {
        document.querySelector("#switcher-header-dark").checked = true;
    }
    if (localStorage.getItem("vyzorHeader") === "transparent") {
        document.querySelector("#switcher-header-transparent").checked = true;
    }

    // Check and apply menu color from localStorage
    if (localStorage.getItem("vyzorMenu") === "light") {
        document.querySelector("#switcher-menu-light").checked = true;
    }
    if (localStorage.getItem("vyzorMenu") === "dark") {
        document.querySelector("#switcher-menu-dark").checked = true;
    }
    if (localStorage.getItem("vyzorMenu") === "transparent") {
        document.querySelector("#switcher-menu-transparent").checked = true;
    }
}

// PURPOSE: Sync UI checkboxes with localStorage preferences
// CALLED: After every theme change to update the switcher UI

// ========== BACKUP LOCALSTORAGE FUNCTION lt() ==========
function lt() {
    // If custom background colors exist, auto-select dark theme UI
    if (localStorage.bodyBgRGB || localStorage.bodylightRGB) {
        document.querySelector("#switcher-dark-theme").checked = true;
        document.querySelector("#switcher-menu-dark").checked = true;
        document.querySelector("#switcher-header-transparent").checked = true;
    }

    // Match checkboxes to stored background color values
    if (localStorage.bodyBgRGB === "0,8,52") {
        document.querySelector("#switcher-background").checked = true;
    }
    if (localStorage.bodyBgRGB === "58, 0, 109") {
        document.querySelector("#switcher-background1").checked = true;
    }
    // ... etc for all 5 color variants
}

// PURPOSE: Restore UI state based on custom theme colors
// CALLED: On initial page load in the main init function
```

---

## FILE 3: `public/build/assets/custom.css`

### PURPOSE: Custom Color Classes

```css
/* ========== CUSTOM COLOR DEFINITIONS ========== */

/* Blue Color Set */
.bluex {
    color: #0082ff !important;
}

.bg-bluex {
    background-color: #0082ff !important;
}

/* PURPOSE: Custom blue color applied to text and backgrounds */

/* Violet Color Set */
.violetx {
    color: #4d5ddb !important;
}

.bg-violetx {
    background-color: #4d5ddb !important;
}

/* PURPOSE: Custom violet color applied to text and backgrounds */

/* Purple Color Set */
.purplex {
    color: #be2beb !important;
}

.bg-purplex {
    background-color: #be2beb !important;
}

/* PURPOSE: Custom purple color applied to text and backgrounds */

/* Pink Color Set */
.pinkx {
    color: #ff69b4 !important;
}

.bg-pinkx {
    background-color: #ff69b4 !important;
}

/* PURPOSE: Custom pink color applied to text and backgrounds */

/* Widget Card Border Colors */
.widget-cardt.bluex {
    border-top: 3px solid #0082ff !important;
}

.widget-cardb.bluex {
    border-bottom: 3px solid #0082ff !important;
}

.widget-cardr.bluex {
    border-right: 3px solid #0082ff !important;
}

.widget-cardl.bluex {
    border-left: 3px solid #0082ff !important;
}

/* PURPOSE: Apply color-coded borders to widget cards based on theme */

/* NOTE: This file does NOT contain dark/light mode media queries.
   Those are likely in Bootstrap CSS or app compiled CSS files.
   This file provides custom color utilities that work with theme variables.
*/
```

---

## FILE 4 & 5: `public/build/assets/app-Dizus16H.css` and `app-HSxA2uDA.css`

### PURPOSE: Application-wide Styling (Compiled from Tailwind/SASS)

```css
/* ========== DARK MODE MEDIA QUERIES ========== */
/* These files are minified/compiled and likely contain: */

@media (prefers-color-scheme: dark) {
    /* Dark mode color schemes applied when system prefers dark mode */
    .dark\:bg-gray-800 {
        background-color: #1f2937;
    }

    .dark\:text-gray-100 {
        color: #f3f4f6;
    }

    /* etc. for all dark mode variants */
}

/* ========== CSS VARIABLES FOR THEME ==========
 
The app CSS likely uses CSS custom properties (variables) for theming:

:root {
    --primary-rgb: 42, 16, 164;           /* Primary color RGB */
--body-bg-rgb:

0
,
8
,
52
; /* Dark theme background */
--body-bg-rgb2:

14
,
22
,
66
; /* Dark theme light variant */
--light-rgb:

14
,
22
,
66
; /* Light text color */
--form-control-bg:

rgb
(
14
,
22
,
66
)
; /* Form field background */
--input-border:

rgba
(
255
,
255
,
255
,
0.1
)
; /* Form field border */
--gray-3:

rgba
(
255
,
255
,
255
,
0.1
)
; /* Gray shade */
}

These are SET BY main.js and custom-switcher.js:
document.

querySelector
(
"html"
)
.style.

setProperty
(
"--primary-rgb"
,
value

)
;
document.

querySelector
(
"html"
)
.style.

setProperty
(
"--body-bg-rgb"
,
value

)
;
etc.

/* PURPOSE: Allow dynamic theme switching without page reload */
```

---

## SUMMARY OF THEME FLOW

```
┌─────────────────────────────────────────────────────────────┐
│                    PAGE LOAD SEQUENCE                        │
└─────────────────────────────────────────────────────────────┘

1. main.js EXECUTES FIRST
   ├─ Checks localStorage for saved theme preferences
   ├─ Applies data-theme-mode="dark|light" attribute to <html>
   ├─ Applies data-menu-styles and data-header-styles
   └─ Sets CSS variables (--primary-rgb, --body-bg-rgb, etc.)

2. custom-switcher.js INITIALIZES UI
   ├─ Binds event listeners to all theme buttons
   ├─ Calls p() to sync checkbox states with localStorage
   ├─ Calls lt() to restore background color UI states
   └─ Ready for user interaction

3. custom.css & app CSS RENDERS
   ├─ Uses data-theme-mode attribute for styling
   ├─ Uses CSS variables for dynamic colors
   ├─ Uses media queries for responsive dark/light modes
   └─ Final visual appearance is displayed

┌─────────────────────────────────────────────────────────────┐
│                    USER INTERACTION                          │
└─────────────────────────────────────────────────────────────┘

4. User Clicks Theme Button
   ├─ Example: Click #switcher-dark-theme button
   ├─ custom-switcher.js EVENT LISTENER triggers
   ├─ Calls et() function:
   │   ├─ Sets data-theme-mode="dark" on <html>
   │   ├─ Sets data-menu-styles="dark" on <html>
   │   ├─ localStorage.setItem("vyzordarktheme", true)
   │   └─ Calls p() to update UI checkboxes
   ├─ CSS media queries re-evaluate
   ├─ CSS variables trigger color updates
   └─ Entire page theme changes instantly

5. Theme Preference Persists
   ├─ localStorage stores: vyzordarktheme, vyzorMenu, vyzorHeader, etc.
   ├─ User closes browser and returns
   ├─ main.js reads localStorage on page load
   ├─ Theme is restored automatically
   └─ User sees their preferred theme immediately
```

---

## LOCALSTORAGE KEYS USED FOR THEME

| Key                   | Purpose                     | Value                                            | Set By             |
|-----------------------|-----------------------------|--------------------------------------------------|--------------------|
| `vyzordarktheme`      | Dark mode enabled flag      | `true` or null                                   | custom-switcher.js |
| `vyzorHeader`         | Header styling              | `light\|dark\|transparent\|color\|gradient`      | custom-switcher.js |
| `vyzorMenu`           | Menu sidebar styling        | `light\|dark\|transparent\|color\|gradient`      | custom-switcher.js |
| `bodyBgRGB`           | Background color RGB values | `"0,8,52"` etc.                                  | custom-switcher.js |
| `bodylightRGB`        | Light background RGB values | `"14,22,66"` etc.                                | custom-switcher.js |
| `primaryRGB`          | Primary accent color RGB    | `"42 ,16, 164"` etc.                             | custom-switcher.js |
| `vyzorlayout`         | Layout type                 | `"horizontal"`                                   | custom-switcher.js |
| `vyzorverticalstyles` | Vertical nav style          | `default\|closed\|overlay\|etc.`                 | custom-switcher.js |
| `vyzornavstyles`      | Nav style                   | `menu-click\|menu-hover\|icon-click\|icon-hover` | custom-switcher.js |

---

## CSS ATTRIBUTES USED FOR THEME

| Attribute             | Purpose               | Values                                                               |
|-----------------------|-----------------------|----------------------------------------------------------------------|
| `data-theme-mode`     | Primary theme mode    | `light`, `dark`                                                      |
| `data-menu-styles`    | Menu appearance       | `light`, `dark`, `transparent`, `color`, `gradient`                  |
| `data-header-styles`  | Header appearance     | `light`, `dark`, `transparent`, `color`, `gradient`                  |
| `data-nav-layout`     | Navigation layout     | `vertical`, `horizontal`                                             |
| `data-vertical-style` | Vertical nav variant  | `default`, `closed`, `overlay`, `icontext`, `detached`, `doublemenu` |
| `data-nav-style`      | Nav interaction style | `menu-click`, `menu-hover`, `icon-click`, `icon-hover`               |

---

## CSS CUSTOM PROPERTIES (VARIABLES)

```css
:root {
    --primary-rgb: RGB values for primary accent color
    --body-bg-rgb: RGB values for dark theme background
    --body-bg-rgb2: RGB values for dark theme light variant
    --light-rgb: RGB values for light text color on dark backgrounds
    --form-control-bg: RGB background for form inputs
    --input-border: Border color for form inputs
    --gray-3: Gray shade for secondary elements
}
```

These are dynamically set via:

```javascript
document.querySelector("html").style.setProperty("--primary-rgb", "42 ,16, 164");
```

---

## HOW TO DEBUG THEME ISSUES

1. **Open Browser DevTools → Application → LocalStorage**
    - Check for `vyzordarktheme`, `vyzorMenu`, `vyzorHeader` keys
    - These should match current visual state

2. **Inspect `<html>` Element**
    - Look for `data-theme-mode`, `data-menu-styles`, `data-header-styles` attributes
    - These should match localStorage values

3. **Check Computed Styles for CSS Variables**
    - Right-click element → Inspect → Styles tab
    - Scroll to find `--primary-rgb`, `--body-bg-rgb`, etc.
    - These should have the RGB values stored in localStorage

4. **Console Debugging**
    - `localStorage.getItem("vyzordarktheme")` → should return `"true"` or null
    - `document.querySelector("html").getAttribute("data-theme-mode")` → should return `"dark"` or `"light"`
    - `getComputedStyle(document.documentElement).getPropertyValue("--primary-rgb")` → should show RGB values


