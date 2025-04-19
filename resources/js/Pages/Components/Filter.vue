<template>

    <div class="grid grid-cols-2 gap-2">
        <select v-model="category"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option selected :value="null">Category</option>
            <option v-for="category in categories" :value="category.name" :key="category.id">
                {{ category.name }}
            </option>
        </select>

        <Input :type="'search'" :placeholder="'Search'" v-model="search" />
    </div>
</template>
<script setup>
import { debounce } from 'lodash';
import { ref, watch } from 'vue';
import Input from './Input.vue';
import { router, usePage } from '@inertiajs/vue3';

const page = usePage()
const props = defineProps({
    categories: Object
})
const queryParams = Object.fromEntries(
    new URLSearchParams(page.url.split("?")[1])
);
const search = ref(queryParams.search || null);
const category = ref(queryParams.category || null);
watch(
    search,
    debounce((q) => {
        router.get(
            "",
            { search: q },
            {
                preserveState: true,
            }
        );
    }, 500)
);
watch(
    category,
    debounce((q) => {
        router.get(
            "",
            { category: q },
            {
                preserveState: true,
            }
        );
    }, 500)
);
</script>
<style scoped></style>
