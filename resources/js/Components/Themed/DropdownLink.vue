<script setup>
import { inject } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    as: { type: String, default: 'a' },
    variant: { type: String, default: 'default' } // 'default' | 'danger'
});

const closeDropdown = inject('closeDropdown');
console.log(props.href);
</script>

<template>
    <component :is="as === 'button' ? 'button' : Link" :href="href" @click="closeDropdown"
        class="w-full text-left px-4 py-2 text-xs font-semibold flex items-center gap-2 transition-colors duration-150 first:rounded-t-lg last:rounded-b-lg"
        :class="{
            'text-[var(--page-text)] hover:bg-black/[0.04] dark:hover:bg-white/[0.04]': variant === 'default',
            'text-rose-600 hover:bg-rose-600/10 dark:text-rose-400': variant === 'danger'
        }">
        <slot />
    </component>
</template>