<template>
    <NormalNav name="Sale">
        <Cart url="sale.create" :qty="quantity" />
    </NormalNav>
    <div class="mt-21 m-2">
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
const cart = ref(JSON.parse(localStorage.getItem('sale-cart') || '[]'))
const quantity = ref(0)
const page = usePage();
const props = defineProps({
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
    cart.value = JSON.parse(localStorage.getItem('sale-cart') || '[]')
    const existingItemIndex = cart.value.findIndex(item => item.id === product.id)

    if (existingItemIndex !== -1) {

        cart.value[existingItemIndex].qty += qty
    } else {

        cart.value.push({ ...product, qty: qty })
    }
    localStorage.setItem('sale-cart', JSON.stringify(cart.value))
    getCartCount()
}
</script>
<style scoped></style>
