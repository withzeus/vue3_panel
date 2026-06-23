<script setup>
defineProps({
    modelValue: { type: String, required: true },
    label: { type: String, required: true }
});
const emit = defineEmits(['update:modelValue']);

const handleInput = (e) => {
    let val = e.target.value;
    if (val && !val.startsWith('#') && val.length === 6) {
        val = '#' + val;
    }
    emit('update:modelValue', val.toUpperCase());
};
</script>

<template>
    <div class="flex flex-col gap-2 w-full">
        <label class="text-xs font-bold uppercase tracking-wider opacity-75" style="color: var(--page-text);">
            {{ label }}
        </label>
        <div class="flex items-center gap-2 border rounded-xl p-2.5 transition-colors duration-300"
            style="border-color: var(--border-opacity); background-color: var(--card-bg);">
            <div class="relative w-8 h-8 rounded-lg overflow-hidden border shrink-0"
                style="border-color: var(--border-opacity);">
                <input type="color" :value="modelValue" @input="handleInput"
                    class="absolute -inset-2 w-12 h-12 p-0 m-0 border-0 cursor-pointer" />
            </div>
            <input type="text" :value="modelValue" @input="handleInput" maxlength="7"
                class="w-full bg-transparent border-0 p-0 text-sm font-mono focus:ring-0 focus:outline-none"
                style="color: var(--page-heading);" />
        </div>
    </div>
</template>