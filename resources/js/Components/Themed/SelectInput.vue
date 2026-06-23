<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: [String, Number],
    id: { 
        type: String,
        default: () => `select-${Math.random().toString(36).substring(2, 11)}`
    },
    label: String,
    options: Array,
    placeholder: String,
    hasError: {
        type: Boolean,
        default: false,
    }
});

const emit = defineEmits(["update:modelValue"]);

const internalValue = computed({
    get: () => props.modelValue,
    set: (val) => emit("update:modelValue", val)
});

const isPlaceholderActive = computed(() => {
    return props.modelValue === "" || props.modelValue === null || props.modelValue === undefined;
});
</script>

<template>
    <div class="flex flex-col gap-1.5 w-full">
        <label 
            v-if="label" 
            :for="id" 
            class="block text-[12px] font-bold uppercase tracking-wider opacity-75 select-none antialiased"
            style="color: var(--page-text); line-height: 1rem;"
        >
            {{ label }}
        </label>

        <div 
            class="relative w-full h-9 rounded-xl border bg-[var(--card-bg)] transition-all duration-200 focus-within:ring-2"
            :class="[
                hasError
                    ? 'border-rose-500/50 focus-within:ring-rose-500/20 focus-within:border-rose-500'
                    : 'border-[var(--card-border)] focus-within:border-[var(--page-primary)] focus-within:ring-[var(--page-primary)]/20'
            ]"
        >
            <select 
                :id="id"
                v-model="internalValue"
                class="w-full h-full text-xs pl-3 pr-10 bg-transparent border-none outline-none focus:outline-none focus:ring-0 appearance-none cursor-pointer"
                :class="[
                    isPlaceholderActive ? 'text-[var(--page-text)] opacity-50' : 'text-[var(--page-heading)]',
                ]"
            >
                <option v-if="placeholder" value="" class="text-[var(--page-text)] opacity-50 bg-[var(--card-bg)]">
                    {{ placeholder }}
                </option>

                <option v-for="opt in options" :key="opt.value" :value="opt.value"
                    class="text-[var(--page-heading)] bg-[var(--card-bg)] font-medium">
                    {{ opt.label }}
                </option>
            </select>

            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none opacity-50 text-[var(--page-text)]">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </div>
</template>