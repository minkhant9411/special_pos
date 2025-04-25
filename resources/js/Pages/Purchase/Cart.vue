<template>
    <NormalNav name="Cart" url="purchase.index" />
    <CartForm :suppliers="suppliers" :voucher_id="voucher_id" />
</template>
<script setup>
import CartForm from '../Components/CartForm.vue';
import NormalNav from '../Components/NormalNav.vue';
const props = defineProps(['suppliers', 'voucher_id'])


</script>
<style scoped></style>
