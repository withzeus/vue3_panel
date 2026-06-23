<script setup>
import { useLocalization } from "../../Composables/useLocalization.js";

defineProps({
    isExpanded: {
        type: Boolean,
        default: false,
    },
    hasActiveAdvancedFilters: {
        type: Boolean,
        default: false,
    },
});

defineEmits(["toggle", "clear"]);

const { __ } = useLocalization();
</script>

<template>
    <div class="space-y-4 w-full">
        <div class="flex flex-col sm:flex-row gap-3 items-center justify-between w-full">
            <div class="w-full sm:max-w-xs relative flex items-center">
                <slot name="search" />
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                <button 
                    @click="$emit('toggle')" 
                    type="button"
                    class="flex items-center gap-2 px-3.5 py-2 text-xs font-bold uppercase tracking-wider rounded-xl border transition-all duration-200 focus:outline-none"
                    :class="isExpanded
                        ? 'bg-[var(--hd-hover-bg)] text-[var(--hd-primary)] border-[var(--hd-primary)]/20'
                        : 'bg-[var(--card-bg)] border-[var(--border-opacity)] text-[var(--page-text)] hover:bg-black/[0.02] dark:hover:bg-white/[0.02]'
                    "
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    
                    {{ __("actions.filters.toggle_panel") || "Filters" }}
                    
                    <span 
                        v-if="hasActiveAdvancedFilters"
                        class="w-2 h-2 rounded-full bg-[var(--page-primary)] animate-pulse"
                    />
                </button>

                <button 
                    v-if="hasActiveAdvancedFilters" 
                    @click="$emit('clear')" 
                    type="button"
                    class="px-3 py-2 text-xs font-semibold text-rose-600 hover:text-rose-700 transition-colors focus:outline-none"
                >
                    {{ __("actions.filters.clear_advanced") || "Clear Advanced" }}
                </button>
            </div>
        </div>

        <transition 
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="transform -translate-y-2 opacity-0" 
            enter-to-class="transform translate-y-0 opacity-100"
            leave-active-class="transition duration-150 ease-in" 
            leave-from-class="transform translate-y-0 opacity-100"
            leave-to-class="transform -translate-y-2 opacity-0"
        >
            <div 
                v-if="isExpanded"
                class="p-4 rounded-xl border grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 transition-colors"
                style="background-color: var(--page-bg); border-color: var(--border-opacity);"
            >
                <slot name="advanced" />
            </div>
        </transition>
    </div>
</template>