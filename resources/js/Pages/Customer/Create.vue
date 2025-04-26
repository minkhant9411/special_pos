<template>
    <NormalNav name="Create Customer" url="customer.index" />
    <CustomerForm @submit="submit" />
</template>
<script setup>
import CustomerForm from "../Components/CustomerForm.vue";
import NormalNav from "../Components/NormalNav.vue";
const submit = (form) => {
    form.post(route("customer.store"));
};
</script>
<style scoped></style>
