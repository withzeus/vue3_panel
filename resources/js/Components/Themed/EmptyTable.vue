<script setup>
import { computed } from 'vue';

const props = defineProps({
    colspan: {
        type: [Number, String],
        required: true
    },
    message: {
        type: String,
        default: "No structural data matching your constraints could be found."
    },
    icon: {
        type: String,
        default: 'search' // 'search' | 'users' | 'archive' | 'shield'
    }
});

// A localized matrix registry mapping to your custom framework SVG path clusters
const iconMap = {
    search: `
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.604 10.604z" />
    `,
    users: `
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
    `,
    archive: `
        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
    `
};

const resolvedIconPath = computed(() => iconMap[props.icon] || iconMap.search);
</script>

<template>
    <tr>
        <td :colspan="colspan"
            class="p-12 text-center text-xs font-semibold tracking-wide opacity-60 bg-[var(--card-bg)] text-[var(--page-text)] select-none">
            <div class="flex flex-col items-center justify-center gap-3 max-w-sm mx-auto">
                <slot name="icon">
                    <svg class="w-8 h-8 opacity-40 text-[var(--page-text)]" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.5" v-html="resolvedIconPath"></svg>
                </slot>

                <slot name="message">
                    <span>{{ message }}</span>
                </slot>

                <slot name="action" />
            </div>
        </td>
    </tr>
</template>