<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    subtitle: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <div
        class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-5 border-b border-[var(--card-border)] transition-colors duration-300">
        <div>
            <h1 style="color: var(--page-heading);"
                class="text-2xl transition-colors duration-300">
                {{ title }}
            </h1>

            <p v-if="subtitle" style="color: var(--page-text);"
                class="text-sm opacity-70 mt-1 transition-colors duration-300">
                {{ subtitle }}
            </p>
        </div>

        <div v-if="$slots.actions" class="flex items-center gap-3">
            <slot name="actions" />
        </div>
    </div>
</template>