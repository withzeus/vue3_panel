<script setup>
import { computed } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { useLocalization } from "../../Composables/useLocalization.js";
import { useFilters } from "../../Composables/useFilters.js";
import { useConfirm } from "../../Composables/useConfirm.js";

import ThemedPage from "../../Components/Themed/Page.vue";
import ThemedPageHeader from "../../Components/Themed/PageHeader.vue";
import ThemedCard from "../../Components/Themed/Card.vue";
import ThemedButton from "../../Components/Themed/Button.vue";
import FilterPanel from "../../Components/Themed/FilterPanel.vue";
import SelectInput from "../../Components/Themed/SelectInput.vue";
import DatePicker from "../../Components/Themed/DatePicker.vue";

// Grid Layout Primitive Layers
import ThemedTable from "../../Components/Themed/Table.vue";
import ThemedTableHead from "../../Components/Themed/TableHead.vue";
import ThemedTableRow from "../../Components/Themed/TableRow.vue";
import ThemedDropdown from "../../Components/Themed/Dropdown.vue";
import ThemedDropdownLink from "../../Components/Themed/DropdownLink.vue";
import ThemedPagination from "../../Components/Themed/Pagination.vue";
import EmptyTable from "../../Components/Themed/EmptyTable.vue";

const props = defineProps({
    users: Object,
    filters: Object,
    roles: {
        type: Array,
        default: () => [],
    }
});

const { __ } = useLocalization();
const { requireConfirm } = useConfirm();

const { filterState, isExpanded, toggleFilters, clearFilters } = useFilters(
    "users.index",
    {
        search: props.filters.search || "",
        role: props.filters.role || "",
        created_at: props.filters.created_at || "",
    },
);

const hasActiveAdvancedFilters = computed(() => {
    return filterState.role !== "" || filterState.created_at !== "";
});

// Map dynamic roles sent down by the controller into the filter options dropdown
const roleOptions = computed(() => {
    return props.roles.map(role => ({
        id: role.id,
        value: role.name,
        label: role.display_name
    }));
});

const deleteUser = (id) => {
    requireConfirm({
        title: __("labels.users.delete_title") || "De-authorize Account",
        message: __("labels.users.delete_message") || "This operation wipes this system signature cluster access layer immediately. Proceed?",
        confirmText: __("labels.users.delete_confirm") || "Purge Record",
        cancelText: __("labels.global.cancel_btn") || "Abort",
        onConfirm: () => {
            router.delete(route("users.destroy", id));
        },
    });
};
</script>

<template>
    <Head :title="__('pages.users.title') || 'Manage Users'" />

    <ThemedPage>
        <ThemedPageHeader
            :title="__('pages.users.heading') || 'User Registries'"
            :subtitle="__('pages.users.sub_heading') || 'Maintain structural authorization parameters and credentials.'"
        >
            <template #actions>
                <Link :href="route('users.create')">
                    <ThemedButton variant="primary" class="text-xs uppercase tracking-wider font-bold">
                        {{ __("actions.users.add_new") || "+ Add New User" }}
                    </ThemedButton>
                </Link>
            </template>
        </ThemedPageHeader>

        <ThemedCard class="space-y-4">
            <FilterPanel 
                :is-expanded="isExpanded" 
                :has-active-advanced-filters="hasActiveAdvancedFilters"
                @toggle="toggleFilters" 
                @clear="clearFilters"
            >
                <template #search>
                    <input 
                        v-model="filterState.search" 
                        type="text"
                        :placeholder="__('placeholders.users.search') || 'Search operator name or email address...'"
                        class="w-full h-9 text-xs rounded-xl border px-3 bg-[var(--page-bg)] border-[var(--card-border)] focus:outline-none focus:ring-2 focus:ring-[var(--page-primary)]/20 transition-all"
                        style="color: var(--page-heading)" 
                    />
                </template>

                <template #advanced>
                    <SelectInput 
                        v-model="filterState.role" 
                        :label="__('labels.users.role') || 'System Designation Group'"
                        :placeholder="__('placeholders.users.all_roles') || 'All Account Profiles'" 
                        :options="roleOptions" 
                    />
                    <DatePicker 
                        v-model="filterState.created_at" 
                        :label="__('labels.users.created_at') || 'Creation Epoch Window'" 
                    />
                </template>
            </FilterPanel>

            <ThemedTable>
                <ThemedTableHead>
                    <th class="p-4 font-bold">{{ __("table.users.name") || "Name" }}</th>
                    <th class="p-4 font-bold">{{ __("table.users.email") || "Email Address" }}</th>
                    <th class="p-4 font-bold">{{ __("table.users.role") || "Clearance Role" }}</th>
                    <th class="p-4 max-w-19 font-bold text-center">{{ __("table.users.actions") || "Actions" }}</th>
                </ThemedTableHead>

                <tbody>
                    <template v-if="users.data.length > 0">
                        <ThemedTableRow v-for="user in users.data" :key="user.id">
                            <td class="p-4 font-medium">{{ user.name }}</td>
                            <td class="p-4 opacity-80">{{ user.email }}</td>
                            
                            <td class="p-4">
                                <div class="flex flex-wrap gap-1.5">
                                    <span 
                                        v-for="role in user.roles" 
                                        :key="role.id"
                                        class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-[var(--page-primary)]/10 text-[var(--page-primary)] border border-[var(--page-primary)]/20"
                                    >
                                        {{ role.display_name }}
                                    </span>
                                    <span v-if="!user.roles || user.roles.length === 0" class="text-xs opacity-40 italic">
                                        {{ __("labels.users.no_role") || "No Role Assigned" }}
                                    </span>
                                </div>
                            </td>

                            <td class="p-4 text-center">
                                <ThemedDropdown>
                                    <template #trigger>
                                        <button
                                            :aria-label="__('actions.global.open_menu') || 'Open actions menu'"
                                            class="p-2 hover:bg-black/[0.05] dark:hover:bg-white/[0.05] rounded-lg transition-colors group focus:outline-none"
                                        >
                                            <svg class="w-4 h-4 opacity-60 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 10.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5zm0-6c.83 0 1.5.67 1.5 1.5S12.83 7.5 12 7.5 10.5 6.83 10.5 6s.67-1.5 1.5-1.5zm0 12c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5z" />
                                            </svg>
                                        </button>
                                    </template>

                                    <template #content>
                                        <ThemedDropdownLink :href="route('users.show', user.id)">
                                            <svg class="w-3.5 h-3.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ __("actions.global.view") || "View Details" }}
                                        </ThemedDropdownLink>

                                        <ThemedDropdownLink :href="route('users.edit', user.id)">
                                            <svg class="w-3.5 h-3.5 text-amber-600 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            {{ __("actions.global.edit") || "Modify Profile" }}
                                        </ThemedDropdownLink>

                                        <ThemedDropdownLink 
                                            v-if="user.id !== $page.props.auth.user.id" 
                                            as="button" 
                                            variant="danger" 
                                            @click="deleteUser(user.id)"
                                        >
                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-16v1a3 3 0 003 3h10M9 7h6" />
                                            </svg>
                                            {{ __("actions.global.delete") || "Remove Access" }}
                                        </ThemedDropdownLink>
                                    </template>
                                </ThemedDropdown>
                            </td>
                        </ThemedTableRow>
                    </template>

                    <EmptyTable 
                        v-else 
                        colspan="4" icon="users" 
                        :message="__('pages.users.empty_limits_msg') || 'No structural operators found.'"
                    >
                        <template #action v-if="hasActiveAdvancedFilters">
                            <button 
                                @click="clearFilters"
                                class="mt-1 text-xs font-bold text-[var(--page-primary)] hover:underline focus:outline-none"
                            >
                                {{ __("actions.filters.clear_active") || "Clear Active Filters" }}
                            </button>
                        </template>
                    </EmptyTable>
                </tbody>
            </ThemedTable>

            <ThemedPagination :links="users.links" />
        </ThemedCard>
    </ThemedPage>
</template>