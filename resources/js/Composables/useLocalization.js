import { usePage } from '@inertiajs/vue3';

export function useLocalization() {
  const page = usePage();

  /**
   * Translate a specific string key identifier.
   * Usage: __('labels.admin/login.processing', { attribute: 'Value' })
   */
  const __ = (key, replace = {}) => {
    const cleanKey = key.replace(/^\//, '').replace(/\//g, '.');
    
    const translations = page.props.translations || {};
    let translation = cleanKey.split('.').reduce((t, i) => t?.[i], translations) || key;

    Object.keys(replace).forEach((placeholder) => {
      translation = translation.toString().replace(`:${placeholder}`, replace[placeholder]);
    });

    return translation;
  };

  return {
    __
  };
}