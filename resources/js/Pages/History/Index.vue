<template>
    <NormalNav name="History" />

    <div class="m-2 mt-19">
        <div class="grid grid-cols-3 gap-4 m-4 p-2">
            <Card v-for="card in cardsData" :name="card.name" :href="card.href" />
        </div>
    </div>
</template>
<script setup>
import Card from '../Components/Card.vue';
import NormalNav from '../Components/NormalNav.vue';
const cardsData = [
    { href: "sale.history", name: "Sales" },
    { href: "purchase.history", name: "Purchases" },
    { href: "product.history", name: "Products" },
    // { href: "purchase.index", name: "Purchase" },
    // { href: "sale.index", name: "Sale" },
    // { href: "history.index", name: "History" },
];
const props = defineProps(['purchases', 'sales'])
</script>
<style scoped></style>
