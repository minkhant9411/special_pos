<template>
    <NormalNav name="Edit Supplier" url="supplier.index" />
    <SupplierForm @submit="submit" :supplier="supplier" />
</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import SupplierForm from "../Components/SupplierForm.vue";
import NormalNav from "../Components/NormalNav.vue";

const page = usePage();
const supplier = page.props.supplier;
const submit = (data) => {
    data.put(route("supplier.update", supplier.id), {});
};
</script>
<style scoped></style>
