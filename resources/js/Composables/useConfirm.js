import { ref, readonly } from 'vue';

const isOpen = ref(false);
const options = ref({
  title: 'Confirm Action',
  message: 'Are you sure you want to proceed with this operation?',
  confirmText: 'Confirm',
  cancelText: 'Cancel',
  onConfirm: () => {},
  onCancel: () => {},
});

export function useConfirm() {
  /**
   * Fire a global theme-compliant validation banner interaction.
   * @param {Object} config - Parameters for title, content message, and callback methods.
   */
  const requireConfirm = (config = {}) => {
    options.value = {
      title: config.title || 'Confirm Action',
      message: config.message || 'Are you sure?',
      confirmText: config.confirmText || 'Confirm',
      cancelText: config.cancelText || 'Cancel',
      onConfirm: config.onConfirm || (() => {}),
      onCancel: config.onCancel || (() => {}),
    };
    isOpen.value = true;
  };

  const close = () => {
    isOpen.value = false;
  };

  const executeConfirm = () => {
    options.value.onConfirm();
    close();
  };

  const executeCancel = () => {
    options.value.onCancel();
    close();
  };

  return {
    isOpen: readonly(isOpen),
    options: readonly(options),
    requireConfirm,
    executeConfirm,
    executeCancel,
    close
  };
}