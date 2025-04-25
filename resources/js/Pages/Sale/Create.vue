<template>
    <NormalNav name="Cart" url="sale.index" />
    <CartForm :customers="customers" :isPurchase="false" :voucher_id="voucher_id" />
</template>
<script setup>
import CartForm from '../Components/CartForm.vue';
import NormalNav from '../Components/NormalNav.vue';
const props = defineProps(['voucher_id', 'customers'])


</script>
<style scoped></style>
