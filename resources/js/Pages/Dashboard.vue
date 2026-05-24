<script setup>
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const user = computed(() => usePage().props.auth?.user ?? {})
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title">You're logged in{{ user.name ? `, ${user.name}` : '' }}.</h2>
                <p class="text-base-content/70">
                    This is the starter kit dashboard. Edit
                    <code class="kbd kbd-sm">resources/js/Pages/Dashboard.vue</code>
                    to start building.
                </p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
