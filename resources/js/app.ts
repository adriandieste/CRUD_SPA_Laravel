import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import '../css/app.css';
import { initializeTheme } from './composables/useAppearance';
import { useTranslation } from './composables/useTranslation';

// Import translations
import es from './i18n/es.json';
import en from './i18n/en.json';
import fr from './i18n/fr.json';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Initialize translations
const { setTranslations, initializeLocale } = useTranslation();
setTranslations('es', es);
setTranslations('en', en);
setTranslations('fr', fr);
initializeLocale();

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();

