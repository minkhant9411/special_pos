<template>
    <NormalNav name="Sale History" url="history.index" />
    <div class="m-3 my-20">

        <div
            class=" dark:bg-gray-800 bg-white border border-t dark:border-gray-700 border-gray-200  p-6 rounded-t-lg flex justify-end fixed bottom-0 left-0 right-0">
            <span>Today Sale Total : {{ totalAmount }}</span>
        </div>
        <FwbCard class="mt-3 min-w-full" v-for="sale in sales" :key="sale.id">
            <h5 class=" p-2 text-end">Voucher : {{ sale.voucher_id }}</h5>
            <div class="px-5 pb-5">
                <div class="my-3">
                    <h3 class=" font-bold text-xl mb-2"> {{ sale.customer?.name || 'Default Customer' }}</h3>
                    <p>Paid amount : {{ sale.paid }}</p>
                    <p>Left amount : {{
                        sale.products.reduce((sum, item) => {
                            return sum + (item.pivot.quantity * item.pivot.price);
                        }, 0) - sale.paid
                    }}</p>
                </div>
                <div class="flex">
                    <FwbButton class="w-full text-center" @click="showModel = !showModel">Show Detail</FwbButton>
                </div>
            </div>
        </FwbCard>
    </div>
    <!-- <fwb-modal /> -->
</template>
<script setup>
import { FwbButton, FwbCard } from 'flowbite-vue';
import NormalNav from '../Components/NormalNav.vue';
import { ref } from 'vue';
const showModel = ref(false)
defineProps({
    sales: Object,
    totalAmount: Number
})

</script>
<style scoped></style>
