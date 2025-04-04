import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios"; // Make sure axios is installed
import Layout from "./Shared/Layout.vue";

// Session timeout handling variables
const SESSION_PING_INTERVAL = 10 * 60 * 1000; // 10 minutes in milliseconds
let keepAliveTimer = null;

// Start the keepalive ping to prevent session timeout
function startKeepAliveTimer() {
    // Clear any existing timer
    if (keepAliveTimer) clearTimeout(keepAliveTimer);

    // Set new timer
    keepAliveTimer = setTimeout(() => {
        axios.get('/api/ping')
            .then(() => {
                // Continue the cycle on success
                startKeepAliveTimer();
            })
            .catch((error) => {
                // If we get an auth error, reload the page
                if (error.response && [401, 419].includes(error.response.status)) {
                    window.location.reload();
                } else {
                    // For other errors, try again
                    startKeepAliveTimer();
                }
            });
    }, SESSION_PING_INTERVAL);
}

createInertiaApp({
    resolve: (name) => {
        let page = require(`./Pages/${name}`).default;
        page.layout ??= Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) });
        vueApp.use(plugin).mount(el);

        // Start keepalive timer when app is mounted
        startKeepAliveTimer();
    },
});

// Initialize Inertia Progress Bar
InertiaProgress.init({
    delay: 250,
    color: "#006202",
    includeCSS: true,
    showSpinner: false,
});

// Error handling for session timeout / expired CSRF
Inertia.on('error', (error) => {
    if (error.response && [419, 401].includes(error.response.status)) {
        // Session expired - reload the page
        window.location.reload();
    }
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

    // Restart keepalive timer on navigation
    startKeepAliveTimer();
});

Inertia.on('invalid', () => {
    // fallback if Inertia detects a non-inertia response
    window.location.reload();
});

// Reset the keepalive timer when user interacts with the page
['click', 'keypress', 'scroll', 'mousemove', 'touchstart'].forEach(event => {
    document.addEventListener(event, () => {
        startKeepAliveTimer();
    }, { passive: true });
});

// Clean up on page unload
window.addEventListener('beforeunload', () => {
    if (keepAliveTimer) clearTimeout(keepAliveTimer);
});