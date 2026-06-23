<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { useTheme } from '../../Composables/useTheme';
import { useLocalization } from '../../Composables/useLocalization';

const { themeStyles } = useTheme();
const { __ } = useLocalization();

const goBack = () => {
  if (typeof window !== 'undefined') {
    window.history.back();
  }
};
</script>

<template>
  <Head :title="__('pages.errors.403.title') || '403 - Access Denied'" />

  <div 
    :style="themeStyles"
    class="min-h-screen flex items-center justify-center p-6 transition-colors duration-300"
    style="background-color: var(--page-bg); color: var(--page-text);"
  >
    <div class="max-w-md w-full text-center space-y-6">
      
      <div class="relative flex justify-center">
        <div 
          class="absolute inset-0 blur-3xl rounded-full w-48 h-48 mx-auto -top-4 transition-colors duration-300"
          style="background-color: var(--page-primary-alpha);"
        ></div>
        <h1 
          class="text-9xl font-black tracking-tighter drop-shadow-sm select-none transition-colors duration-300"
          style="color: var(--page-primary);"
        >
          403
        </h1>
      </div>

      <div class="space-y-2">
        <h2 class="text-2xl font-bold tracking-tight transition-colors duration-300" style="color: var(--page-heading);">
          {{ __('pages.errors.403.heading') || 'Access Denied' }}
        </h2>
        <p class="text-sm opacity-70 max-w-sm mx-auto leading-relaxed">
          {{ __('pages.errors.403.sub_heading') || 'Your account does not have the necessary permissions to access this resource or perform this action.' }}
        </p>
      </div>

      <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
        <button 
          type="button"
          @click="goBack" 
          class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium border rounded-xl hover:bg-black/5 dark:hover:bg-white/5 transition-all shadow-sm"
          style="border-color: var(--border-opacity); background-color: var(--card-bg); color: var(--page-heading);"
        >
          {{ __('actions.errors.go_back') || 'Go Back' }}
        </button>
        
        <Link 
          :href="route('dashboard')" 
          class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold text-white transition-all rounded-xl shadow-sm inline-flex justify-center hover:brightness-110"
          :style="{ backgroundColor: 'var(--page-primary)', boxShadow: `0 4px 12px var(--page-primary-ring)` }"
        >
          {{ __('actions.errors.return_home') || 'Return Home' }}
        </Link>
      </div>

      <div class="pt-8 border-t" style="border-color: var(--border-opacity);">
        <span class="inline-flex items-center gap-1.5 text-[10px] font-mono tracking-widest opacity-40 uppercase">
          Status: ERR_ACTION_UNAUTHORIZED
        </span>
      </div>

    </div>
  </div>
</template>