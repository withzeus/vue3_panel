<template>
    <div class="w-full overflow-x-auto rounded-xl border border-[var(--card-border)] transition-colors duration-300">
        <table class="w-full text-sm text-left border-collapse border-hidden bg-[var(--card-bg)] opacity-75">
            <slot />
        </table>
    </div>
</template>