<template>

    <PSHistoryTemplate :data='purchases' :totalAmount="totalAmount" name="Purchase" />
</template>
<script setup>
import PSHistoryTemplate from '../Components/PSHistoryTemplate.vue';


defineProps({
    purchases: Object,
    totalAmount: Number
})

</script>
<style scoped></style>
