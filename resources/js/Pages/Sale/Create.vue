<template>
    <NormalNav name="Cart" url="sale.index" />
    <CartForm :suppliers="suppliers" :customers="customers" :isPurchase="false" />
</template>
<script setup>
import CartForm from '../Components/CartForm.vue';
import NormalNav from '../Components/NormalNav.vue';
const props = defineProps(['suppliers', 'customers'])


</script>
<style scoped></style>
