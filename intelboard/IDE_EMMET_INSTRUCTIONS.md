Emmet setup for PhpStorm (Blade templates)

Purpose

- This file documents how to enable Emmet abbreviation expansion (e.g. `.col-12` -> `<div class="col-12"></div>`) in
  PhpStorm for Laravel Blade files. It is a project-level developer instruction only; no repo changes required.

Steps to enable Emmet in PhpStorm

1. Ensure Emmet is enabled
    - Settings / Preferences -> Editor -> Emmet
    - Check "Enable Emmet" and "Expand abbreviation with Tab" (or similar option).

2. Make Emmet work inside Blade (`*.blade.php`) files
   Option A (recommended): Associate `*.blade.php` with HTML
    - Settings / Preferences -> Editor -> File Types
    - Select "HTML" in the Recognized File Types list
    - Add `*.blade.php` to the Registered Patterns for HTML
    - Apply and OK

   Option B: Set Template Data Language for Blade folder
    - Right-click the `resources/views` folder in the Project tool window
    - Select "Mark Directory As" -> "Resources Root" (if not already)
    - Right-click the folder again -> "Override File Type" / "Template Data Language" -> choose HTML

3. Keymap / Tab conflicts
    - Settings / Preferences -> Keymap
    - Search for "Emmet Expand Abbreviation"
    - If it's not bound to Tab, right-click and assign the Tab key when the context is "Editor Text" and there is no
      conflict
    - Or use "Ctrl+Alt+Enter" / "Cmd+Alt+Enter" (examples) if you prefer not to override Tab

4. Blade-specific tips
    - If Blade file type is present and you want to keep it, enable Emmet for PHP/Blade contexts under Editor ->
      Emmet -> "Enable in" -> check PHP or Blade if available
    - Use the "Preview" (Ctrl+Shift+A -> Emmet Expand Abbreviation) to test expansions

Troubleshooting

- Abbreviation doesn't expand with Tab: There's a conflicting Live Template using Tab. Go to Settings -> Editor -> Live
  Templates and check for matching templates. Remove or change the live template if needed.
- Emmet doesn't recognize custom tags: Configure Emmet settings via Editor -> Emmet -> Profiles if required.

Why I can't install Emmet here

- Emmet is an IDE feature/plugin and must be enabled in PhpStorm itself. It's not something that can be installed
  through the repository files.

If you want, I can add an .idea workspace setting that associates `*.blade.php` with HTML, but that would modify IDE
config files. Say the word and I'll create a safe, minimal `.idea` setting that only changes "File Type Associations" if
you want it committed.

