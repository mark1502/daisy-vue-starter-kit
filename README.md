# daisy-vue-starter-kit

A Laravel 13 starter kit with Inertia.js v3, Vue 3, Tailwind 4, daisyUI 5, Ziggy, and Fortify-based authentication. Breeze-inspired posture (plain Vue, minimal abstraction) with daisyUI components instead of hand-rolled Tailwind markup.

## What's included

- **Laravel 13** + **Inertia.js v3** (SSR off by default)
- **Vue 3** with plain JavaScript (no TypeScript)
- **Tailwind CSS 4** + **daisyUI 5** with ~16 ready-to-use themes and a navbar theme picker
- **Ziggy** for `route()` in Vue components
- **Laravel Fortify** for authentication (headless — every view is an Inertia page)
- **lucide/vue** for icons
- Auth pages: login, register, forgot/reset password, email verification, password confirmation
- Authenticated layout with navbar + theme picker, dashboard, settings (profile, password, delete account)

Two-factor authentication is wired into the User model and migrations but disabled by default — flip the feature on in `config/fortify.php` to enable it.

## Installation

```bash
laravel new my-app --using=mark1502/daisy-vue-starter-kit
cd my-app
composer dev
```

`composer dev` runs the PHP server, queue listener, and Vite dev server concurrently.

Or use composer directly:

```bash
composer create-project mark1502/daisy-vue-starter-kit my-app
cd my-app
composer dev
```

## Project layout

- `resources/js/Pages/Auth/` — Fortify-backed auth pages
- `resources/js/Pages/Settings/` — profile, password, delete-account
- `resources/js/Components/` — `GuestLayout`, `AuthenticatedLayout`, `ThemePicker`, `AuthThemeToggle`, form helpers
- `resources/js/Composables/useTheme.js` — theme state and persistence
- `resources/css/app.css` — Tailwind 4 entry plus daisyUI theme definitions
- `app/Providers/FortifyServiceProvider.php` — binds every Fortify view to an Inertia render call

## Themes

Theme choice persists to `localStorage` under the key `theme` (authenticated areas) and `authTheme` (guest/auth pages, light/dark only). The initial paint is set inline in `app.blade.php` to avoid FOUC.

## Navigation

The main nav bar is driven by a single config file — **`resources/js/navigation.js`**.
Add a link there and it appears in **both** the desktop bar and the mobile
hamburger dropdown (one array, no duplicated markup).

### Adding a link

Add one row to `navItems`:

```js
export const navItems = [
    { label: 'Dashboard', route: 'dashboard' },
    { label: 'Projects', route: 'projects.index' },
]
```

### Full options and details

For all the details about adding links to the navbar and every available option —
refer to the **Navbar and Links** documentation: [`docs/md_files/7. Navbar and Links.md`](docs/md_files/7.%20Navbar%20and%20Links.md)
(also available as a collapsible HTML page at [`docs/html_files/navbar_and_links.html`](docs/html_files/navbar_and_links.html)).

### Logo

The **Flower** icon (left of the bar) is a placeholder brand/home link. Swap it
for your own logo in `AuthenticatedLayout.vue` — it's marked with a comment.

## Documentation

There is documentation about the auth system used in the starter kit located in the docs folder which may be helpful in addition to the official Fortify documentation.  The documentation is available in markdown format and html with collapsable sections.

## Customization

This is a starter kit, not a framework. Edit the Vue pages directly — they're meant to be read top-to-bottom. Resist adding component libraries on top.

## License

MIT
