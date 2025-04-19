<template>
    <NormalNav name="Purchase">
        <Cart url="purchase.create" :qty="quantity" />
    </NormalNav>
    <div class="mt-21 m-2">

        <Filter :categories="categories" />

        <div class="grid grid-cols-2 gap-2 my-3">
            <div v-for="product in products" :key="product.id"
                class="w-full relative max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <a href="#">
                    <img class="rounded-t-lg mx-auto w-[100%] object-cover h-30"
                        :src="[product.image_path != null ? '/storage/' + product.image_path : '/storage/profiles/default.png']"
                        alt="product image" />
                </a>
                <button @click="addCart(product, 1)" class="absolute top-20 right-2 cursor-pointe rounded-full">
                    <svg class="w-10 h-10 text-white active:text-gray-400 rounded-full hover:text-gray-300"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <div class="px-5">
                    <p class="text-gray-500 text-sm m-2">
                        {{ product?.category?.name ?? "No Category" }}
                    </p>
                    <p class=" font-bold my-2">{{ product.name }}</p>
                    <p class="text-sm my-2">MMK {{ product.price }}</p>
                </div>
            </div>
        </div>

    </div>
</template>
<script setup>
import { ref } from 'vue';
import Cart from '../Components/Cart.vue';
import Filter from '../Components/Filter.vue';
import NormalNav from '../Components/NormalNav.vue';
const cart = ref(JSON.parse(localStorage.getItem('cart') || '[]'))
const quantity = ref(0)
const props = defineProps({
    purchases: Object,
    products: Object,
    categories: Object,
});
const getCartCount = () => {
    quantity.value = 0
    for (let i = 0; i < cart.value.length; i++) {
        const item = cart.value[i];
        quantity.value += parseInt(item.qty)
    }
}
getCartCount()
const addCart = (product, qty) => {
    cart.value = JSON.parse(localStorage.getItem('cart') || '[]')
    const existingItemIndex = cart.value.findIndex(item => item.id === product.id)

    if (existingItemIndex !== -1) {

        cart.value[existingItemIndex].qty += qty
    } else {

        cart.value.push({ ...product, qty: qty })
    }

    localStorage.setItem('cart', JSON.stringify(cart.value))
    getCartCount()
}
</script>
<style scoped></style>
