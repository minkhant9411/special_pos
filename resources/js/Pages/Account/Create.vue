<template>
    <NormalNav name="အကောင့်" url="account.index" />
    <AccountForm :stuff="stuff" @submit="submit" />
</template>
<script setup>
import NormalNav from "../Components/NormalNav.vue";
import AccountForm from "../Components/AccountForm.vue";

const prop = defineProps({
    stuff: {
        type: Object,
        required: true,
    },
});

const submit = (form) => {
    form.post(route("account.store"), { forceFormData: true });
};
</script>
<style scoped></style>
