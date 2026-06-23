<script setup>
import { computed } from 'vue';

const props = defineProps({
  modelValue: [String, Number],
  id: { type: String, required: true },
  label: { type: String, required: true },
  type: { type: String, default: 'text' },
  placeholder: { type: String, default: '' },
  error: { type: String, default: '' },
  autofocus: { type: Boolean, default: false }
});

defineEmits(['update:modelValue']);
</script>

<template>
  <div class="space-y-1.5 w-full">
    <label v-if="label" :for="id" class="text-xs font-bold uppercase tracking-wider opacity-75"
      style="color: var(--page-text);">
      {{ label }}
    </label>

    <div
      class="flex items-center border rounded-xl p-2.5 transition-all duration-200 focus-within:ring-2 focus-within:ring-[var(--page-primary)]/20"
      :style="{
        borderColor: error ? 'rgb(225, 29, 72)' : 'var(--border-opacity)',
        backgroundColor: 'var(--page-bg)'
      }">
      <input :id="id" :type="type" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="placeholder" :autofocus="autofocus"
        class="w-full bg-transparent border-0 p-0 text-sm focus:ring-0 focus:outline-none placeholder:opacity-40"
        style="color: var(--page-heading);" />
    </div>

    <transition enter-active-class="transition duration-150 ease-out"
      enter-from-class="transform -translate-y-1 opacity-0" enter-to-class="transform translate-y-0 opacity-100">
      <p v-if="error" class="text-xs font-semibold text-rose-600 dark:text-rose-400 mt-1">
        {{ error }}
      </p>
    </transition>
  </div>
</template>