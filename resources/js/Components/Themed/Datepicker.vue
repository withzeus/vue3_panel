<script setup>
import { onMounted, ref, watch } from 'vue';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.css';

const props = defineProps({
  modelValue: String,
  id: {
    type: String,
    default: () => `date-${Math.random().toString(36).substring(2, 11)}`
  },
  label: String,
  placeholder: { type: String, default: 'Select Date...' }
});

const emit = defineEmits(['update:modelValue']);
const dateInput = ref(null);
let fpInstance = null;

onMounted(() => {
  fpInstance = flatpickr(dateInput.value, {
    dateFormat: 'Y-m-d',
    defaultDate: props.modelValue,
    static: true, 
    onChange: (selectedDates, dateStr) => {
      emit('update:modelValue', dateStr);
    }
  });
});

watch(() => props.modelValue, (newVal) => {
  if (fpInstance && newVal !== fpInstance.input.value) {
    fpInstance.setDate(newVal, false);
  }
});
</script>

<template>
  <div class="w-full">
    <label 
      :for="id"
      class="block text-[12px] font-bold uppercase tracking-wider opacity-75 select-none antialiased mb-1.5" 
      style="color: var(--page-text); line-height: 1rem;"
    >
      {{ label }}
    </label>

    <div class="relative flex items-center">
      <input 
        :id="id"
        ref="dateInput"
        type="text"
        :placeholder="placeholder"
        class="w-full h-9 text-xs rounded-xl border pl-3 pr-10 bg-[var(--card-bg)] border-[var(--border-opacity)] focus:outline-none focus:ring-2 focus:ring-[var(--page-primary)]/20 transition-all"
        style="color: var(--page-heading);"
      />
      <div class="absolute right-3 pointer-events-none opacity-40 z-10" style="color: var(--page-text);">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>
    </div>
  </div>
</template>