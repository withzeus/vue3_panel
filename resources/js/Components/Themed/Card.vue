<script setup>
defineProps({
    hoverable: { type: Boolean, default: false },
});
</script>

<template>
    <div
        class="border rounded-sm p-6 transition-all duration-300 shadow-sm"
        :class="{ 'hover:shadow-md hover:scale-[1.01]': hoverable }"
        style="
            background-color: var(--card-bg);
            border-color: var(--border-opacity);
        "
    >
        <slot />
    </div>
</template>
