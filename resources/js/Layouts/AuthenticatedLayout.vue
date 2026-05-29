<script setup>
import { computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { LogOut, Settings, User, Flower, Menu } from '@lucide/vue'
import ThemePicker from '@/Components/ThemePicker.vue'
import NavLinks from '@/Components/NavLinks.vue'
import { navBreakpoint } from '@/navigation'

// const appName = import.meta.env.VITE_APP_NAME || 'Laravel' - NOTE: not used by default, but we may want to optionally include

const page = usePage()
const user = computed(() => page.props.auth?.user ?? {})
const initial = computed(() => (user.value?.name || user.value?.email || '?').charAt(0).toUpperCase())

const logout = () => {
    router.post(route('logout'))
}

// Map navBreakpoint -> literal Tailwind class strings. These must be written out
// in full (not built from a variable) so Tailwind's source scanner generates them.
//   inline    — desktop link row: hidden below the breakpoint, flex at/above it
//   hamburger — mobile dropdown: shown below the breakpoint, hidden at/above it
const breakpointClasses = {
    sm: { inline: 'hidden sm:flex', hamburger: 'sm:hidden' },
    md: { inline: 'hidden md:flex', hamburger: 'md:hidden' },
    lg: { inline: 'hidden lg:flex', hamburger: 'lg:hidden' },
    xl: { inline: 'hidden xl:flex', hamburger: 'xl:hidden' },
}
const bp = breakpointClasses[navBreakpoint] ?? breakpointClasses.lg
</script>

<template>
    <div class="min-h-screen bg-base-200 text-base-content">
        <header class="navbar bg-base-100 shadow-sm px-4">
            <div class="flex-none flex items-center gap-1">
                <!-- Mobile menu: hamburger dropdown (below navBreakpoint). Lists the
                     same links as the desktop bar via the shared NavLinks component. -->
                <div class="dropdown" :class="bp.hamburger">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle" aria-label="Open menu">
                        <Menu :size="22" />
                    </div>
                    <NavLinks
                        mode="menu"
                        tabindex="0"
                        class="dropdown-content bg-base-100 rounded-box z-50 mt-3 w-52 p-2 shadow-lg"
                    />
                </div>

                <!-- Brand / home link. Placeholder logo — swap the Flower icon for your own. -->
                <Link :href="route('dashboard')" class="btn btn-ghost btn-circle" aria-label="Dashboard">
                    <Flower :size="24" />
                </Link>
            </div>

            <!-- Desktop link row. The flex-1 wrapper always grows (so the controls on
                 the right stay flush-right even on mobile); the inner row is hidden
                 below navBreakpoint. -->
            <div class="flex-1 min-w-0 px-2">
                <div class="w-full" :class="bp.inline">
                    <NavLinks mode="horizontal" />
                </div>
            </div>

            <div class="flex-none flex items-center gap-1">
                <ThemePicker />

                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar avatar-placeholder">
                        <div class="bg-neutral text-neutral-content w-9 rounded-full">
                            <span class="text-sm">{{ initial }}</span>
                        </div>
                    </div>
                    <ul
                        tabindex="0"
                        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-50 mt-3 w-56 p-2 shadow-lg"
                    >
                        <li class="menu-title">
                            <span class="truncate">{{ user.name || user.email }}</span>
                        </li>
                        <li>
                            <Link :href="route('profile.edit')">
                                <User class="w-4 h-4" :stroke-width="1.5" />
                                Profile
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('password.edit')">
                                <Settings class="w-4 h-4" :stroke-width="1.5" />
                                Settings
                            </Link>
                        </li>
                        <li>
                            <button type="button" @click="logout">
                                <LogOut class="w-4 h-4" :stroke-width="1.5" />
                                Log out
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 py-8">
            <slot />
        </main>
    </div>
</template>
