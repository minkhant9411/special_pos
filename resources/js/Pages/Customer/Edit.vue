<template>
    <NormalNav name="Edit Customer" url="customer.index" />
    <CustomerForm @submit="submit" :customer="customer" />
</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import CustomerForm from "../Components/CustomerForm.vue";
import NormalNav from "../Components/NormalNav.vue";

const page = usePage();
const customer = page.props.customer;
const submit = (data) => {
    data.put(route("customer.update", customer.id), {});
};
</script>
<style scoped></style>
