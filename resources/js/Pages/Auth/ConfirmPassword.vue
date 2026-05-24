<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const form = useForm({
    password: '',
})

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    })
}
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password" />

        <h2 class="card-title justify-center mb-2">Confirm password</h2>

        <p class="text-sm text-base-content/70 mb-2">
            This is a secure area. Please confirm your password before continuing.
        </p>

        <form @submit.prevent="submit" class="space-y-4">
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
                    autofocus
                    autocomplete="current-password"
                />
                <InputError :message="form.errors.password" />
            </div>

            <div class="flex justify-end pt-2">
                <PrimaryButton :processing="form.processing">
                    Confirm
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
