<script setup>
import { useForm, Head, Link } from "@inertiajs/vue3";
import { useLocalization } from "../../Composables/useLocalization.js";

import ThemedPage from "../../Components/Themed/Page.vue";
import ThemedPageHeader from "../../Components/Themed/PageHeader.vue";
import ThemedCard from "../../Components/Themed/Card.vue";
import ThemedButton from "../../Components/Themed/Button.vue";
import TextInput from "../../Components/Themed/TextInput.vue";
import InputError from "../../Components/Themed/InputError.vue";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const { __ } = useLocalization();

// Pre-fill form state mapping directly from the authenticated session instance
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: "",
    password_confirmation: "",
});

const submitForm = () => {
    form.post(route("users.profile.update", props.user.id), {
        preserveScroll: true,
        onSuccess: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>

    <Head :title="__('pages.users/view.title')" />

    <ThemedPage>
        <ThemedPageHeader :title="__('pages.users/view.heading')" :subtitle="__('pages.users/view.sub_heading')">
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
                <ThemedCard class="p-6 space-y-5">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <TextInput id="user-name" v-model="form.name" type="text"
                                :label="__('labels.users/create.name')"
                                :has-error="!!form.errors.name"
                                :placeholder="__('placeholders.users.name_entry') || 'e.g. John Doe'" />
                            <InputError :message="form.errors.name" />
                        </div>

                        <div>
                            <TextInput id="user-email" v-model="form.email" type="email"
                                :has-error="!!form.errors.email" :label="__('labels.users/create.email')"
                                :placeholder="__('placeholders.users.email_entry') || 'operator@domain.com'" />
                            <InputError :message="form.errors.email" />
                        </div>

                    </div>

                    <div class="border-t border-[var(--card-border)] pt-4">
                        <p class="text-[11px] opacity-40 mb-4 font-medium" style="color: var(--page-text)">
                            {{ __("hints.users.password_leave_blank") }}
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <TextInput 
                                    id="user-password"
                                    v-model="form.password" 
                                    type="password" 
                                    :label="__('labels.users/create.password')"
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
                                    :label="__('labels.users/create.password_confirmation')"
                                    :has-error="!!form.errors.password_confirmation"
                                    placeholder="••••••••"
                                />
                                <InputError :message="form.errors.password_confirmation" />
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-[var(--card-border)] pt-4 flex items-center justify-end gap-3">
                        <ThemedButton type="submit" variant="primary" class="text-xs font-bold uppercase tracking-wider"
                            :disabled="form.processing">
                            {{ form.processing ? (__("actions.global.saving") || "Saving Changes...") :
                                (__("actions.global.save") || "Save Settings") }}
                        </ThemedButton>
                    </div>

                </ThemedCard>
            </form>
        </div>
    </ThemedPage>
</template>