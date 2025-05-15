<template>
    <NormalNav name="အကောင့်" url="stuff.index" />
    <StuffForm @submit="submit" />
</template>
<script setup>
import StuffForm from "../Components/StuffForm.vue";
import NormalNav from "../Components/NormalNav.vue";
const submit = (form) => {
    form.post(route("stuff.store"));
};
</script>
<style scoped></style>
