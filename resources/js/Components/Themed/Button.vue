<script setup>

defineProps({
    type: { type: String, default: 'button' },
    variant: { type: String, default: 'primary' },
    disabled: { type: Boolean, default: false },
    processing: { type: Boolean, default: false }
});

</script>

<template>
    <button 
        :type="type" 
        :disabled="disabled || processing"
        class="px-4 py-2.5 text-sm font-semibold rounded-xl transition-all duration-300 select-none disabled:opacity-50 active:scale-[0.98] focus:outline-none"
        :class="{
            /* Primary Variant Style Context */
            'text-white hover:brightness-110 btn-primary-shadow': variant === 'primary',
            
            /* Secondary Variant Style Context */
            'border hover:bg-black/[0.03] dark:hover:bg-white/[0.03]': variant === 'secondary',
            
            /* Danger Variant Style Context */
            'bg-rose-600 text-white hover:bg-rose-700': variant === 'danger'
        }" 
        :style="{
            backgroundColor: variant === 'primary' 
                ? 'var(--page-primary)' 
                : variant === 'secondary' 
                    ? 'var(--page-primary-alpha)' 
                    : '',
            color: variant === 'secondary' ? 'var(--page-heading)' : '',
            borderColor: variant === 'secondary' ? 'var(--card-border)' : ''
        }"
    >
        <slot v-if="!processing" />
        
        <span v-else class="flex items-center justify-center gap-2">
            <svg class="animate-spin h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
            </svg>
            Processing...
        </span>
    </button>
</template>

<style scoped>
/* Injecting the box-shadow via a localized utility class clean wrapper.
  This avoids compiling complex, un-escaped template layout string definitions inside the markup block.
*/
.btn-primary-shadow {
    box-shadow: 0 4px 14px var(--page-primary-ring);
}
</style>