<script setup>
import { ref } from 'vue'
import { Palette } from '@lucide/vue'
import { useTheme } from '@/Composables/useTheme'

const { theme, themes, setTheme, previewTheme, revertPreview } = useTheme()

const themeDropdown = ref(null)

const onSelect = (name) => {
    setTheme(name)
    themeDropdown.value?.removeAttribute('open')
}
</script>

<template>
    <details ref="themeDropdown" class="dropdown dropdown-end">
        <summary
            class="self-end mr-2 p-2 rounded-md text-base-content/70 hover:text-base-content hover:scale-120 focus:outline-none transition duration-150 ease-in-out cursor-pointer list-none"
            title="Theme Selector"
        >
            <Palette class="w-4 h-4" :stroke-width="1.5" />
        </summary>
        <ul
            class="menu dropdown-content bg-base-100 rounded-box z-50 w-48 p-2 shadow-lg"
            @mouseleave="revertPreview"
        >
            <li v-for="t in themes" :key="t">
                <button
                    class="capitalize"
                    :class="{ 'font-bold bg-base-200': theme === t }"
                    @mouseenter="previewTheme(t)"
                    @click="onSelect(t)"
                >
                    {{ t }}
                </button>
            </li>
        </ul>
    </details>
</template>
