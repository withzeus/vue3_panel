import { ref, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

// Keep the state outside the function scope so it persists across different component mounts
const localMetrics = ref(null);

export function useTheme() {
  const page = usePage();
  
  // 1. Establish core default design tokens fallback layout
  const defaultMetrics = {
    base_mode: 'light',
    primary_hue: '#635bff',
    base_container_bg: '#f9fafb',
    header_bg_color: '#ffffff',
    sidebar_bg_color: '#ffffff',
    card_bg_color: '#ffffff',
    heading_color: '#111827',
    base_text_color: '#0b0f19',
  };

  // 2. Initialize state from server properties if not already set
  if (!localMetrics.value) {
    localMetrics.value = { ...defaultMetrics, ...(page.props.themeMetrics || {}) };
  }

  // 3. Keep local state in sync if server properties change externally
  watch(
    () => page.props.themeMetrics,
    (newServerMetrics) => {
      if (newServerMetrics) {
        localMetrics.value = { ...localMetrics.value, ...newServerMetrics };
      }
    },
    { deep: true }
  );

  // 4. Expose the metrics safely as read-only or direct reactive reference
  const metrics = computed(() => localMetrics.value);

  // 5. Consolidate design variables into reactive CSS properties mapping
  const themeStyles = computed(() => ({
    '--page-bg': localMetrics.value.base_container_bg,
    '--page-text': localMetrics.value.base_text_color,
    '--page-heading': localMetrics.value.heading_color,
    '--page-primary': localMetrics.value.primary_hue,
    '--page-primary-alpha': `color-mix(in srgb, ${localMetrics.value.primary_hue} 10%, transparent)`,
    '--page-primary-ring': `color-mix(in srgb, ${localMetrics.value.primary_hue} 25%, transparent)`,
    '--card-bg': localMetrics.value.card_bg_color,
    '--card-border': localMetrics.value.base_mode === 'dark' ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.06)',
    '--border-opacity': localMetrics.value.base_mode === 'dark' ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.06)',
  }));

  /**
   * Updates specific properties within the theme matrix in real-time.
   * @param {Object} newKeyValuePairs - Partial configuration map containing style alterations.
   */
  const updateTheme = (newKeyValuePairs = {}) => {
    localMetrics.value = {
      ...localMetrics.value,
      ...newKeyValuePairs
    };

    // Optional: Synchronize light/dark base utility classes on the root HTML body node
    if (newKeyValuePairs.base_mode) {
      if (newKeyValuePairs.base_mode === 'dark') {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    }
  };

  return {
    metrics,
    themeStyles,
    updateTheme
  };
}