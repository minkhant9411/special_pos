<template>
    <NormalNav name="Products" />
    <div class="m-2 mt-20">
        <div v-if="$page.props.flash.message"
            class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            {{ $page.props.flash.message }}
        </div>
        <Filter :categories="categories" />
        <div v-for="product in products" :key="product.id">
            <SingleProduct :product="product" />
        </div>
        <AddButton href="product.create" />
    </div>
</template>
<script setup>
import AddButton from "../Components/AddButton.vue";
import Filter from "../Components/Filter.vue";
import NormalNav from "../Components/NormalNav.vue";
import SingleProduct from "../Components/SingleProduct.vue";
const prop = defineProps({
    products: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
});
</script>
<style scoped></style>
