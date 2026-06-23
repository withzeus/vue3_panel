<script setup>
import { computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { useLocalization } from '../../Composables/useLocalization.js';

const page = usePage();
const { __ } = useLocalization();

// Safely access current locale from Inertia shared global properties
const currentLocale = computed(() => page.props.locale || 'en');

// Map available language profiles natively
const languages = {
  en: {
    name: 'English (UK)',
    flag: '/assets/images/svgs/icon-flag-en.svg'
  },
  mm: {
    name: 'မြန်မာ (Burmese)',
    flag: '/assets/images/svgs/icon-flag-mm.svg' // Ensure you add this asset flag
  }
};

const activeLanguage = computed(() => languages[currentLocale.value] || languages.en);

const changeLocale = (localeCode) => {
  if (localeCode === currentLocale.value) return;

  // Make a reactive Inertia POST request to update the session language configuration
  router.post(route('settings.locale.update'), { locale: localeCode }, {
    preserveScroll: true,
    onSuccess: () => {
      // Hard refresh to re-trigger global asset/translation updates if necessary
      window.location.reload();
    }
  });
};
</script>

<template>
  <li class="inline-block relative group min-w-10">
    <button type="button"
      class="nav-link flex items-center justify-center p-2 rounded-full transition-colors hover:bg-[var(--hd-hover-bg)] focus:outline-none focus:bg-[var(--hd-hover-bg)]"
      :aria-label="`Change language. Current: ${activeLanguage.name}`">
      <img :src="activeLanguage.flag" :alt="activeLanguage.name" class="w-5 h-5 rounded-full object-cover shadow-sm" />
    </button>

    <div
      class="hidden group-focus-within:block group-hover:block absolute right-0 mt-2 w-52 border rounded-xl shadow-xl z-50 py-2 border-black/5 dark:border-white/5 bg-[var(--hd-bg)]"
      style="box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);">
      <div class="px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider opacity-40" style="color: var(--hd-text);">
        {{ __('labels.global.select_language') || 'Select Language' }}
      </div>

      <button v-for="(lang, code) in languages" :key="code" @click="changeLocale(code)" type="button"
        class="w-full flex items-center gap-3 px-4 py-2 text-sm text-left transition-colors hover:bg-[var(--hd-hover-bg)] focus:outline-none focus:bg-[var(--hd-hover-bg)]"
        :class="currentLocale === code ? 'text-[var(--hd-primary)] font-semibold' : 'text-[var(--hd-text)]'">
        <img :src="lang.flag" :alt="lang.name"
          class="w-5 h-5 rounded-full object-cover transition-transform group-hover:scale-105"
          :class="{ 'ring-2 ring-[var(--hd-primary)] ring-offset-2': currentLocale === code }" />
        <span class="flex-1 truncate">{{ lang.name }}</span>

        <svg v-if="currentLocale === code" class="w-4 h-4 text-[var(--hd-primary)]" fill="none" viewBox="0 0 24 24"
          stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
      </button>
    </div>
  </li>
</template>