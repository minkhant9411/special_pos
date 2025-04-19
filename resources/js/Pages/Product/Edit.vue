<template>
    <NormalNav name="Create Product" url="product.index" />
    <ProductForm :categories="categories" @submit="submit" :product="product" />
</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import NormalNav from "../Components/NormalNav.vue";
import ProductForm from "../Components/ProductForm.vue";

const prop = defineProps(["categories", "product"]);
const page = usePage();
const categories = page.props.categories;
const product = page.props.product;
const submit = (form) => {
    form.transform((data) => ({
        ...data,
        _method: "PUT",
    })).post(route("product.update", product), {
        forceFormData: true,
    });
};
</script>
<style scoped></style>
