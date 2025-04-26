<template>


    <NormalNav :name="purchase.voucher_id" url="purchase.history" />
    <div class="m-2 mt-20">


        <FwbCard class="p-3 min-w-full mb-3">
            <h1 class="text-xl mb-2"> {{ purchase.supplier.name || "Default Supplier" }}</h1>
            <div class="px-2 py-1">
                <span>Date: </span>
                <span> {{ date }}</span>
            </div>
            <div class="px-2 py-1">
                <span>Voucher: </span>
                <span> #{{ purchase.voucher_id }}</span>
            </div>
            <div class="px-2 py-1">
                <span>Description: </span>
                <span> {{ purchase.description || 'no description' }}</span>
            </div>
        </FwbCard>
        <FwbCard class="p-3 min-w-full">
            <h1 class="text-xl mb-2">Order Summary</h1>
            <div class="flex justify-between px-2 py-1" v-for="item in purchase.products" :key="item.id">
                <span> {{ item.name }} X {{ item.pivot.quantity }} {{ item.unit }} </span>
                <span>MMK {{ item.pivot.price * item.pivot.quantity }} </span>
            </div>
            <hr class="h-px my-6 bg-gray-200 border-0 dark:bg-gray-700">
            <div class="flex justify-between px-2 py-1">
                <span>Total: </span>
                <span>MMK {{ grand_total }} </span>
            </div>
            <div class="flex justify-between px-2 py-1">
                <span>paid: </span>
                <span>MMK {{ purchase.paid }} </span>
            </div>
            <hr class="h-px my-6 bg-gray-200 border-0 dark:bg-gray-700">
            <div class="flex justify-between px-2 py-1">
                <span>Left: </span>
                <span>MMK {{ grand_total - purchase.paid }} </span>
            </div>
        </FwbCard>


    </div>

</template>
<script setup>
import { ref } from 'vue';
import NormalNav from '../Components/NormalNav.vue';
import { FwbCard } from 'flowbite-vue';
const props = defineProps({
    purchase: Object,
    grand_total: Number
})
const date = ref(new Date(props.purchase.created_at));
date.value = `${date.value.toLocaleDateString([], {
    hour: "2-digit",
    minute: "2-digit",
})}`

const className = ref('grid grid-cols-3 w-full font-bold text-md text-center gap-2 px-2 py-2 border-b-1 border-b-gray-500 dark:border-b-gray-700')
const deleteItem = (id) => {
    console.log(id)
}
</script>
<style scoped></style>
