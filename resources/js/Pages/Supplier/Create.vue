<template>
    <NormalNav name="Create Supplier" url="supplier.index" />
    <SupplierForm @submit="submit" />
</template>
<script setup>
import SupplierForm from "../Components/SupplierForm.vue";
import NormalNav from "../Components/NormalNav.vue";
const submit = (form) => {
    form.post(route("supplier.store"));
};
</script>
<style scoped></style>
