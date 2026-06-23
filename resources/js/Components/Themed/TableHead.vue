<template>
    <thead
        class="text-xs font-bold uppercase tracking-wider bg-black/[0.02] dark:bg-white/[0.02] border-b-2 border-[var(--card-border)] transition-colors duration-300"
        style="color: var(--page-text);">
        <tr class="divide-x divide-[var(--card-border)] table-row">
            <slot />
        </tr>
    </thead>
</template>