<script setup>
import { ref, onMounted, computed, nextTick } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import { useLocalization } from '../../Composables/useLocalization.js';
import { useConfirm } from '../../Composables/useConfirm.js'; 

import ThemedPage from "../../Components/Themed/Page.vue";
import ThemedPageHeader from "../../Components/Themed/PageHeader.vue";
import RoleConfiguration from "./Components/RoleConfiguration.vue";
import UserDirectory from "./Components/UserDirectory.vue";
import UserOverrides from "./Components/UserOverrides.vue";

const props = defineProps({
    roles: Array,
    permissions: Array,
    users: { type: Array, default: () => [] }
});

const { __ } = useLocalization();
const { requireConfirm } = useConfirm(); 

const activeTab = ref('roles');
const selectedRole = ref(null);
const activeUserOverride = ref(null);
const userSearchQuery = ref('');
const userOverridesRef = ref(null);

const visiblePermissions = computed(() => {
    return props.permissions.filter(perm => !perm.name.startsWith('deny:'));
});

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('search')) {
        activeTab.value = 'users';
        userSearchQuery.value = urlParams.get('search');
    }
});

/**
 * Handles protected tab switching logic.
 * Internalizes state transition changes inside the configuration guard callback stack.
 */
const changeTab = (targetTab) => {
    if (activeTab.value === targetTab) return;

    // Define the actual shifting operation script
    const proceedWithTabChange = () => {
        if (targetTab === 'roles') {
            activeTab.value = 'roles';
            selectedRole.value = null;

            nextTick(() => {
                userSearchQuery.value = '';
                activeUserOverride.value = null;
            });

            const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.replaceState({ path: cleanUrl }, '', cleanUrl);
        } else if (targetTab === 'users') {
            selectedRole.value = null;
            activeTab.value = targetTab;
        }
    };

    // Trigger confirmation modal if user form contains uncommitted modifications
    if (activeTab.value === 'users' && userOverridesRef.value?.form?.isDirty) {
        requireConfirm({
            title: __("labels.access_control.unsaved_changes_title") || "Unsaved Overrides",
            message: __("labels.access_control.unsaved_changes_message") || "You have unsaved permission modifications. Are you sure you want to change tabs and discard these overrides?",
            confirmText: __("labels.access_control.unsaved_changes_confirm") || "Discard Changes",
            cancelText: __("labels.global.cancel_btn") || "Abort",
            onConfirm: () => {
                proceedWithTabChange();
            },
        });
    } else {
        // Form is clean, jump straight to the target view layout
        proceedWithTabChange();
    }
};

const handleUserSelected = (user) => {
    activeUserOverride.value = user;
};

const rebindActiveUser = () => {
    if (!activeUserOverride.value) return;
    const freshData = props.users.find(u => u.id === activeUserOverride.value.id);
    if (freshData) activeUserOverride.value = freshData;
};
</script>

<template>
    <Head :title="__('pages.access_control.title') || 'Access Control'" />

    <ThemedPage>
        <ThemedPageHeader 
            :title="__('pages.access_control.heading') || 'Access Control Management'"
            :subtitle="__('pages.access_control.sub_heading') || 'Manage system roles, configure resource permissions, and assign direct user overrides.'"
        />

        <div class="flex items-center gap-2 border-b border-[var(--card-border)] mb-6">
            <button 
                @click="changeTab('roles')"
                type="button"
                class="px-4 py-2.5 text-xs font-bold uppercase tracking-wider border-b-2 transition-all focus:outline-none"
                :class="activeTab === 'roles' ? 'border-[var(--page-primary)] text-[var(--page-heading)]' : 'border-transparent opacity-60 text-[var(--page-text)]'"
            >
                {{ __('labels.access_control.tabs.roles_matrix') || 'Roles & Permissions' }}
            </button>
            <button 
                @click="changeTab('users')"
                type="button"
                class="px-4 py-2.5 text-xs font-bold uppercase tracking-wider border-b-2 transition-all focus:outline-none"
                :class="activeTab === 'users' ? 'border-[var(--page-primary)] text-[var(--page-heading)]' : 'border-transparent opacity-60 text-[var(--page-text)]'"
            >
                {{ __('labels.access_control.tabs.user_overrides') || 'User Overrides' }}
            </button>
        </div>

        <div v-if="activeTab === 'roles'">
            <RoleConfiguration 
                :roles="roles" 
                :permissions="visiblePermissions" 
                v-model:selectedRole="selectedRole" 
            />
        </div>

        <div v-if="activeTab === 'users'" class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <UserDirectory 
                v-model:searchQuery="userSearchQuery"
                :active-tab="activeTab"
                :users="users"
                :activeUser="activeUserOverride"
                @selected="handleUserSelected"
            />
            <div class="lg:col-span-2">
                <UserOverrides 
                    ref="userOverridesRef"
                    :user="activeUserOverride"
                    :roles="roles"
                    :permissions="permissions"
                    @saved="rebindActiveUser"
                />
            </div>
        </div>
    </ThemedPage>
</template>