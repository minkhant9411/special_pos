<template>
    <Link :href="route(url)" type="button" as="button"
        class="text-gray-500 relative cursor-pointer dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none rounded-lg text-sm p-2.5">
    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
        height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
    </svg>
    <div v-if="qty > 0"
        class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
        {{ qty }}
    </div>
    </Link>

</template>
<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    url: String,
    qty: Number,
});

// setInterval(() => {
//     cart.value = JSON.parse(localStorage.getItem('cart') || '[]')
// }, 1000)
// watch(cart, (newCart) => {
//     qty.value = 0
//     for (let i = 0; i < newCart.length; i++) {
//         const item = newCart[i];
//         qty.value += parseInt(item.qty)
//     }
// })

</script>
<style scoped></style>
