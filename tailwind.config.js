// tailwind.config.js
export default {
    darkMode: "selector",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.vue",
        "./resources/**/**/*.vue",
        "./resources/**/**/**/*.vue",
        "./resources/**/**/*.js",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {},
    },
};
