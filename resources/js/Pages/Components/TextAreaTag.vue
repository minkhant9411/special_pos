<template>
    <textarea rows="4" v-model="model"
        class="block p-2.5 my-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="Description"></textarea>
</template>
<script setup>
import { defineModel } from "vue";
const model = defineModel({
    type: null,
    required: true,
});
</script>
<style scoped></style>
