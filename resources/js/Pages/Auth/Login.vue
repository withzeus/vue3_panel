<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useTheme } from '../../Composables/useTheme.js';
import { useLocalization } from '../../Composables/useLocalization.js';

// Themed Containers & Action Items
import ThemedCard from '../../Components/Themed/Card.vue';
import ThemedButton from '../../Components/Themed/Button.vue';

// Refactored Component Elements
import TextInput from '../../Components/Themed/TextInput.vue';
import PasswordInput from '../../Components/Themed/PasswordInput.vue';

// Background telemetry configurations are marked explicitly as optional
defineProps({
  backgroundImage: {
    type: String,
    required: false,
    default: null 
  }
});

const { themeStyles } = useTheme();
const { __ } = useLocalization();

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submitLogin = () => {
  form.post(route('login.attempt'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <Head :title="__('labels.login.submit')" />

  <div 
    class="min-h-screen w-full flex items-center justify-center p-6 relative bg-cover bg-no-repeat transition-colors duration-300" 
    :style="[
      themeStyles,
      { backgroundImage: `url('/assets/backgrounds/rtad_banner.jpg')` }
    ]"
  >
    <div class="absolute inset-0 bg-black/20 dark:bg-black/40 backdrop-blur-[1px] pointer-events-none z-0"
    ></div>

    <div class="w-full max-w-sm z-10 my-auto">
      <ThemedCard class="relative">
        
        <div v-if="form.processing" class="absolute inset-0 bg-black/5 dark:bg-white/5 backdrop-blur-[2px] rounded-2xl flex items-center justify-center z-50 transition-all">
          <div class="px-4 py-2.5 rounded-xl text-xs font-mono font-bold flex items-center gap-2 shadow-sm border" style="background-color: var(--card-bg); color: var(--page-heading); border-color: var(--border-opacity);">
            <svg class="animate-spin h-4 w-4" style="color: var(--page-primary);" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" /></svg>
            {{ __('labels.login.processing').toUpperCase() }}
          </div>
        </div>

        <div class="flex flex-col items-center text-center mb-6">
          <img src="/assets/images/logos/logo.png" class="max-h-12 w-auto object-contain mb-4" alt="Primary Logo" />
          
          <h2 class="text-xl font-bold tracking-tight mb-2" style="color: var(--page-heading);">
            {{ __('auth.login.title') }}
          </h2>
          <span class="text-xs font-semibold uppercase tracking-wider opacity-50" style="color: var(--page-text);">
            {{ __('auth.login.subtitle') }}
          </span>
        </div>

        <form @submit.prevent="submitLogin" class="space-y-4">
          
          <TextInput
            id="email"
            v-model="form.email"
            type="email"
            autofocus
            :label="__('labels.login.email')"
            :placeholder="__('labels.login.email_placeholder')"
            :error="form.errors.email"
          />

          <PasswordInput
            id="password"
            v-model="form.password"
            :label="__('labels.login.password')"
            :placeholder="__('labels.login.password_placeholder')"
            :error="form.errors.password"
          />

          <div class="flex items-center justify-between pt-1">
            <label class="flex items-center gap-2 cursor-pointer select-none group">
              <input type="checkbox" v-model="form.remember" class="sr-only peer" />
              <div class="w-4 h-4 border rounded-md transition-all flex items-center justify-center" :style="form.remember ? { backgroundColor: 'var(--page-primary)', borderColor: 'var(--page-primary)' } : { borderColor: 'var(--border-opacity)', backgroundColor: 'var(--page-bg)' }">
                <svg v-if="form.remember" class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
              </div>
              <span class="text-xs font-semibold opacity-70" style="color: var(--page-text);">
                {{ __('labels.login.remember_me') }}
              </span>
            </label>
          </div>

          <div class="pt-2">
            <ThemedButton type="submit" variant="primary" class="w-full justify-center" :processing="form.processing">
              {{ __('labels.login.submit') }}
            </ThemedButton>
          </div>
        </form>

      </ThemedCard>
    </div>
  </div>
</template>