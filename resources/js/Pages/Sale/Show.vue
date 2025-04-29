<template>
    <PSHistoryTemplate :data='sales' :totalAmount="totalAmount" name="အရောင်း" />
</template>
<script setup>
import PSHistoryTemplate from '../Components/PSHistoryTemplate.vue';


defineProps({
    sales: Object,
    totalAmount: Number
})

</script>
<style scoped></style>
