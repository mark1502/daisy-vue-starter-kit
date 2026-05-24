<script setup>
import { computed } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const props = defineProps({
    status: { type: String, default: '' },
})

const form = useForm({})

const submit = () => {
    form.post(route('verification.send'))
}

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
)
</script>

<template>
    <GuestLayout>
        <Head title="Verify Email" />

        <h2 class="card-title justify-center mb-2">Verify your email</h2>

        <p class="text-sm text-base-content/70">
            Thanks for signing up! Before getting started, please verify your
            email address by clicking the link we just sent you. If you didn't
            receive it, we'll happily send another.
        </p>

        <div v-if="verificationLinkSent" class="alert alert-success py-2 text-sm mt-2">
            A new verification link has been sent to your email.
        </div>

        <form @submit.prevent="submit" class="mt-4">
            <div class="flex items-center justify-between">
                <PrimaryButton :processing="form.processing">
                    Resend verification email
                </PrimaryButton>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="link link-hover text-sm"
                >
                    Log out
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
