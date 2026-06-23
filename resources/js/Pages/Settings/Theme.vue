<script setup>
import { computed, watch } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import { useTheme } from '../../Composables/useTheme.js';
import ThemeToast from '../../Components/Themed/Toast.vue';
import ThemeSection from '../../Components/Themed/ThemeSection.vue';

import ThemedPage from '../../Components/Themed/Page.vue';
import ThemedButton from '../../Components/Themed/Button.vue';
import ThemedRadioGroup from '../../Components/Themed/RadioGroup.vue';
import ThemedColorPicker from '../../Components/Themed/ColorPicker.vue';

const { metrics, updateTheme } = useTheme();

const defaultTokens = {
  light: { base: '#F9FAFB', primary: '#635bff', header: '#FFFFFF', sidebar: '#FFFFFF', card: '#FFFFFF', heading: '#111827', text: '#0B0F19' },
  dark: { base: '#0B0F19', primary: '#635bff', header: '#1F2937', sidebar: '#111827', card: '#1F2937', heading: '#F9FAFB', text: '#F9FAFB' },
};

const form = useForm({
  base_mode: metrics.value.base_mode,
  primary_hue: metrics.value.primary_hue,
  base_container_bg: metrics.value.base_container_bg,
  header_bg_color: metrics.value.header_bg_color,
  sidebar_bg_color: metrics.value.sidebar_bg_color,
  card_bg_color: metrics.value.card_bg_color,
  heading_color: metrics.value.heading_color,
  base_text_color: metrics.value.base_text_color,
});

watch(
  () => ({ ...form.data() }),
  (newFormState) => {
    updateTheme(newFormState);
  },
  { deep: true, immediate: true }
);

const simulatorStyles = computed(() => ({
  '--sim-bg': form.base_container_bg,
  '--sim-header': form.header_bg_color,
  '--sim-sidebar': form.sidebar_bg_color,
  '--sim-card': form.card_bg_color,
  '--sim-heading': form.heading_color,
  '--sim-text': form.base_text_color,
  '--sim-primary': form.primary_hue,
  '--sim-primary-alpha': `color-mix(in srgb, ${form.primary_hue} 10%, transparent)`,
  'background-color': form.base_mode === 'dark' ? '#0b0f19' : '#ffffff',
  'border-color': form.base_mode === 'dark' ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
}));

const handleModeChange = (mode) => {
  Object.assign(form, {
    base_mode: mode,
    base_container_bg: defaultTokens[mode].base,
    header_bg_color: defaultTokens[mode].header,
    sidebar_bg_color: defaultTokens[mode].sidebar,
    card_bg_color: defaultTokens[mode].card,
    heading_color: defaultTokens[mode].heading,
    base_text_color: defaultTokens[mode].text,
  });
};

const resetToDefaults = () => {
  form.primary_hue = defaultTokens[form.base_mode].primary;
  handleModeChange(form.base_mode);
};

const submitThemeConfigurations = () => {
  form.post(route('settings.theme.update'), { preserveScroll: true });
};
</script>

<template>
  <Head title="Theme settings" />

  <ThemedPage>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-5 border-b" style="border-color: var(--border-opacity);">
      <div>
        <h1 style="color: var(--page-heading);" class="text-2xl font-bold tracking-tight transition-colors duration-300">Theme Customization</h1>
        <p style="color: var(--page-text);" class="text-sm opacity-70 mt-1 transition-colors duration-300">Configure your design system metrics safely.</p>
      </div>
      <div class="flex items-center gap-3">
        <ThemedButton variant="secondary" @click="resetToDefaults">Reset Defaults</ThemedButton>
        <ThemedButton variant="primary" :processing="form.processing" @click="submitThemeConfigurations">Save Configurations</ThemedButton>
      </div>
    </div>

    <form @submit.prevent="submitThemeConfigurations" class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-6">
      <div class="lg:col-span-2 space-y-8">

        <ThemeSection :card-bg="form.card_bg_color" title="Theme Mode" description="Predefined structural system modes.">
          <template #icon>
            <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h11M19 7h2" />
              <circle cx="16" cy="7" r="2" fill="currentColor" fill-opacity="0.2" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 17h3M11 17h10" />
              <circle cx="8" cy="17" r="2" fill="currentColor" fill-opacity="0.2" />
            </svg>
          </template>

          <ThemedRadioGroup 
            :model-value="form.base_mode" 
            @update:model-value="handleModeChange"
            name="base_mode"
            :options="[{value: 'light', label: 'Light System'}, {value: 'dark', label: 'Dark System'}]"
          />
        </ThemeSection>

        <ThemeSection :card-bg="form.card_bg_color" title="Color Matrix & Accents" description="Map structural core framework color fills.">
          <template #icon>
            <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 01-1.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a15.997 15.997 0 01-4.764-4.648" />
            </svg>
          </template>

          <div class="space-y-6">
            <div>
              <label class="block text-xs font-semibold uppercase tracking-wider mb-3 opacity-75" style="color: var(--page-text);">Accent Blueprint (Primary Hue)</label>
              <div class="flex flex-wrap gap-3">
                <button 
                  v-for="color in ['#635bff', '#7c3aed', '#059669', '#e11d48', '#d97706']" 
                  :key="color"
                  type="button"
                  :style="{ backgroundColor: color, transform: form.primary_hue.toLowerCase() === color.toLowerCase() ? 'scale(1.05)' : '' }"
                  @click="form.primary_hue = color" 
                  class="w-10 h-10 rounded-xl transition-all relative block shrink-0"
                >
                  <span v-if="form.primary_hue.toLowerCase() === color.toLowerCase()" class="absolute inset-0 flex items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                  </span>
                </button>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <ThemedColorPicker v-model="form.base_container_bg" label="Container Canvas Fill" />
              <ThemedColorPicker v-model="form.header_bg_color" label="Header Canvas Fill" />
              <ThemedColorPicker v-model="form.sidebar_bg_color" label="Sidebar Canvas Fill" />
              <ThemedColorPicker v-model="form.card_bg_color" label="Card Canvas Fill" />
              <ThemedColorPicker v-model="form.heading_color" label="Global Heading" />
              <ThemedColorPicker v-model="form.base_text_color" label="Text Color" />
            </div>
          </div>
        </ThemeSection>
      </div>

      <div class="space-y-6">
        <div class="sticky top-24 space-y-4">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold opacity-50 uppercase tracking-wider" style="color: var(--page-heading);">Live Simulator Telemetry</span>
            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[10px] font-medium bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
              <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Synchronized
            </span>
          </div>

          <div :style="simulatorStyles" class="w-full border rounded-2xl shadow-md overflow-hidden flex flex-col h-[390px] transition-all duration-300">
            <div :style="{ backgroundColor: form.header_bg_color, color: form.heading_color, borderColor: form.base_mode === 'dark' ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)' }" class="h-12 border-b flex items-center justify-between px-4 flex-shrink-0">
              <div class="text-xs font-black tracking-tight">MATDASH</div>
              <div class="flex items-center gap-1.5 opacity-60">
                <div class="w-4 h-4 rounded-full" :style="{ backgroundColor: form.heading_color, opacity: 0.2 }"></div>
                <div class="w-4 h-4 rounded-full" :style="{ backgroundColor: form.heading_color, opacity: 0.2 }"></div>
              </div>
            </div>

            <div class="flex-1 flex overflow-hidden">
              <div :style="{ backgroundColor: form.sidebar_bg_color, borderColor: form.base_mode === 'dark' ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)' }" class="w-20 border-r p-2 flex flex-col gap-2">
                <div class="h-3 rounded w-4/5" :style="{ backgroundColor: form.primary_hue, opacity: 0.4 }"></div>
                <div class="space-y-1.5 mt-2">
                  <div class="h-2 rounded w-full" :style="{ backgroundColor: form.primary_hue, opacity: 0.2 }"></div>
                  <div class="h-2 rounded w-4/5" :style="{ backgroundColor: form.primary_hue, opacity: 0.1 }"></div>
                </div>
              </div>

              <div :style="{ backgroundColor: form.base_container_bg }" class="flex-1 p-4 space-y-4 overflow-y-auto">
                <div>
                  <div class="font-bold text-xs" :style="{ color: form.heading_color }">Main Panel Heading</div>
                  <div class="h-1 rounded w-1/3" :style="{ backgroundColor: form.heading_color, opacity: 0.3 }"></div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                  <div v-for="i in 2" :key="i" :style="{ backgroundColor: form.card_bg_color, borderColor: form.base_mode === 'dark' ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)' }" class="border p-2.5 rounded-xl space-y-2">
                    <div class="w-4 h-4 rounded" :style="{ backgroundColor: form.primary_hue, opacity: 0.15 }"></div>
                    <div class="h-1.5 rounded" :style="{ backgroundColor: form.heading_color, opacity: 0.4, width: '70%' }"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </ThemedPage>
</template>