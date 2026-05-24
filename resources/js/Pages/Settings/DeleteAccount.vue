<script setup>
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import SettingsLayout from '@/Layouts/SettingsLayout.vue'
import InputError from '@/Components/InputError.vue'

const confirming = ref(false)

const form = useForm({
    password: '',
})

const submit = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onError: () => form.reset('password'),
    })
}

const cancel = () => {
    confirming.value = false
    form.reset()
    form.clearErrors()
}
</script>

<template>
    <SettingsLayout>
        <Head title="Delete Account" />

        <h2 class="card-title text-error">Delete Account</h2>
        <p class="text-sm text-base-content/70 mb-4">
            Once your account is deleted, all of its resources and data are permanently
            deleted. This action cannot be undone.
        </p>

        <div v-if="!confirming">
            <button class="btn btn-error" @click="confirming = true">
                Delete Account
            </button>
        </div>

        <form v-else @submit.prevent="submit" class="space-y-4">
            <p class="text-sm">
                Enter your password to confirm you want to permanently delete your account.
            </p>

            <div>
                <label class="label" for="password">
                    <span class="label-text">Password</span>
                </label>
                <input
                    id="password"
                    type="password"
                    class="input w-full"
                    v-model="form.password"
                    autocomplete="current-password"
                    autofocus
                />
                <InputError :message="form.errors.password" />
            </div>

            <div class="flex gap-2 justify-end">
                <button type="button" class="btn btn-ghost" @click="cancel">Cancel</button>
                <button type="submit" class="btn btn-error" :disabled="form.processing">
                    <span v-if="form.processing" class="loading loading-spinner loading-sm"></span>
                    Delete Account
                </button>
            </div>
        </form>
    </SettingsLayout>
</template>
