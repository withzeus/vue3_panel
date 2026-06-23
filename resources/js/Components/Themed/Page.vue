<script setup>
import { useTheme } from "../../Composables/useTheme";

const { themeStyles } = useTheme();
</script>

<template>
  <div :style="[themeStyles, { backgroundColor: 'var(--page-bg)', color: 'var(--page-text)' }]"
    class="max-w-5xl mx-auto space-y-8 relative p-6 rounded-3xl transition-colors duration-300">
    <slot />
  </div>
</template>