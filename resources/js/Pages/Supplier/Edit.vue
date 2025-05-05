<template>
    <NormalNav name="ရောင်းချသူ" url="supplier.index" />
    <SupplierForm @submit="submit" :supplier="supplier" />
</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import SupplierForm from "../Components/SupplierForm.vue";
import NormalNav from "../Components/NormalNav.vue";

const page = usePage();
const supplier = page.props.supplier;
const submit = (form) => {
    form.transform((data) => ({
        ...data,
        _method: "PUT",
    })).post(route("supplier.update", supplier.id), { forceFormData: true, });
};
</script>
<style scoped></style>
