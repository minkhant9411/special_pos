<template>
    <NormalNav name="အဝယ်" :hasDark="false">
        <Link
            class="cursor-pointer dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none rounded-lg text-sm p-2.5"
            :href="route('purchase.history')">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 3v4a1 1 0 0 1-1 1H5m4 10v-2m3 2v-6m3 6v-3m4-11v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
        </svg>
        </Link>
        <Cart url="purchase.create" :qty="quantity" />

    </NormalNav>
    <div class="mt-21 m-3">
        <Alert />
        <Filter :categories="categories" />
        <ProductCard @add-cart="addCart" :datas="products" />
    </div>
</template>
<script setup>
import { ref } from 'vue';
import Cart from '../Components/Cart.vue';
import Filter from '../Components/Filter.vue';
import NormalNav from '../Components/NormalNav.vue';
import Alert from '../Components/Alert.vue';
import { usePage } from '@inertiajs/vue3';
import ProductCard from '../Components/ProductCard.vue';
const cart = ref(JSON.parse(localStorage.getItem('purchase-cart') || '[]'))
const quantity = ref(0)
const page = usePage();
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
    if (page.props.flash.message) quantity.value = 0

}
getCartCount()
const addCart = ([product, qty]) => {
    cart.value = JSON.parse(localStorage.getItem('purchase-cart') || '[]')
    const existingItemIndex = cart.value.findIndex(item => item.id === product.id)

    if (existingItemIndex !== -1) {

        cart.value[existingItemIndex].qty += qty
    } else {

        cart.value.push({ ...product, qty: qty })
    }
    localStorage.setItem('purchase-cart', JSON.stringify(cart.value))
    getCartCount()
}
</script>
<style scoped></style>
