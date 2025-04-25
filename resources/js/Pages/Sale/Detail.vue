<template>


    <NormalNav :name="sale.voucher_id" url="sale.history" />
    <div class="m-2 mt-20">

        <!-- <div
            class="grid grid-cols-3 w-full font-bold text-lg text-center gap-2 px-2 py-2 border-b-1 border-b-gray-500 dark:border-b-gray-700">
            <div>Name</div>
            <div>Price (mmk)</div>
            <div>Action</div>
        </div> -->
        <FwbCard class="p-3 min-w-full mb-3">
            <h1 class="text-xl mb-2"> {{ sale.customer_id == 1 ? '' : "Default Customer" }}</h1>
            <div class="px-2 py-1">
                <span>Date: </span>
                <span> {{ date }}</span>
            </div>
            <div class="px-2 py-1">
                <span>Voucher: </span>
                <span> #{{ sale.voucher_id }}</span>
            </div>
            <div class="px-2 py-1">
                <span>Description: </span>
                <span> {{ sale.description || 'no description' }}</span>
            </div>
        </FwbCard>
        <FwbCard class="p-3 min-w-full">
            <h1 class="text-xl mb-2">Order Summary</h1>
            <div class="flex justify-between px-2 py-1" v-for="item in sale.products" :key="item.id">
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
                <span>MMK {{ sale.paid }} </span>
            </div>
            <hr class="h-px my-6 bg-gray-200 border-0 dark:bg-gray-700">
            <div class="flex justify-between px-2 py-1">
                <span>Left: </span>
                <span>MMK {{ grand_total - sale.paid }} </span>
            </div>
        </FwbCard>

        <!-- <div v-for="item in sale.products" :key="item.id"
            class="grid grid-cols-3 text-center gap-2 px-2 py-2 border-b-1 border-b-gray-500 dark:border-b-gray-700">
            <div class="py-2 self-center">
                <span class="block ">{{ item.name }}</span>
            </div>
            <div class="py-2 mx-auto self-center text-sm">
                <span class="px-2 py-1">
                    {{ item.pivot.price }} X {{ item.pivot.quantity }} {{ item.unit }}
                </span>
            </div>
            <span class="py-2 self-center">
                <svg @click="deleteItem(item.pivot.id)" class="w-5 h-5 mx-auto text-red-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                </svg>
            </span>
        </div> -->

        <!-- <div class="grid grid-cols-2 gap-2 px-15">
            <span class=" text-start">voucher id : </span>
            <span class="text-end">{{ sale.voucher_id }}</span>
            <span>Customer Name : </span>
            <span class="text-end">{{ sale.customer_id ? sale.customer_id : 'Default Customer' }}</span>

            <span class="text-start">Total</span>
            <span class="text-end">{{ grand_total }}</span>

            <span class="text-start">Paid</span>
            <span class="text-end">{{ sale.paid }}</span>

            <span class="text-start">Left</span>
            <span class="text-end">{{ grand_total - sale.paid }}</span>
        </div> -->
    </div>

</template>
<script setup>
import { ref } from 'vue';
import NormalNav from '../Components/NormalNav.vue';
import { FwbCard } from 'flowbite-vue';
const props = defineProps({
    sale: Object,
    grand_total: Number
})
const date = ref(new Date(props.sale.created_at));
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
