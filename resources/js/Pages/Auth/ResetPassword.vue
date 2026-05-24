<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    email: { type: String, required: true },
    token: { type: String, required: true },
})

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <h2 class="card-title justify-center mb-2">Reset password</h2>

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
                    autocomplete="username"
                />
                <InputError :message="form.errors.email" />
            </div>

            <div>
                <label class="label" for="password">
                    <span class="label-text">New password</span>
                </label>
                <input
                    id="password"
                    type="password"
                    class="input w-full"
                    v-model="form.password"
                    required
                    autofocus
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

            <div class="flex justify-end pt-2">
                <PrimaryButton :processing="form.processing">
                    Reset password
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
