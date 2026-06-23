<script setup>
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useTheme } from '../../Composables/useTheme.js'; 

const page = usePage();
const { metrics } = useTheme();

const showNotification = ref(false);
const alertMessage = ref('');

watch(
  () => page.props,
  (newProps) => {
    if (newProps.flash?.success) {
      alertMessage.value = newProps.flash.success;
      showNotification.value = true;
      
      setTimeout(() => {
        showNotification.value = false;
      }, 4500);
    }
  },
  { deep: true, immediate: true }
);
</script>

<template>
  <transition
    enter-active-class="transform ease-out duration-300 transition"
    enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
    leave-active-class="transition ease-in duration-200"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <div v-if="showNotification && alertMessage" 
         class="fixed bottom-6 right-6 z-50 max-w-sm w-full border shadow-xl rounded-2xl p-4 flex items-center gap-3 backdrop-blur-md transition-all duration-300"
         :style="{ 
           backgroundColor: metrics.card_bg_color, 
           borderColor: `color-mix(in srgb, ${metrics.primary_hue} 20%, transparent)` 
         }">
      
      <div class="p-2 rounded-xl shrink-0" :style="{ backgroundColor: `color-mix(in srgb, ${metrics.primary_hue} 15%, transparent)`, color: metrics.primary_hue }">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      
      <div class="flex-1">
        <h4 class="text-xs font-bold uppercase tracking-wider" :style="{ color: metrics.heading_color }">System Update</h4>
        <p class="text-xs mt-0.5 opacity-80 leading-normal" :style="{ color: metrics.heading_color }">{{ alertMessage }}</p>
      </div>
      
      <button type="button" @click="showNotification = false" class="opacity-40 hover:opacity-100 transition-opacity p-1">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  </transition>
</template>