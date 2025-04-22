import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import vuePlugin from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        vuePlugin(),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: "0.0.0.0", // expose to LAN
        port: 5173,
        strictPort: true,
        // origin: "http://192.168.1.4:5173", // 👈 match your Vite URL
        // origin: "http://192.168.175.70:5173", // 👈 match your Vite URL
        // origin: "http://0.0.0.0:5173", // 👈 match your Vite URL
        cors: true, // enable CORS
        hmr: {
            protocol: "ws",
            // host: "192.168.1.4", // 👈 match your IP
            // host: "192.168.175.70", // 👈 match your IP
            // host: "0.0.0.0", // 👈 match your IP
            port: 5173,
        },
    },
});
