import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { useTheme } from '@/Composables/useTheme';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        // Apply the saved theme before mounting so components (e.g. GuestThemeToggle)
        // can override it in onMounted without being clobbered afterwards.
        useTheme().initTheme();

        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use({
                install(app) {
                    app.config.globalProperties.route = window.route;
                },
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

