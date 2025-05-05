<template>
    <NormalNav name="ဝယ်ယူသူ" url="customer.index" />
    <CustomerForm @submit="submit" :customer="customer" />
</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import CustomerForm from "../Components/CustomerForm.vue";
import NormalNav from "../Components/NormalNav.vue";

const page = usePage();
const customer = page.props.customer;
const submit = (form) => {
    form.transform((data) => ({
        ...data,
        _method: "PUT",
    })).post(route("customer.update", customer.id), { forceFormData: true, });
};
</script>
<style scoped></style>
