<template>
    <NormalNav name="အကောင့်" url="account.index" />
    <AccountForm :stuff="stuff" @submit="submit" :account="account" />
</template>
<script setup>
import NormalNav from "../Components/NormalNav.vue";
import AccountForm from "../Components/AccountForm.vue";

const prop = defineProps({
    stuff: {
        type: Object,
        required: true,
    },
    account: Object
});

const submit = (form) => {
    form.transform((data) => ({
        ...data,
        _method: "PUT",
    })).post(route("account.update", prop.account), {
        forceFormData: true,
    });
};
</script>
<style scoped></style>
