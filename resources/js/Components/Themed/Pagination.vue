<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div v-if="links.length > 3" class="flex items-center justify-between pt-4">
        <div class="flex flex-1 justify-between sm:hidden">
            <component :is="links[0].url ? Link : 'span'" :href="links[0].url || '#'"
                class="relative inline-flex items-center rounded-xl border border-[var(--card-border)] bg-[var(--card-bg)] px-4 py-2 text-xs font-medium text-[var(--page-text)] transition-colors select-none"
                :class="{ 'opacity-50 pointer-events-none': !links[0].url }" v-html="links[0].label" />
            <component :is="links[links.length - 1].url ? Link : 'span'" :href="links[links.length - 1].url || '#'"
                class="relative ml-3 inline-flex items-center rounded-xl border border-[var(--card-border)] bg-[var(--card-bg)] px-4 py-2 text-xs font-medium text-[var(--page-text)] transition-colors select-none"
                :class="{ 'opacity-50 pointer-events-none': !links[links.length - 1].url }"
                v-html="links[links.length - 1].label" />
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-end">
            <nav class="isolate inline-flex -space-x-px rounded-xl gap-1.5" aria-label="Pagination Navigation Canvas">
                <template v-for="(link, key) in links" :key="key">
                    <span v-if="link.url === null && link.label === '...'"
                        class="relative inline-flex items-center px-3.5 py-2 text-xs font-semibold text-[var(--page-text)] opacity-50 select-none">
                        ...
                    </span>

                    <component v-else :is="link.url && !link.active ? Link : 'button'" :href="link.url"
                        :disabled="!link.url || link.active"
                        class="relative inline-flex items-center px-3.5 py-2 text-xs font-bold rounded-xl border transition-all duration-150 select-none"
                        :class="[
                            link.active
                                ? 'bg-[var(--page-primary)] border-[var(--page-primary)] text-white shadow-sm shadow-[var(--page-primary)]/20'
                                : 'bg-[var(--card-bg)] border-[var(--card-border)] text-[var(--page-heading)] hover:bg-black/[0.03] dark:hover:bg-white/[0.03]',
                            !link.url ? 'opacity-40 cursor-not-allowed' : ''
                        ]" v-html="link.label" />
                </template>
            </nav>
        </div>
    </div>
</template>