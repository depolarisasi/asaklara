import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue, route } from '../../vendor/tightenco/ziggy';

createInertiaApp({
    title: (title) => `${title} - ASAK Admin`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        ),
    setup({ el, App, props, plugin }) {
        const ziggyConfig = props.initialPage.props.ziggy;

        // Make route() available as a JS global for <script setup> components
        window.route = (name, params, absolute) => route(name, params, absolute, ziggyConfig);

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, ziggyConfig)
            .mount(el);
    },
    progress: {
        color: '#b8960c',
    },
});
