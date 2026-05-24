<script setup>
import { computed } from 'vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import SettingsLayout from '@/Layouts/SettingsLayout.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const user = computed(() => usePage().props.auth?.user ?? {})

const form = useForm({
    name: user.value.name ?? '',
    email: user.value.email ?? '',
})

const submit = () => {
    form.put('/user/profile-information', {
        preserveScroll: true,
    })
}
</script>

<template>
    <SettingsLayout>
        <Head title="Profile" />

        <h2 class="card-title">Profile Information</h2>
        <p class="text-sm text-base-content/70 mb-4">
            Update your account's name and email address.
        </p>

        <div v-if="form.recentlySuccessful" class="alert alert-success py-2 text-sm mb-4">
            Saved.
        </div>

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
                    autocomplete="email"
                />
                <InputError :message="form.errors.email" />
            </div>

            <div class="flex justify-end pt-2">
                <PrimaryButton :processing="form.processing">Save</PrimaryButton>
            </div>
        </form>
    </SettingsLayout>
</template>
