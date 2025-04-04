import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { Inertia } from "@inertiajs/inertia";
import Layout from "./Shared/Layout.vue";

// Create Inertia app and set up page layout
createInertiaApp({
    resolve: (name) => {
        let page = require(`./Pages/${name}`).default;
        page.layout ??= Layout; // Set layout if not defined in the page
        return page;
    },
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) });
        vueApp.use(plugin).mount(el);
    },
});

// Initialize Inertia Progress Bar
InertiaProgress.init({
    delay: 250,
    color: "#006202",
    includeCSS: true,
    showSpinner: false,
});

// Fix 1: Refresh page when navigating back after inactivity
window.addEventListener("pageshow", (event) => {
    if (event.persisted) {
        window.location.reload();
    }
});

// Fix 2: Handle popstate to reload page on back button navigation
let stale = false;
window.addEventListener('popstate', () => {
    stale = true;
});

Inertia.on('navigate', (event) => {
    if (stale) {
        Inertia.reload({ only: ['auth', 'flash'] });
    }
    stale = false;
});

// Optional: Reload page after idle timeout (set after X minutes of inactivity)
let idleTime = 0;
const reloadAfterMinutes = 15;

setInterval(() => {
    idleTime++;
    if (idleTime >= reloadAfterMinutes) {
        window.location.reload();
    }
}, 60000); // Check every 1 minute

// Reset timer on any user activity (e.g., mouse move, keypress, click, scroll)
['mousemove', 'keypress', 'scroll', 'click'].forEach((event) => {
    window.addEventListener(event, () => idleTime = 0);
});
