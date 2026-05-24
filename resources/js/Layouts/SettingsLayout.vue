<script setup>
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const items = [
    { name: 'Profile', route: 'profile.edit' },
    { name: 'Password', route: 'password.edit' },
    { name: 'Delete Account', route: 'account.edit' },
]
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="text-2xl font-bold mb-6">Settings</h1>

        <div class="flex flex-col md:flex-row gap-6">
            <aside class="md:w-56 shrink-0">
                <ul class="menu bg-base-100 rounded-box shadow-sm w-full">
                    <li v-for="item in items" :key="item.route">
                        <Link
                            :href="route(item.route)"
                            :class="{ 'menu-active': route().current(item.route) }"
                        >
                            {{ item.name }}
                        </Link>
                    </li>
                </ul>
            </aside>

            <section class="flex-1">
                <div class="card bg-base-100 shadow-sm">
                    <div class="card-body">
                        <slot />
                    </div>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
