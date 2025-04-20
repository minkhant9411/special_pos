<template>
    <div
        class="p-3 my-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <div class="m-2 flex justify-between items-center">
            <p>{{ category.name }} <br><small class="text-gray-500 mt-2">Show in {{ type }}</small></p>

            <div class="flex gap-4">
                <Link :href="route('category.edit', category.id)" class="cursor-pointer">
                <svg class="w-6 h-6 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                </svg>
                </Link>
                <Link method="post" :href="route('category.destroy', category.id)" class="cursor-pointer">
                <svg class="w-6 h-6 text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                </svg>
                </Link>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';

const type = ref()
const props = defineProps({
    category: {
        type: Object,
    },
});
switch (props.category.transaction_type) {
    case 'for_sale':
        type.value = 'Sale'
        break;
    case 'for_purchase':
        type.value = 'Purchase'
        break;
    case 'for_both':
        type.value = 'Purchase and Sale'
        break;
    default:
        break;
}
</script>
<style scoped></style>
