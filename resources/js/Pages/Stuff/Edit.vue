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
const submit = (data) => {
    data.put(route("stuff.update", stuff.id), {});
};
</script>
<style scoped></style>
