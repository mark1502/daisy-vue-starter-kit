<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { Rocket, Flower } from '@lucide/vue'
import ThemePicker from '@/Components/ThemePicker.vue'
import GuestThemeToggle from '@/Components/GuestThemeToggle.vue'

const user = computed(() => usePage().props.auth?.user ?? null)
</script>

<template>
    <div class="min-h-screen bg-base-100 text-base-content">
        <div class="navbar bg-base-200">
            <div class="flex-1">
                <Flower class="ml-2" :size="24" />
                <!-- <span class="text-lg font-semibold px-4">daisy-vue-starter-kit</span> -->
            </div>
            <div class="flex-none flex items-center gap-2 pr-4">
                <template v-if="user">
                    <Link :href="route('dashboard')" class="btn btn-ghost btn-sm">
                        Dashboard
                    </Link>
                </template>
                <template v-else>
                    <Link :href="route('login')" class="btn btn-ghost btn-sm">
                        Log in
                    </Link>
                    <Link :href="route('register')" class="btn btn-primary btn-sm">
                        Register
                    </Link>
                </template>
                <ThemePicker v-if="user" />
                <GuestThemeToggle v-else />
            </div>
        </div>

        <div class="p-8 flex items-center gap-2">
            <Rocket :size="32" />
            <h1 class="text-2xl font-bold">Welcome to daisy-vue-starter-kit</h1>
        </div>

        <!-- <div class="p-8 flex gap-2">
            <button class="btn btn-primary">Primary</button>
            <button class="btn btn-secondary">Secondary</button>
            <button class="btn btn-accent">Accent</button>
        </div> -->
    </div>
</template>
