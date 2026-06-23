<script setup>
import { watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { useLocalization } from '../../../Composables/useLocalization.js';
import ThemedCard from "../../../Components/Themed/Card.vue";

const props = defineProps({
    searchQuery: String,
    users: Array,
    activeUser: Object,
    activeTab: String 
});

const emit = defineEmits(['update:searchQuery', 'selected']);
const { __ } = useLocalization();

let debounceTimeout = null;

watch(() => props.searchQuery, (newQuery) => {
    clearTimeout(debounceTimeout);

    // CRITICAL: Exit completely if the interface state is trying to switch back to roles
    if (props.activeTab !== 'users') return;

    debounceTimeout = setTimeout(() => {
        router.reload({
            data: { search: newQuery },
            only: ['users'],
            preserveState: true,
            preserveScroll: true
        });
    }, 300);
});

const updateSearchInputValue = (event) => {
    emit('update:searchQuery', event.target.value);
};
</script>

<template>
    <ThemedCard class="p-5 space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--page-heading)">
            {{ __('labels.access_control.users.search_title') || 'Find User Profile' }}
        </h3>
        <div class="flex gap-2">
            <input 
                :value="searchQuery" 
                @input="updateSearchInputValue"
                @keydown.enter.prevent="$event.target.blur()"
                type="text" 
                :placeholder="__('placeholders.access_control.users.search') || 'Type name or email...'" 
                class="w-full h-9 px-3 text-xs rounded-lg border border-[var(--card-border)] bg-transparent text-[var(--page-heading)] focus:outline-none focus:ring-2 focus:ring-[var(--page-primary)]/20" 
            />
        </div>

        <div class="space-y-1 max-h-96 overflow-y-auto pr-1">
            <button 
                v-for="user in users" :key="user.id" @click="emit('selected', user)"
                type="button" class="w-full text-left px-3 py-2.5 rounded-lg border border-[var(--card-border)] hover:bg-black/[0.02] dark:hover:bg-white/[0.02] transition-colors flex flex-col gap-0.5"
                :class="activeUser?.id === user.id ? 'bg-[var(--page-primary-alpha)] border-[var(--page-primary)]/40' : ''"
            >
                <span class="text-xs font-bold" style="color: var(--page-heading)">{{ user.name }}</span>
                <span class="text-[10px] opacity-60">{{ user.email }}</span>
            </button>
        </div>
    </ThemedCard>
</template>