import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { Inertia } from "@inertiajs/inertia";
import Layout from "./Shared/Layout.vue";

createInertiaApp({
    resolve: (name) => {
        let page = require(`./Pages/${name}`).default;
        page.layout ??= Layout;
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


// import { createApp, h } from "vue";
// import { createInertiaApp } from "@inertiajs/inertia-vue3";
// import { InertiaProgress } from "@inertiajs/progress";
// import { Inertia } from "@inertiajs/inertia";
// import Layout from "./Shared/Layout.vue";

// createInertiaApp({
//     resolve: (name) => {
//         let page = require(`./Pages/${name}`).default;

//         if (!page.layout) {
//             page.layout = Layout;
//         }
//         return page;
//     },
//     setup({ el, App, props, plugin }) {
//         createApp({ render: () => h(App, props) })
//             .use(plugin)
//             .mount(el);
//     },
// });

// // Initialize Inertia Progress Bar
// InertiaProgress.init({
//     delay: 250,
//     color: "#006202",
//     includeCSS: true,
//     showSpinner: false,
// });

// // Fix 1: Refresh page when navigating back after inactivity
// window.addEventListener("pageshow", (event) => {
//     if (event.persisted) {
//         window.location.reload();
//     }
// });

// // Fix 2: Handle popstate to reload page on back button navigation



// let stale = false;

// window.addEventListener('popstate', () => {
//     stale = true;
// });

// Inertia.on('navigate', (event) => {
//     const page = event.detail.page;
//     if (stale) {
//         Inertia.get(page.url, {}, { replace: true, preserveState: false });
//     }
//     stale = false;
// });




