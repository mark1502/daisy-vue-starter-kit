<script setup>
defineProps({
    processing: {
        type: Boolean,
        default: false,
    },
    type: {
        type: String,
        default: 'submit',
    },
})
</script>

<template>
    <button
        :type="type"
        class="btn btn-primary"
        :class="{ 'btn-disabled': processing }"
        :disabled="processing"
    >
        <span v-if="processing" class="loading loading-spinner loading-sm"></span>
        <slot />
    </button>
</template>
