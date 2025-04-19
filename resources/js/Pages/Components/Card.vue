<template>
    <Link :href="route(href)" type="button" as="button"
        class="text-center focus:ring-1 ring-gray-600 py-3 cursor-pointer bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
    {{ name }}
    </Link>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import { defineProps } from "vue";
const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    href: {
        type: String,
        required: true,
    },
});
</script>
<style scoped></style>
