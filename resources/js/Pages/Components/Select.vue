<template>
    <select v-model="model"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option selected :value="null">{{ name }} </option>
        <option v-for="item in data" :value="item.id" :key="item.id">
            {{ item.name }}
        </option>
    </select>
</template>
<script setup>

const model = defineModel({
    type: null,
    require: true
})
const props = defineProps({
    data: { type: Object, default: [] },
    name: { type: String, default: 'All' },
})
</script>
<style scoped></style>
