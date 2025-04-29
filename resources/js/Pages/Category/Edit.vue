<template>
    <NormalNav name="အမျိုးအစား" url="category.index" />
    <CategoryForm @submit="submit" :category="category" />
</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import CategoryForm from "../Components/CategoryForm.vue";
import NormalNav from "../Components/NormalNav.vue";

const page = usePage();
const category = page.props.category;
const submit = (data) => {
    data.put(route("category.update", category), {});
};
</script>
<style scoped></style>
