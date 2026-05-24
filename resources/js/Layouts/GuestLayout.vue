<script setup>
import { onBeforeUnmount, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import GuestThemeToggle from '@/Components/GuestThemeToggle.vue'
import { useTheme } from '@/Composables/useTheme'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'
const GUEST_THEME_KEY = 'guestTheme'

const applyGuestTheme = () => {
    let saved = null
    try { saved = localStorage.getItem(GUEST_THEME_KEY) } catch (e) {}
    if (!saved) {
        const prefersDark = window.matchMedia?.('(prefers-color-scheme: dark)').matches
        saved = prefersDark ? 'dark' : 'light'
    }
    const next = saved === 'dark' ? 'dark' : 'light'
    document.documentElement.setAttribute('data-theme', next)
}

onMounted(applyGuestTheme)

onBeforeUnmount(() => {
    useTheme().initTheme()
})
</script>

<template>
    <div class="min-h-screen bg-base-200 text-base-content flex flex-col items-center justify-center px-4 py-8">
        <div class="absolute top-4 right-4">
            <GuestThemeToggle />
        </div>

        <Link href="/" class="mb-6 text-2xl font-bold text-base-content">
            {{ appName }}
        </Link>

        <div class="card w-full max-w-md bg-base-100 shadow-xl">
            <div class="card-body">
                <slot />
            </div>
        </div>
    </div>
</template>
