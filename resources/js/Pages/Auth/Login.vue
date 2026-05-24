<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import Checkbox from '@/Components/Checkbox.vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

defineProps({
    canResetPassword: { type: Boolean, default: true },
    status: { type: String, default: '' },
})

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <h2 class="card-title justify-center mb-2">Log in</h2>

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

            <div>
                <label class="label" for="password">
                    <span class="label-text">Password</span>
                </label>
                <input
                    id="password"
                    type="password"
                    class="input w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
                <InputError :message="form.errors.password" />
            </div>

            <label class="label cursor-pointer justify-start gap-2 p-0">
                <Checkbox v-model="form.remember" />
                <span class="label-text">Remember me</span>
            </label>

            <div class="flex items-center justify-between pt-2">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="link link-hover text-sm"
                >
                    Forgot your password?
                </Link>
                <PrimaryButton :processing="form.processing" class="ml-auto">
                    Log in
                </PrimaryButton>
            </div>
        </form>

        <div class="divider my-2">or</div>

        <p class="text-center text-sm">
            Don't have an account?
            <Link :href="route('register')" class="link link-primary">Register</Link>
        </p>
    </GuestLayout>
</template>
