<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

defineProps({
    status: { type: String, default: '' },
})

const form = useForm({
    email: '',
})

const submit = () => {
    form.post(route('password.email'))
}
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <h2 class="card-title justify-center mb-2">Forgot your password?</h2>

        <p class="text-sm text-base-content/70 mb-2">
            Enter your email and we'll send you a link to reset it.
        </p>

        <div v-if="status" class="alert alert-success py-2 text-sm">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="label" for="email">
                    <span class="label-text">Email</span>
                </label>
                <input
                    id="email"
                    type="email"
                    class="input w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError :message="form.errors.email" />
            </div>

            <div class="flex items-center justify-between pt-2">
                <Link :href="route('login')" class="link link-hover text-sm">
                    Back to login
                </Link>
                <PrimaryButton :processing="form.processing">
                    Email reset link
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
