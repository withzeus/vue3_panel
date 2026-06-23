<script setup>
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useLocalization } from '../../../Composables/useLocalization.js';
import ThemedCard from "../../../Components/Themed/Card.vue";
import ThemedButton from "../../../Components/Themed/Button.vue";

const props = defineProps({
    user: Object,
    roles: Array,
    permissions: Array
});

const emit = defineEmits(['saved']);
const { __ } = useLocalization();

const userAccessForm = useForm({
    roles: [],
    allowed_permissions: [],
    denied_permissions: []
});

watch(() => props.user, (newUser) => {
    if (!newUser) return;
    
    userAccessForm.roles = newUser.roles.map(r => r.id);
    userAccessForm.allowed_permissions = [];
    userAccessForm.denied_permissions = [];

    newUser.permissions.forEach(p => {
        if (p.name.startsWith('deny:')) {
            const baseName = p.name.replace('deny:', '');
            const matchingBasePerm = props.permissions.find(bp => bp.name === baseName);
            if (matchingBasePerm) userAccessForm.denied_permissions.push(matchingBasePerm.id);
        } else {
            userAccessForm.allowed_permissions.push(p.id);
        }
    });
}, { immediate: true });

const getPermissionState = (permId) => {
    if (userAccessForm.allowed_permissions.includes(permId)) return 'allow';
    if (userAccessForm.denied_permissions.includes(permId)) return 'block';
    return 'inherit';
};

const setPermissionState = (permId, state) => {
    userAccessForm.allowed_permissions = userAccessForm.allowed_permissions.filter(id => id !== permId);
    userAccessForm.denied_permissions = userAccessForm.denied_permissions.filter(id => id !== permId);

    if (state === 'allow') userAccessForm.allowed_permissions.push(permId);
    if (state === 'block') userAccessForm.denied_permissions.push(permId);
};

const saveUserOverrides = () => {
    userAccessForm.post(route('access-control.users.sync', props.user.id), {
        preserveScroll: true,
        onSuccess: () => emit('saved')
    });
};

// Expose form tracking hooks so Index layout can run its dirty checker guards
defineExpose({ form: userAccessForm });
</script>

<template>
    <ThemedCard class="p-6">
        <div v-if="user" class="space-y-6">
            <div class="flex items-center justify-between border-b border-[var(--card-border)] pb-4">
                <div>
                    <h2 class="text-sm font-bold" style="color: var(--page-heading)">
                        {{ __('labels.access_control.users.edit_heading') || 'Manage Access Details for' }}: {{ user.name }}
                    </h2>
                    <p class="text-xs opacity-60 mt-0.5">{{ user.email }}</p>
                </div>
                <ThemedButton @click="saveUserOverrides" variant="primary" class="text-xs" :disabled="userAccessForm.processing">
                    {{ __('actions.access_control.users.save_btn') || 'Save User Access Rules' }}
                </ThemedButton>
            </div>

            <div class="space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-blue-500">
                    {{ __('labels.access_control.users.roles_assignment') || '1. Assigned System Roles' }}
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label v-for="role in roles" :key="role.id" class="flex items-center gap-2 p-2.5 rounded-lg bg-black/[0.01] dark:bg-white/[0.01] border border-[var(--card-border)] cursor-pointer">
                        <input type="checkbox" :value="role.id" v-model="userAccessForm.roles" class="rounded text-[var(--page-primary)] focus:ring-[var(--page-primary)]" />
                        <span class="text-xs font-semibold" style="color: var(--page-heading)">{{ role.display_name }}</span>
                    </label>
                </div>
            </div>

            <div class="space-y-3 border-t border-[var(--card-border)] pt-4">
                <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--page-heading)">
                    {{ __('labels.access_control.users.perms_assignment') || '2. Granular Permission Overrides' }}
                </h3>
                <p class="text-xs opacity-60">
                    {{ __('labels.access_control.users.override_instructions') || 'Set permissions to Allow (grant explicitly) or Block (deny access regardless of assigned roles).' }}
                </p>

                <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2">
                    <div v-for="perm in permissions.filter(p => !p.name.startsWith('deny:'))" :key="perm.id" class="flex flex-col sm:flex-row sm:items-center justify-between p-3 rounded-xl border border-[var(--card-border)] bg-black/[0.005] dark:bg-white/[0.005] gap-3">
                        <div class="flex flex-col">
                            <span class="text-xs font-semibold" style="color: var(--page-heading)">{{ perm.display_name }}</span>
                            <span class="text-[10px] font-mono opacity-50 tracking-tight">{{ perm.name }}</span>
                        </div>

                        <div class="flex items-center bg-black/5 dark:bg-white/5 p-0.5 rounded-lg text-[11px] self-start sm:self-auto">
                            <button type="button" @click="setPermissionState(perm.id, 'inherit')" class="px-2.5 py-1 rounded-md font-medium transition-all" :class="getPermissionState(perm.id) === 'inherit' ? 'bg-white dark:bg-gray-800 shadow-sm text-[var(--page-heading)]' : 'opacity-60'">
                                {{ __('labels.access_control.states.inherit') || 'Inherit' }}
                            </button>
                            <button type="button" @click="setPermissionState(perm.id, 'allow')" class="px-2.5 py-1 rounded-md font-medium transition-all" :class="getPermissionState(perm.id) === 'allow' ? 'bg-emerald-500 text-white shadow-sm' : 'opacity-60'">
                                {{ __('labels.access_control.states.allow') || 'Allow' }}
                            </button>
                            <button type="button" @click="setPermissionState(perm.id, 'block')" class="px-2.5 py-1 rounded-md font-medium transition-all" :class="getPermissionState(perm.id) === 'block' ? 'bg-rose-500 text-white shadow-sm' : 'opacity-60'">
                                {{ __('labels.access_control.states.block') || 'Block' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div v-else class="h-64 flex flex-col items-center justify-center text-center opacity-40">
            <svg class="w-8 h-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            <p class="text-xs font-medium">{{ __('labels.access_control.users.empty_state') || 'Select a user profile from the sidebar to configure individual role assignments or manual permission overrides.' }}</p>
        </div>
    </ThemedCard>
</template>