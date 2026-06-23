<script setup>
import { ref, onMounted, onUnmounted, provide } from 'vue';

const props = defineProps({
    align: { type: String, default: 'right' },
    width: { type: String, default: '48' },
});

const open = ref(false);
const triggerRef = ref(null);

// Pixel position tracking vectors
const menuTop = ref('0px');
const menuLeft = ref('0px');

const closeDropdown = () => { open.value = false; };

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        closeDropdown();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const calculateCoords = () => {
    if (!triggerRef.value) return;

    // Get the exact viewport pixel coordinates of your trigger button (•••)
    const rect = triggerRef.value.getBoundingClientRect();
    const dropdownWidth = props.width.toString() === '56' ? 224 : 192; // matching w-56 or w-48
    const dropdownHeight = 110; // Approximate height threshold for fallback calculations

    let top = rect.bottom + window.scrollY;
    let left = props.align === 'right'
        ? rect.right + window.scrollX - dropdownWidth
        : rect.left + window.scrollX;

    // Viewport spatial overflow detection: Flip up if it runs off the bottom screen edge
    if (rect.bottom + dropdownHeight > window.innerHeight) {
        top = rect.top + window.scrollY - dropdownHeight - 8;
    }

    menuTop.value = `${top}px`;
    menuLeft.value = `${left}px`;
};

const toggleDropdown = () => {
    open.value = !open.value;
    if (open.value) {
        calculateCoords();
        // Keep coordinates perfectly locked during scrolling adjustments
        window.addEventListener('scroll', calculateCoords, true);
    } else {
        window.removeEventListener('scroll', calculateCoords, true);
    }
};

onUnmounted(() => {
    window.removeEventListener('scroll', calculateCoords, true);
});

const widthClass = {
    '48': 'w-48',
    '56': 'w-56',
}[props.width.toString()];

provide('closeDropdown', closeDropdown);
</script>

<template>
    <div class="relative inline-block text-left">
        <div ref="triggerRef" @click="toggleDropdown" class="cursor-pointer">
            <slot name="trigger" />
        </div>

        <Teleport to="body">
            <div v-if="open" class="fixed inset-0 z-40" @click="closeDropdown"></div>

            <Transition enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0">
                <div v-if="open"
                    class="absolute z-50 rounded-xl shadow-xl border border-[var(--card-border)] bg-[var(--card-bg)] focus:outline-none divide-y divide-black/[0.04] dark:divide-white/[0.04]"
                    :class="[widthClass]" :style="{ top: menuTop, left: menuLeft }">
                    <div class="py-1.5">
                        <slot name="content" />
                    </div>
                </div>
            </Transition>
        </Teleport>
    </div>
</template>