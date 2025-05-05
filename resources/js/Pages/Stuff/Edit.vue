<template>
    <NormalNav name="ဝန်ထမ်း" url="stuff.index" />
    <StuffForm @submit="submit" :stuff="stuff" />
</template>
<script setup>
import { usePage } from "@inertiajs/vue3";
import StuffForm from "../Components/StuffForm.vue";
import NormalNav from "../Components/NormalNav.vue";

const page = usePage();
const stuff = page.props.stuff;
const submit = (form) => {
    form.transform((data) => ({
        ...data,
        _method: "PUT",
    })).post(route("stuff.update", stuff.id), { forceFormData: true, });
};
</script>
<style scoped></style>
