<script setup>
import { computed, onMounted } from "vue"; // 1. Import onMounted
import { Head, Link, useForm } from "@inertiajs/vue3";
import { useLocalization } from "../../Composables/useLocalization.js";

import ThemedPage from "../../Components/Themed/Page.vue";
import ThemedPageHeader from "../../Components/Themed/PageHeader.vue";
import ThemedCard from "../../Components/Themed/Card.vue";
import ThemedButton from "../../Components/Themed/Button.vue";
import TextInput from "../../Components/Themed/TextInput.vue";
import InputError from "../../Components/Themed/InputError.vue";
import SelectInput from "../../Components/Themed/SelectInput.vue";

const props = defineProps({
    user: {
        type: Object,
        default: null,
    },
    roles: {
        type: Array,
        default: () => [],
    }
});

const { __ } = useLocalization();

const isEditMode = computed(() => props.user !== null);

const roleOptions = computed(() => {
    return props.roles.map(role => ({
        id: role.id,          
        value: role.name,     
        label: role.display_name
    }));
});

// 2. Initialize the structure with empty fallback keys safely
const form = useForm({
    name: props.user?.name || "",
    email: props.user?.email || "",
    role: "", // Leave blank here to prevent race conditions during boot
    password: "",
    password_confirmation: "",
});

// 3. Hydrate the role parameter explicitly when the component is mounted safely
onMounted(() => {
    if (isEditMode.value) {
        // Look inside the relation array sent by your controller load() statement
        const assignedRole = props.user?.roles?.[0]?.name || props.user?.role;
        if (assignedRole) {
            form.role = assignedRole;
        }
    }
});

const submitForm = () => {
    if (isEditMode.value) {
        form.put(route("users.update", props.user.id), {
            preserveScroll: true,
            onSuccess: () => form.reset("password", "password_confirmation"),
        });
    } else {
        form.post(route("users.store"), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
        });
    }
};
</script>

<template>
    <Head :title="isEditMode ? __('pages.users.edit.title') || 'Edit User' : __('pages.users.create.title') || 'Create User'" />

    <ThemedPage>
        <ThemedPageHeader
            :title="isEditMode ? __('pages.users.edit.heading') || 'Modify User Account' : __('pages.users.create.heading') || 'Provision New Account'"
            :subtitle="isEditMode ? __('pages.users.edit.sub_heading') || 'Update structural clearance groups and account variables.' : __('pages.users.create.sub_heading') || 'Create a new profile entity and assign access layer permissions.'"
        >
            <template #actions>
                <Link :href="route('users.index')">
                    <ThemedButton variant="primary" class="text-xs uppercase tracking-wider font-bold">
                        {{ __("actions.global.back_to_list") || "← Cancel & Return" }}
                    </ThemedButton>
                </Link>
            </template>
        </ThemedPageHeader>

        <div class="w-full mt-4 transition-all duration-300">
            <form @submit.prevent="submitForm">
                <ThemedCard class="space-y-5 p-6">
                    
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider mb-4 opacity-50" style="color: var(--page-text)">
                            {{ __("sections.users.identity_details") || "Account Identity Credentials" }}
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <TextInput 
                                    id="user-name"
                                    v-model="form.name" 
                                    type="text" 
                                    :label="__('labels.users.create.name') || 'Full Name'"
                                    :autofocus="!isEditMode"
                                    :has-error="!!form.errors.name"
                                    :placeholder="__('placeholders.users.name_entry') || 'e.g. John Doe'"
                                />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div>
                                <TextInput 
                                    id="user-email"
                                    v-model="form.email" 
                                    type="email" 
                                    :has-error="!!form.errors.email"
                                    :label="__('labels.users.create.email') || 'Email Address'"
                                    :placeholder="__('placeholders.users.email_entry') || 'operator@domain.com'"
                                />
                                <InputError :message="form.errors.email" />
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-[var(--card-border)] pt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <SelectInput 
                                    v-model="form.role" 
                                    :label="__('labels.users.create.role') || 'Assigned Clearance Role'"
                                    :placeholder="__('placeholders.users.select_role') || 'Select structural role clearance...'" 
                                    :options="roleOptions"
                                    :has-error="!!form.errors.role"
                                />
                                <InputError :message="form.errors.role" />
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-[var(--card-border)] pt-4">
                        <p v-if="isEditMode" class="text-[11px] opacity-40 mb-4 font-medium" style="color: var(--page-text)">
                            {{ __("hints.users.password_leave_blank") || "Leave these security input channels blank if you do not want to override current active signatures." }}
                        </p>
                        <div v-else class="mb-4" />

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <TextInput 
                                    id="user-password"
                                    v-model="form.password" 
                                    type="password" 
                                    :label="__('labels.users.create.password') || 'Account Password'"
                                    :has-error="!!form.errors.password"
                                    placeholder="••••••••"
                                />
                                <InputError :message="form.errors.password" />
                            </div>

                            <div>
                                <TextInput 
                                    id="user-password-confirmation"
                                    v-model="form.password_confirmation" 
                                    type="password" 
                                    :label="__('labels.users.create.password_confirmation') || 'Confirm Password'"
                                    :has-error="!!form.errors.password_confirmation"
                                    placeholder="••••••••"
                                />
                                <InputError :message="form.errors.password_confirmation" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-[var(--card-border)]">
                        <Link :href="route('users.index')">
                            <ThemedButton variant="secondary" type="button" :disabled="form.processing" class="text-xs font-bold">
                                {{ __("actions.global.cancel") || "Abort" }}
                            </ThemedButton>
                        </Link>
                        
                        <ThemedButton variant="primary" type="submit" :disabled="form.processing" class="text-xs font-bold">
                            <span v-if="form.processing">{{ __("actions.global.saving") || "Deploying..." }}</span>
                            <span v-else-if="isEditMode">{{ __("actions.users.update_user") || "Apply Signature Overrides" }}</span>
                            <span v-else>{{ __("actions.users.save_user") || "Commit & Provision Account" }}</span>
                        </ThemedButton>
                    </div>

                </ThemedCard>
            </form>
        </div>
    </ThemedPage>
</template>