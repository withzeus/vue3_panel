<script setup>
defineProps({
    modelValue: { type: String, required: true },
    options: { type: Array, required: true },
    name: { type: String, required: true }
});
defineEmits(['update:modelValue']);
</script>

<template>
    <div class="grid grid-cols-2 gap-3 w-full">
        <label v-for="opt in options" :key="opt.value"
            class="relative flex flex-col items-center justify-center p-4 border rounded-xl cursor-pointer transition-all select-none duration-300"
            :style="modelValue === opt.value ? {
                borderColor: 'var(--page-primary)',
                backgroundColor: 'var(--page-primary-alpha)',
                color: 'var(--page-primary)'
            } : {
                borderColor: 'var(--border-opacity)'
            }">
            <input type="radio" :name="name" :value="opt.value" class="sr-only" :checked="modelValue === opt.value"
                @change="$emit('update:modelValue', opt.value)" />
            <span class="text-sm font-semibold capitalize"
                :style="modelValue !== opt.value ? { color: 'var(--page-text)' } : {}">
                {{ opt.label }}
            </span>
        </label>
    </div>
</template>