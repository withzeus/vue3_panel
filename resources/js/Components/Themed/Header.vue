<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { usePage, Link, router } from '@inertiajs/vue3';
import { useLocalization } from '../../Composables/useLocalization.js';
import ThemedLocaleSwitcher from '../../Components/Themed/LocaleSwitcher.vue';

defineProps({
  sidebarOpen: Boolean
});

defineEmits(['toggle-sidebar']);

const page = usePage();
const { __ } = useLocalization();

const theme = computed(() => page.props.theme_metrics || {});

// Fetch the authenticated user with explicit default value properties
const authUser = computed(() => page.props.auth?.user || { name: 'Operator', email: '—', role: 'Staff' });

// Process Laratrust eager-loaded roles down to a human-readable display string
const displayRole = computed(() => {
  if (authUser.value?.roles && authUser.value.roles.length > 0) {
    return authUser.value.roles.map(r => r.display_name).join(', ');
  }
  return authUser.value?.role || 'User';
});

// Toggle State for the Profile Menu Card
const open = ref(false);
const dropdownRef = ref(null);

const toggleDropdown = () => {
  open.value = !open.value;
};

// Close dropdown automatically if clicking outside the card element
const closeOnClickOutside = (event) => {
  if (open.value && dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    open.value = false;
  }
};

onMounted(() => document.addEventListener('click', closeOnClickOutside));
onUnmounted(() => document.removeEventListener('click', closeOnClickOutside));

const handleLogout = () => {
  router.post(route('logout'));
};
</script>

<template>
  <header
    class="topbar sticky top-0 z-50 w-full h-[70px] border-b border-black/10 shadow-sm transition-all duration-200 bg-[var(--hd-bg)] text-[var(--hd-text)]">
    <div class="px-6 flex items-center justify-between h-full">

      <div id="leftNavbar" class="flex items-center justify-between w-full md:w-64 h-full md:px-4">
        <div id="headerLogo" class="flex items-center transition-all duration-300 transform origin-left">
          <Link href="/" class="block truncate">
            <img src="/assets/images/logos/logo.png" alt="Logo" class="h-8" />
          </Link>
        </div>

        <button id="sidebarToggleBtn" @click="$emit('toggle-sidebar')"
          class="nav-link flex items-center justify-center p-2 rounded-lg transition-all duration-300 text-[var(--hd-text)] hover:text-[var(--hd-primary)] hover:bg-[var(--hd-hover-bg)]"
          aria-label="Toggle Navigation Sidebar">
          <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
      </div>

      <div class="flex items-center gap-1 md:gap-4">
        <ul class="flex items-center gap-1 md:gap-3 m-0 p-0 list-none flex-row">

          <ThemedLocaleSwitcher />

          <li ref="dropdownRef" class="inline-block relative">
            <button @click="toggleDropdown"
              class="nav-link flex items-center justify-center p-1 rounded-full transition-all focus:outline-none hover:shadow-[0_0_0_2px_var(--hd-hover-ring)] focus:shadow-[0_0_0_3px_var(--hd-hover-ring)]">
              <div class="w-8 h-8 md:w-9 md:h-9 overflow-hidden rounded-full border border-black/10 bg-black/5">
                <img src="/assets/images/profile/user-1.jpg" alt="User Avatar" class="w-full h-full object-cover" />
              </div>
            </button>

            <div v-if="open"
              class="absolute right-0 mt-2 w-[calc(100vw-2rem)] sm:w-80 max-w-[320px] border border-black/5 rounded-2xl shadow-xl z-50 p-4 md:p-6 text-left bg-[var(--hd-bg)]">
              
              <div class="flex items-start gap-4 pb-4 border-b border-black/5">
                <img src="/assets/images/profile/user-1.jpg" alt="Profile"
                  class="w-12 h-12 rounded-full object-cover mt-0.5" />
                <div class="space-y-0.5 min-w-0 flex-1">
                  <h5 style="color: var(--hd-heading);" class="font-semibold text-base mb-0 truncate">
                    {{ authUser.name }}
                  </h5>
                  <p class="opacity-60 text-xs truncate" style="color: var(--hd-text);">
                    {{ authUser.email }}
                  </p>
                  
                  <div class="inline-flex items-center pt-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-[var(--hd-hover-bg)] text-[var(--hd-primary)]">
                      {{ displayRole }}
                    </span>
                  </div>
                </div>
              </div>

              <div class="py-3 flex flex-col gap-1 border-b border-black/5 mb-4">
                <Link :href="route('users.profile', authUser.id)" @click="open = false"
                  class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-xl transition-colors hover:bg-[var(--hd-hover-bg)] text-[var(--hd-text)] hover:text-[var(--hd-primary)]">
                  <svg class="w-4 h-4 block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>

                  <span class="text-xs relative top-[1px] inline-block content-center">
                    {{ __("actions.global.edit") || "Modify Profile" }}
                  </span>
                </Link>
              </div>

              <div>
                <button @click="handleLogout"
                  class="block w-full text-center px-4 py-2.5 text-sm font-semibold rounded-xl transition-all bg-[var(--hd-hover-bg)] text-[var(--hd-primary)] hover:bg-[var(--hd-primary)] hover:text-white focus:outline-none">
                  {{ __('labels.login.logout') || 'Log Out' }}
                </button>
              </div>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </header>
</template>