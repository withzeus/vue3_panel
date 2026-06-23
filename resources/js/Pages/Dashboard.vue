<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { useTheme } from '../Composables/useTheme.js';

import ThemedCard from '../Components/Themed/Card.vue';
import ThemedButton from '../Components/Themed/Button.vue';

const { themeStyles } = useTheme();
</script>

<template>
  <Head title="Dashboard Home" />

  <div :style="themeStyles" class="max-w-5xl mx-auto space-y-8 p-6 rounded-3xl min-h-[80vh]" style="background-color: var(--page-bg); color: var(--page-text);">
    
    <div class="flex items-center justify-between pb-5 border-b" style="border-color: var(--border-opacity);">
      <h1 class="text-2xl font-bold" style="color: var(--page-heading);">Dashboard Core</h1>
      <Link :href="route('settings.theme.index')">
        <ThemedButton variant="secondary">Adjust Theme Settings</ThemedButton>
      </Link>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <ThemedCard v-for="i in 3" :key="i" :hoverable="true">
        <h3 class="font-bold text-sm uppercase tracking-wider opacity-60">System Core {{ i }}</h3>
        <p class="text-2xl font-black mt-2" style="color: var(--page-heading);">Active Node</p>
      </ThemedCard>
    </div>
  </div>
</template>