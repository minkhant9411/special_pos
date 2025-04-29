import "./bootstrap";
import "flowbite/dist/flowbite.min.css";
import "../css/app.css";
import "flowbite/dist/flowbite.min.js";
import "./themeSwitch.js";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

// localStorage.theme = "light";
createInertiaApp({
    title: (title) => `Pos ${title}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });

        let page = pages[`./Pages/${name}.vue`];
        // page.default.layout = page.default.layout || AdminLayout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component("Head", Head)
            .component("Link", Link)
            .mount(el);
    },
    progress: {
        color: "#05d9fa",
        includeCSS: true,
        showSpinner: true,
    },
});
