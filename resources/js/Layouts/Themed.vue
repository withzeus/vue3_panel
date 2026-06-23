<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import ThemedHeader from "../Components/Themed/Header.vue";
import ThemedSidebar from "../Components/Themed/Sidebar.vue";
import ThemedToast from "../Components/Themed/Toast.vue";
import ThemedConfirmToast from "../Components/Themed/ConfirmToast.vue";

const page = usePage();
const theme = computed(() => page.props.themeMetrics || {});

const isSidebarOpen = ref(window.innerWidth >= 768);

const inlineLayoutStyles = computed(() => {
  return {
    "--page-bg": theme.value.base_container_bg || "#f8fafc",
    "--page-text": theme.value.base_text_color || "#1e293b",
    "--page-heading": theme.value.heading_color || "#0f172a",
    "--page-primary": theme.value.primary_hue || "#635bff",
    "--page-card-bg": theme.value.card_bg_color || "#ffffff",
    "--hd-bg": theme.value.header_bg_color || "#ffffff",
    "--hd-text": theme.value.base_text_color || "#1e293b",
    "--hd-heading": theme.value.heading_color || "#0f172a",
    "--hd-primary": theme.value.primary_hue || "#635bff",
    "--hd-hover-bg": `color-mix(in srgb, ${theme.value.primary_hue || "#635bff"} 10%, transparent)`,
    "--hd-hover-ring": `color-mix(in srgb, ${theme.value.primary_hue || "#635bff"} 25%, transparent)`,
    "--sb-bg": theme.value.sidebar_bg_color || "#ffffff",
    "--sb-text": theme.value.base_text_color || "#1e293b",
    "--sb-heading": theme.value.heading_color || "#0f172a",
    "--sb-primary": theme.value.primary_hue || "#635bff",
    "--sb-hover-bg": `color-mix(in srgb, ${theme.value.primary_hue || "#635bff"} 8%, transparent)`,
    "--border-opacity": 'rgba(0, 0, 0, 0.08)',
  };
});
</script>

<template>
  <div :style="inlineLayoutStyles"
    class="min-h-screen flex flex-col transition-colors duration-200 bg-[var(--page-bg)] text-[var(--page-text)]">
    <ThemedHeader @toggle-sidebar="isSidebarOpen = !isSidebarOpen" :sidebar-open="isSidebarOpen" />

    <div class="flex flex-1 relative">
      <ThemedSidebar :is-open="isSidebarOpen" />

      <main :class="[isSidebarOpen ? 'md:pl-64' : 'md:pl-0']"
        class="flex-1 min-w-0 transition-all duration-300 ease-in-out">
        <div class="p-6 max-w-5xl mx-auto w-full">
          <slot />
        </div>
      </main>

      <ThemedToast />
      <ThemedConfirmToast />
    </div>

    <div v-if="isSidebarOpen" @click="isSidebarOpen = false"
      class="fixed inset-0 bg-black/40 backdrop-blur-sm z-30 md:hidden" />
  </div>
</template>
