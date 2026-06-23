import { ref, watch, reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import debounce from 'lodash.debounce';

/**
 * Production filter state management engine.
 * @param {String} routeName - The named route to query mutate back to.
 * @param {Object} initialFilters - Initial state map straight from the controller.
 * @param {Number} delay - Debounce configuration interval in ms.
 */
export function useFilters(routeName, initialFilters = {}, delay = 400) {
  const isExpanded = ref(false);
  const filterState = reactive({ ...initialFilters });

  const toggleFilters = () => {
    isExpanded.value = !isExpanded.value;
  };

  const clearFilters = (keysToKeep = ['search']) => {
    Object.keys(filterState).forEach((key) => {
      if (!keysToKeep.includes(key)) {
        filterState[key] = Array.isArray(filterState[key]) ? [] : '';
      }
    });
  };

  // Centralized router query parameter execution loop
  const executeQuery = debounce((currentFields) => {
    // Scrub empty attributes out to preserve clean URL states
    const cleanParams = Object.keys(currentFields).reduce((acc, key) => {
      if (currentFields[key] !== null && currentFields[key] !== '') {
        acc[key] = currentFields[key];
      }
      return acc;
    }, {});

    router.get(route(routeName), cleanParams, {
      preserveState: true,
      replace: true,
      preserveScroll: true
    });
  }, delay);

  // Monitor deep changes reactively
  watch(() => ({ ...filterState }), (newFields) => {
    executeQuery(newFields);
  }, { deep: true });

  return {
    filterState,
    isExpanded,
    toggleFilters,
    clearFilters
  };
}