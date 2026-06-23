<script setup>
defineProps({
  cardBg: { type: String, required: true },
  title: { type: String, required: true },
  description: { type: String, required: true }
});
</script>

<template>
  <section :style="{ '--card-bg': cardBg }"
    class="border rounded-2xl shadow-sm p-6 space-y-6 transition-colors duration-200 border-black/10 dark:border-white/10 bg-[var(--card-bg)]">
    <div class="flex items-center gap-3 pb-4 border-b border-black/5 dark:border-white/5">
      <div class="p-2 rounded-xl" style="background-color: var(--page-primary-alpha); color: var(--page-primary);">
        <slot name="icon" />
      </div>
      <div>
        <h3 class="text-base font-semibold" style="color: var(--page-text);">{{ title }}</h3>
        <p class="text-xs opacity-60">{{ description }}</p>
      </div>
    </div>

    <div class="space-y-6">
      <slot />
    </div>
  </section>
</template>