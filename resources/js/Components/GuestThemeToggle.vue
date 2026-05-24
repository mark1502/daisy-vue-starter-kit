<script setup>
import { onMounted, ref } from 'vue'
import { Sun, Moon } from '@lucide/vue'

const GUEST_THEME_KEY = 'guestTheme'

const isDark = ref(false)

const apply = (themeName) => {
    document.documentElement.setAttribute('data-theme', themeName)
}

const toggle = () => {
    isDark.value = !isDark.value
    const next = isDark.value ? 'dark' : 'light'
    apply(next)
    localStorage.setItem(GUEST_THEME_KEY, next)
}

onMounted(() => {
    let saved = null
    try { saved = localStorage.getItem(GUEST_THEME_KEY) } catch (e) {}
    if (!saved) {
        const prefersDark = window.matchMedia?.('(prefers-color-scheme: dark)').matches
        saved = prefersDark ? 'dark' : 'light'
    }
    isDark.value = saved === 'dark'
    apply(isDark.value ? 'dark' : 'light')
})
</script>

<template>
    <label class="swap swap-rotate">
        <input type="checkbox" :checked="isDark" @change="toggle" />
        <Sun class="swap-off h-5 w-5" :stroke-width="1.5" />
        <Moon class="swap-on h-5 w-5" :stroke-width="1.5" />
    </label>
</template>
