<script setup>
const model = defineModel({
    type: Boolean,
    default: false,
})
</script>

<template>
    <input
        type="checkbox"
        v-model="model"
        class="checkbox checkbox-sm checkbox-primary"
    />
</template>
