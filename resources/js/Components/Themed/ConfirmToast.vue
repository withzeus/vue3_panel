<script setup>
import { useConfirm } from '../../Composables/useConfirm.js';
import { useLocalization } from '../../Composables/useLocalization.js';

const { isOpen, options, executeConfirm, executeCancel } = useConfirm();
const { __ } = useLocalization();
</script>

<template>
  <transition
    enter-active-class="transition duration-300 ease-out"
    enter-from-class="transform translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
    enter-to-class="transform translate-y-0 opacity-100 sm:scale-100"
    leave-active-class="transition duration-200 ease-in"
    leave-from-class="transform translate-y-0 opacity-100 sm:scale-100"
    leave-to-class="transform translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
  >
    <div 
      v-if="isOpen" 
      class="fixed bottom-6 right-6 z-[100] max-w-sm w-full border shadow-2xl rounded-xl p-5 flex flex-col gap-4 backdrop-blur-md transition-all duration-300"
      :style="{ 
        backgroundColor: 'var(--card-bg)', 
        borderColor: 'var(--page-primary-ring)' 
      }"
    >
      <div class="flex items-start gap-3">
        <div class="p-2 rounded-lg shrink-0 mt-0.5 bg-amber-500/10 text-amber-500 dark:bg-amber-500/20">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
          </svg>
        </div>
        
        <div class="flex-1">
          <h4 class="text-xs font-bold uppercase tracking-wider" style="color: var(--page-heading);">
            {{ options.title || __('labels.global.confirm_title') }}
          </h4>
          <p class="text-xs mt-1 opacity-70 leading-normal" style="color: var(--page-text);">
            {{ options.message || __('labels.global.confirm_message') }}
          </p>
        </div>
      </div>
      
      <div class="flex items-center justify-end gap-2 border-t pt-3 border-black/5 dark:border-white/5">
        <button 
          type="button" 
          @click="executeCancel" 
          class="px-3 py-1.5 text-xs font-semibold rounded-lg hover:bg-black/5 dark:hover:bg-white/5 transition-colors focus:outline-none"
          style="color: var(--page-text);"
        >
          {{ options.cancelText || __('labels.global.cancel_btn') }}
        </button>
        
        <button
          type="button"
          @click="executeConfirm"
          class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider rounded-lg text-white transition-all focus:outline-none bg-rose-600 hover:bg-rose-700 shadow-sm"
        >
          {{ options.confirmText || __('labels.global.confirm_btn') }}
        </button>
      </div>
    </div>
  </transition>
</template>