<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { useLocalization } from '../../../Composables/useLocalization.js';
import ThemedCard from "../../../Components/Themed/Card.vue";
import ThemedButton from "../../../Components/Themed/Button.vue";

const props = defineProps({
    roles: Array,
    permissions: Array,
    selectedRole: Object
});

const emit = defineEmits(['update:selectedRole']);
const { __ } = useLocalization();

const roleForm = useForm({ name: '', display_name: '', description: '' });
const rolePermissionsForm = useForm({ permissions: [] });

const handleRoleClick = (role) => {
    emit('update:selectedRole', role);
    rolePermissionsForm.permissions = role.permissions.map(p => p.id);
};

const submitNewRole = () => {
    roleForm.post(route('access-control.roles.store'), {
        onSuccess: () => {
            roleForm.reset();
            router.reload({ only: ['roles'] });
        }
    });
};

const saveRolePermissions = () => {
    rolePermissionsForm.post(route('access-control.roles.sync', props.selectedRole.id), {
        preserveScroll: true,
        onSuccess: () => router.reload({ only: ['roles'] })
    });
};
</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <div class="space-y-6">
            <form @submit.prevent="submitNewRole">
                <ThemedCard class="p-5 space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--page-heading)">
                        {{ __('labels.access_control.roles.create_title') || 'Create New Role' }}
                    </h3>
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-bold uppercase tracking-wider opacity-60">{{ __('labels.access_control.roles.name') || 'Role Key' }}</label>
                        <input v-model="roleForm.name" type="text" placeholder="e.g., manager" class="w-full px-3 py-2 text-xs rounded-lg border border-[var(--card-border)] bg-transparent text-[var(--page-heading)] focus:outline-none focus:ring-2 focus:ring-[var(--page-primary)]/20" />
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-bold uppercase tracking-wider opacity-60">{{ __('labels.access_control.roles.display_name') || 'Display Label' }}</label>
                        <input v-model="roleForm.display_name" type="text" placeholder="e.g., Branch Manager" class="w-full px-3 py-2 text-xs rounded-lg border border-[var(--card-border)] bg-transparent text-[var(--page-heading)] focus:outline-none focus:ring-2 focus:ring-[var(--page-primary)]/20" />
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] font-bold uppercase tracking-wider opacity-60">{{ __('labels.access_control.roles.description') || 'Description' }}</label>
                        <textarea v-model="roleForm.description" rows="2" placeholder="Describe scope rules..." class="w-full px-3 py-2 text-xs rounded-lg border border-[var(--card-border)] bg-transparent text-[var(--page-heading)] focus:outline-none focus:ring-2 focus:ring-[var(--page-primary)]/20"></textarea>
                    </div>

                    <ThemedButton type="submit" variant="primary" class="w-full text-xs" :disabled="roleForm.processing">
                        {{ __('actions.access_control.roles.create_btn') || 'Save Role' }}
                    </ThemedButton>
                </ThemedCard>
            </form>

            <ThemedCard class="p-5 space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider" style="color: var(--page-heading)">
                    {{ __('labels.access_control.roles.list_heading') || 'Available Roles' }}
                </h3>
                <div class="space-y-1 max-h-64 overflow-y-auto pr-1">
                    <button 
                        v-for="role in roles" :key="role.id" @click="handleRoleClick(role)"
                        type="button" class="w-full text-left px-3 py-2 text-xs font-medium rounded-lg transition-colors flex items-center justify-between"
                        :class="selectedRole?.id === role.id ? 'bg-[var(--page-primary-alpha)] text-[var(--page-primary)]' : 'hover:bg-black/[0.02] dark:hover:bg-white/[0.02] text-[var(--page-text)]'"
                    >
                        <span>{{ role.display_name }}</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] bg-black/5 dark:bg-white/5 opacity-60 font-mono">
                            {{ role.permissions.length }} {{ __('labels.access_control.roles.perms_count') || 'perms' }}
                        </span>
                    </button>
                </div>
            </ThemedCard>
        </div>

        <div class="lg:col-span-2">
            <ThemedCard class="p-6">
                <div v-if="selectedRole" class="space-y-6">
                    <div class="flex items-center justify-between border-b border-[var(--card-border)] pb-4">
                        <div>
                            <h2 class="text-sm font-bold" style="color: var(--page-heading)">
                                {{ __('labels.access_control.matrix.heading') || 'Permissions for' }}: {{ selectedRole.display_name }}
                            </h2>
                            <p class="text-xs opacity-60 mt-0.5">{{ selectedRole.description || __('labels.access_control.roles.no_description') || 'No description provided.' }}</p>
                        </div>
                        <ThemedButton @click="saveRolePermissions" variant="primary" class="text-xs" :disabled="rolePermissionsForm.processing">
                            {{ __('actions.access_control.matrix.save_btn') || 'Update Permissions' }}
                        </ThemedButton>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-[500px] overflow-y-auto pr-2">
                        <label v-for="perm in permissions" :key="perm.id" class="flex items-start gap-3 p-2.5 rounded-xl border border-[var(--card-border)] hover:bg-black/[0.01] dark:hover:bg-white/[0.01] cursor-pointer transition-colors">
                            <input type="checkbox" :value="perm.id" v-model="rolePermissionsForm.permissions" class="mt-0.5 rounded border-gray-300 text-[var(--page-primary)] focus:ring-[var(--page-primary)]" />
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold" style="color: var(--page-heading)">{{ perm.display_name }}</span>
                                <span class="text-[10px] font-mono opacity-50 tracking-tight">{{ perm.name }}</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div v-else class="h-64 flex flex-col items-center justify-center text-center opacity-40">
                    <svg class="w-8 h-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" /></svg>
                    <p class="text-xs font-medium">{{ __('labels.access_control.matrix.empty_state') || 'Select a system role from the sidebar list to modify its authorized access permissions.' }}</p>
                </div>
            </ThemedCard>
        </div>
    </div>
</template>