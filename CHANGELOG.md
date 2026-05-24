# Changelog

All notable changes to `daisy-vue-starter-kit` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.1.0] - 2026-05-23

Initial release. Phases 0–6 and 8 of the build plan; Phase 7 (two-factor authentication) is deferred.

### Added

- Laravel 13 skeleton with Inertia.js v3 (SSR off by default) and Vue 3 (plain JavaScript).
- Tailwind CSS 4 + daisyUI 5 with ~16 themes (light, dark, corporate, nord, dim, winter, fantasy, bumblebee, retro, aqua, dracula, caramellatte, coffee, night, autumn, business).
- `useTheme` composable, navbar `ThemePicker` with hover-preview, and inline FOUC-prevention script in `app.blade.php`.
- Ziggy for `route()` in Vue components.
- Laravel Fortify authentication with headless Inertia views: Login, Register, ForgotPassword, ResetPassword, VerifyEmail, ConfirmPassword.
- `GuestLayout` with auth-only light/dark theming and `AuthThemeToggle`.
- `AuthenticatedLayout` with navbar, user dropdown, and theme picker.
- Dashboard placeholder and settings area: Profile (name/email update), Password (change password), DeleteAccount.
- `lucide-vue-next` for tree-shakable icons.
- `User` model uses Fortify's `TwoFactorAuthenticatable` trait and two-factor migration columns are present, so enabling 2FA later is a config flip with no schema change.
- Distribution polish: `composer.json` configured for `laravel new --using=` and `composer create-project`, post-create-project scripts handle key generation, sqlite database creation, migrations, and `npm install`.

### Not yet included

- Two-factor authentication UI (Phase 7) — backend is wired; UI pages and settings section are deferred.
