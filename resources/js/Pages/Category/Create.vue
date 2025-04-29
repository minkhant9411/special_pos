<template>
    <NormalNav name="အမျိုးအစား" url="category.index" />
    <CategoryForm @submit="submit" />
</template>
<script setup>
import CategoryForm from "../Components/CategoryForm.vue";
import NormalNav from "../Components/NormalNav.vue";
const submit = (form) => {
    form.post(route("category.store"));
};
</script>
<style scoped></style>
