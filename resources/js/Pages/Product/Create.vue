<template>
    <NormalNav name="ပစ္စည်း" url="product.index" />
    <ProductForm :categories="categories" @submit="submit" />
</template>
<script setup>
import NormalNav from "../Components/NormalNav.vue";
import ProductForm from "../Components/ProductForm.vue";

const prop = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const submit = (form) => {
    form.post(route("product.store"), { forceFormData: true });
};
</script>
<style scoped></style>
