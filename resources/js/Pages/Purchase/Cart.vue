<template>
    <NormalNav name="Cart" url="purchase.index" />
    <CartForm :suppliers="suppliers" />
</template>
<script setup>
import CartForm from '../Components/CartForm.vue';
import NormalNav from '../Components/NormalNav.vue';
const props = defineProps(['suppliers'])


</script>
<style scoped></style>
