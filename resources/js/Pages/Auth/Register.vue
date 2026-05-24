<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <h2 class="card-title justify-center mb-2">Create an account</h2>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="label" for="name">
                    <span class="label-text">Name</span>
                </label>
                <input
                    id="name"
                    type="text"
                    class="input w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError :message="form.errors.name" />
            </div>

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
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password" />
            </div>

            <div>
                <label class="label" for="password_confirmation">
                    <span class="label-text">Confirm password</span>
                </label>
                <input
                    id="password_confirmation"
                    type="password"
                    class="input w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-between pt-2">
                <Link :href="route('login')" class="link link-hover text-sm">
                    Already registered?
                </Link>
                <PrimaryButton :processing="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
