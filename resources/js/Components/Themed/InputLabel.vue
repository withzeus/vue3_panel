<script setup>
defineProps({
    value: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <label class="block text-xs font-semibold tracking-wide mb-1.5 transition-colors duration-300"
        style="color: var(--page-heading);">
        <span v-if="value">{{ value }}</span>
        <span v-else>
            <slot />
        </span>
    </label>
</template>