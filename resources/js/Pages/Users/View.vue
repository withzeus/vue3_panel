<script setup>
import { computed } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import { useLocalization } from "../../Composables/useLocalization.js";

import ThemedPage from "../../Components/Themed/Page.vue";
import ThemedPageHeader from "../../Components/Themed/PageHeader.vue";
import ThemedCard from "../../Components/Themed/Card.vue";
import ThemedButton from "../../Components/Themed/Button.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const { __ } = useLocalization();

// Extract the primary Laratrust role string identifier for dynamic badge asset classes
const primaryRoleName = computed(() => {
  return props.user?.roles?.[0]?.name || props.user?.role || '';
});
</script>

<template>
  <Head :title="`${__('pages.users/view.title') || 'Operator Profile'} — ${user.name}`" />

  <ThemedPage>
    <ThemedPageHeader :title="user.name"
      :subtitle="`UID: ${user.id} — ${__('pages.users/view.sub_heading') || 'Review system authorizations and registered identity records.'}`">
      <template #actions>
        <div class="flex items-center gap-3">
          <Link :href="route('users.index')">
            <ThemedButton variant="primary" class="text-xs font-bold uppercase tracking-wider">
              {{ __("actions.global.back_to_list") || "← Back to Registry" }}
            </ThemedButton>
          </Link>
        </div>
      </template>
    </ThemedPageHeader>

    <div class="max-w-2xl w-full mt-4 transition-all duration-300">
      <ThemedCard class="p-6 space-y-6">

        <div>
          <h3 class="text-xs font-bold uppercase tracking-wider mb-4 opacity-50" style="color: var(--page-text)">
            {{ __("sections.users.identity_details") || "Account Identity Credentials" }}
          </h3>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1">
              <span class="text-[10px] font-bold uppercase tracking-wider opacity-40 block"
                style="color: var(--page-text)">
                {{ __("labels.users/view.name") || "Full Name" }}
              </span>
              <div class="text-sm font-semibold tracking-wide" style="color: var(--page-heading)">
                {{ user.name }}
              </div>
            </div>

            <div class="space-y-1">
              <span class="text-[10px] font-bold uppercase tracking-wider opacity-40 block"
                style="color: var(--page-text)">
                {{ __("labels.users/view.email") || "Email Address" }}
              </span>
              <div class="text-sm font-medium break-all" style="color: var(--page-heading)">
                {{ user.email }}
              </div>
            </div>
          </div>
        </div>

        <div class="border-t border-[var(--card-border)] pt-5">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1.5">
              <span class="text-[10px] font-bold uppercase tracking-wider opacity-40 block"
                style="color: var(--page-text)">
                {{ __("labels.users/view.role") || "System Designation Group" }}
              </span>

              <div class="flex flex-wrap gap-2">
                <template v-if="user.roles && user.roles.length > 0">
                  <div 
                    v-for="role in user.roles" 
                    :key="role.id" 
                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold tracking-wide border bg-[var(--page-bg)] border-[var(--card-border)]"
                  >
                    <span class="w-1.5 h-1.5 rounded-full mr-2 animate-pulse"
                      :class="role.name === 'admin' ? 'bg-amber-500' : 'bg-blue-500'" />
                    <span :style="{ color: 'var(--page-heading)' }">
                      {{ role.display_name }}
                    </span>
                  </div>
                </template>
                
                <div v-else class="inline-flex items-center text-xs opacity-40 italic">
                  {{ __("labels.users.no_role") || "No Assigned Role Profile" }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="border-t border-[var(--card-border)] pt-5">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1">
              <span class="text-[10px] font-bold uppercase tracking-wider opacity-40 block"
                style="color: var(--page-text)">
                {{ __("labels.global.created_at") || "Provisioning Signature Date" }}
              </span>
              <div class="text-xs font-medium opacity-80" style="color: var(--page-text)">
                {{ user.created_at || '—' }}
              </div>
            </div>

            <div class="space-y-1">
              <span class="text-[10px] font-bold uppercase tracking-wider opacity-40 block"
                style="color: var(--page-text)">
                {{ __("labels.global.updated_at") || "Last System Write Mutate" }}
              </span>
              <div class="text-xs font-medium opacity-80" style="color: var(--page-text)">
                {{ user.updated_at || '—' }}
              </div>
            </div>
          </div>
        </div>

      </ThemedCard>
    </div>
  </ThemedPage>
</template>