import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';

const layouts = import.meta.glob('./Layouts/**/*.vue', { eager: true })

createInertiaApp({
    title: (title) => title ? `${title}` : 'Admin Dashboard',
    resolve: async (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue')
        const page = await resolvePageComponent(`./Pages/${name}.vue`, pages)

        page.default.layout = (h, pageComponent) => {
        const layoutName = pageComponent.props._layout

        if (layoutName) {
            // Points to ./Layouts/Themed.vue if '_layout' => 'Themed' is returned
            const layoutFile = layouts[`./Layouts/${layoutName}.vue`]
            
            if (layoutFile) {
            return h(layoutFile.default, () => pageComponent)
            }
        }

        // If no layout is sent, render the page without a persistent parent shell
        return pageComponent
        }

        return page
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#2563eb',
    },
});