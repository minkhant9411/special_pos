<template>
    <nav
        class="flex z-40 top-0 right-0 left-0 fixed items-center justify-between bg-white p-4 shadow-md dark:bg-gray-800">
        <Link :href="route(url)">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="30" height="30" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 12h14M5 12l4-4m-4 4 4 4" />
        </svg>
        </Link>
        <h1 class="text-md text-center">{{ name }}</h1>
        <div class="cart flex justify-end items-center" :class="[!!slot.default ? 'grid-cols' : 'grid-cols']">
            <slot></slot>
            <ThemeSwitch v-if="hasDark" />
        </div>
    </nav>
</template>
<script setup>
import { useSlots } from "vue";
import ThemeSwitch from "../Components/ThemeSwitch.vue";
const slot = useSlots();
const props = defineProps({
    name: {
        type: String,
    },
    url: { type: String, default: "home" },
    hasDark: {
        type: Boolean,
        default: true
    }
});
</script>
<style scoped></style>
