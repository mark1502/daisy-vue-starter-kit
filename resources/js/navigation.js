// ---------------------------------------------------------------------------
// Main nav bar configuration
// ---------------------------------------------------------------------------
// This is the single edit point for the application's primary navigation.
// Add a link by adding one row to `navItems` below — it automatically appears
// in both the desktop bar and the mobile dropdown.
//
// See the "Navigation" section of README.md for the full field reference.
// ---------------------------------------------------------------------------

// To use lucide icons on links, import them here and set `icon:` on the item.
// (You can also use an image path string instead — see the commented example.)
// import { LayoutDashboard } from '@lucide/vue'


// App-wide active-link style: 'daisy' | 'underline' | 'pill'
//   daisy     — daisyUI built-in active state (soft filled block)
//   underline — Breeze-style bottom border
//   pill      — rounded, more saturated highlight (chip look)
export const activeStyle = 'pill'


// Breakpoint at which links collapse to the hamburger (Tailwind prefix).
// Inline links show at this breakpoint and up; below it, the hamburger
// dropdown is used instead. e.g. 'sm' | 'md' | 'lg' | 'xl'.
export const navBreakpoint = 'lg'


// How the desktop link row distributes its groups horizontally - 'between' | 'start' | 'center' | 'end'
// Any other value falls back to the default 'between'.
// This is the simple global lever. For finer control, give individual links a
// `group` ('start' | 'center' | 'end') and links are bucketed into those segments (Ignored in the stacked mobile dropdown.)
export const navJustify = 'between'


// The navbar links. Add a row to navItems to add a link.
export const navItems = [
    { label: 'Dashboard', route: 'dashboard', group: 'start' },
]

// See the docs folder for full explanation of all navlink and navbar options.

// Example: adding a class to a link
// { label: 'Contacts', route: 'contacts.index', class: 'ml-4' },

// Example: an image-file icon (png/gif/svg) on the right, and an icon-only link (label becomes the tooltip).
// { label: 'Docs', route: 'docs', icon: '/images/docs.svg', iconPosition: 'right' },
// { label: 'Home', route: 'home', icon: LayoutDashboard, iconOnly: true },

// Example: `tooltip` — an optional hover bubble (desktop bar only) - On a normal link it's the bubble text. 
// On an icon-only link it's appended after the label, e.g. tip reads "Home — Go to your homepage".
// { label: 'Home', route: 'home', icon: LayoutDashboard, iconOnly: true, tooltip: 'Go to your homepage' },
// { label: 'Dashboard', route: 'dashboard', tooltip: 'Your activity at a glance' },

// Example: a wildcard active pattern + auth-gated link, with a lucide icon
// {
//   label: 'Reports',
//   route: 'reports.index',
//   active: 'reports.*',                 // keeps this lit on any reports.* child route
//   group: 'start',
//   show: (props) => !!props.auth?.user, // only render when logged in
//   icon: LayoutDashboard,               // lucide component (import it above)
//   iconPosition: 'left',                // 'left' (default) | 'right'
// },
