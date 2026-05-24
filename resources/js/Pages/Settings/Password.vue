<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import SettingsLayout from '@/Layouts/SettingsLayout.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.put('/user/password', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) form.reset('password', 'password_confirmation')
            if (form.errors.current_password) form.reset('current_password')
        },
    })
}
</script>

<template>
    <SettingsLayout>
        <Head title="Password" />

        <h2 class="card-title">Update Password</h2>
        <p class="text-sm text-base-content/70 mb-4">
            Use a long, random password to keep your account secure.
        </p>

        <div v-if="form.recentlySuccessful" class="alert alert-success py-2 text-sm mb-4">
            Password updated.
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="label" for="current_password">
                    <span class="label-text">Current password</span>
                </label>
                <input
                    id="current_password"
                    type="password"
                    class="input w-full"
                    v-model="form.current_password"
                    autocomplete="current-password"
                />
                <InputError :message="form.errors.current_password" />
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
                    autocomplete="new-password"
                />
            </div>

            <div class="flex justify-end pt-2">
                <PrimaryButton :processing="form.processing">Save</PrimaryButton>
            </div>
        </form>
    </SettingsLayout>
</template>
