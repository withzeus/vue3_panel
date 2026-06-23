<script setup>
import { computed } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';

defineProps({
  isOpen: {
    type: Boolean,
    default: false
  }
});

const page = usePage();
const menuGroups = computed(() => page.props.menuGroups || []);
const currentUrl = computed(() => page.url);

const resolveItemUrl = (item) => {
  if (item.url) return item.url;
  if (item.route) {
    try {
      return route(item.route);
    } catch (e) {
      return '/' + item.route.replace(/\./g, '/');
    }
  }
  return '#';
};

const isItemActive = (item) => {
  const targetUrl = resolveItemUrl(item);
  if (!targetUrl || targetUrl === '#') return false;

  const currentPath = currentUrl.value.split('?')[0].replace(/\/$/, '') || '/';
  const targetPath = targetUrl.replace(/^(?:\/\/|[^\/]+)*\//, '/').split('?')[0].replace(/\/$/, '') || '/';

  if (currentPath === targetPath) return true;

  if (item.active_pattern) {
    const patterns = Array.isArray(item.active_pattern) ? item.active_pattern : [item.active_pattern];

    return patterns.some(pattern => {
      if (pattern === '/' && currentPath === '/') return true;
      if (pattern === '/') return false;

      const cleanPattern = pattern.replace(/^\//, '').replace(/\*$/, '');
      const cleanCurrentPath = currentPath.replace(/^\//, '');

      return cleanCurrentPath.startsWith(cleanPattern);
    });
  }

  return false;
};

</script>

<template>
  <aside id="mainSidebar" :class="[isOpen ? 'translate-x-0' : '-translate-x-full']"
    class="fixed top-[70px] bottom-0 left-0 z-40 flex w-64 flex-col border-r border-black/5 shadow-xl transition-all duration-300 ease-in-out bg-[var(--sb-bg)] text-[var(--sb-text)]">
    <nav class="flex-1 overflow-y-auto p-4 space-y-6">
      <div v-for="group in menuGroups" :key="group.heading">
        <p style="color: var(--sb-heading);"
          class="px-3 text-[10px] font-bold uppercase tracking-wider opacity-60 mb-2">
          {{ group.heading }}
        </p>

        <ul class="space-y-1">
          <li v-for="item in group.items" :key="item.label">
            <Link v-if="isItemActive(item)" :href="resolveItemUrl(item)"
              style="background-color: color-mix(in srgb, var(--sb-primary) 12%, transparent); color: var(--sb-primary);"
              class="flex items-center gap-3 px-3 py-2 text-sm font-semibold rounded-xl transition-all h-10">
              <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center stroke-current" v-html="item.icon" />
              <span class="leading-none self-center pt-0.5">{{ item.label }}</span>
            </Link>

            <Link v-else :href="resolveItemUrl(item)"
              class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-xl transition-all opacity-80 hover:opacity-100 hover:bg-[var(--sb-hover-bg)] hover:text-[var(--sb-primary)] h-10">
              <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center stroke-current" v-html="item.icon" />
              <span class="leading-none self-center pt-0.5">{{ item.label }}</span>
            </Link>
          </li>
        </ul>
      </div>
    </nav>
  </aside>
</template>