<template>


    <NormalNav :name="sale.voucher_id" url="sale.history" />
    <div class="m-2 mt-20">
        <FwbAlert closable icon type="success" v-if="$page.props.flash.message">{{ $page.props.flash.message }}
        </FwbAlert>
        <FwbCard class="p-3 min-w-full mb-3">
            <h1 class="text-xl mb-2"> {{ sale.customer?.name || "Default Customer" }}</h1>
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
            <div class="px-2 py-1">
                <p class="text-red-500 underline cursor-pointer" @click="() => {
                    router.post(route('sale.destroy', sale))
                }">
                    Delete Voucher
                </p>
            </div>
        </FwbCard>
        <FwbCard class="p-3 min-w-full">
            <div class="flex justify-between items-center">
                <h1 class="text-xl mb-2">Order Summary</h1>
                <p class="cursor-pointer underline text-blue-500 text-xl" @click="edit = !edit">edit</p>
            </div>
            <div class="flex justify-between px-2 py-1" v-for="item in sale.products" :key="item.id">
                <span> {{ item.name }} x {{ item.pivot.quantity }} {{ item.unit }} </span>
                <span>MMK {{ item.pivot.price * item.pivot.quantity }} <svg v-if="edit" @click="() => {
                    router.put(route('sale.update', { sale: sale, product_id: item.id, delete: true }))
                }" class="w-5 h-5 cursor-pointer text-gray-800 dark:text-red-500 inline" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                    </svg>
                </span>
            </div>
            <hr class="h-px my-6 bg-gray-200 border-0 dark:bg-gray-700">
            <div class="flex justify-between px-2 py-1">
                <span>Total: </span>
                <span>MMK {{ grand_total }} </span>
            </div>
            <div class="flex justify-between px-2 py-1">
                <span>paid: </span>
                <span>MMK <span contenteditable @blur="(e) => { paid = e.target.innerText }">{{ sale.paid }}</span>
                </span>
            </div>
            <hr class="h-px my-6 bg-gray-200 border-0 dark:bg-gray-700">
            <div class="flex justify-between px-2 py-1">
                <span>Left: </span>
                <span>MMK {{ grand_total - sale.paid }} </span>
            </div>
        </FwbCard>
        <div v-if="showEdit" class="fixed py-3 bottom-0 left-0 w-full bg-white dark:bg-gray-800 rounded-t-xl px-3">
            <div class="flex justify-center" @click="showEdit = !showEdit">
                <svg class="w-6 h-6 cursor-pointer text-gray-800 dark:text-white hover:text-gray-500 focus:text-gray-500 active:text-gray-500"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path v-if="showEdit" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m19 9-7 7-7-7" />

                    <path v-else stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m5 15 7-7 7 7" />
                </svg>

            </div>

            <div>
                <div class="py-3">
                    <div class="select">
                        <v-select v-model="selectProduct" :options="products.map(p => {
                            return { label: p.name, id: p.id, price: p.price }
                        })" />
                    </div>
                </div>
                <div class="py-3">
                    <Input type="number" v-model="form.price" label="Price" />
                </div>
                <div class="py-3">
                    <Input type="number" v-model="form.quantity" label="Quantity" />
                </div>
                <div class="py-3">
                    <DefaultButton @click="Submit">
                        Submit
                    </DefaultButton>
                </div>
            </div>
        </div>

        <div class="flex justify-center" v-if="!showEdit">
            <button @click="showEdit = !showEdit"
                class="fixed bottom-2 right-[50%] translate-x-[50%] p-3 bg-yellow-500 focus:ring-yellow-800 focus:ring-2 dark:bg-gray-700 dark:focus:ring-gray-500 rounded-2xl">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14m-7 7V5" />
                </svg>
            </button>
        </div>
    </div>

</template>
<script setup>
import { ref, watch } from 'vue';
import NormalNav from '../Components/NormalNav.vue';
import { FwbAlert, FwbCard } from 'flowbite-vue';
import DefaultButton from '../Components/DefaultButton.vue';
import Input from '../Components/Input.vue';
import { router, useForm } from '@inertiajs/vue3';
import { debounce } from 'lodash';


const props = defineProps({
    sale: Object,
    grand_total: Number,
    products: Object
})

const selectProduct = ref(null)
const paid = ref(null)
const showEdit = ref(false);
const edit = ref(false);
const date = ref(new Date(props.sale.created_at));

date.value = `${date.value.toLocaleDateString([], {
    hour: "2-digit",
    minute: "2-digit",
})}`


const form = useForm({
    productId: null,
    price: 0,
    quantity: 1,
});

watch(selectProduct, (p) => {
    form.price = p.price
    form.productId = p.id
})

watch(paid, debounce((p) => {
    router.put(route('sale.update', { sale: props.sale, paid: p, paid_only: true }))
}, 500))


// const className = ref('grid grid-cols-3 w-full font-bold text-md text-center gap-2 px-2 py-2 border-b-1 border-b-gray-500 dark:border-b-gray-700')
// const deleteItem = (id) => {
//     console.log(id)
// }
const Submit = () => {
    form.transform((data) => ({
        ...data,
        _method: "PUT",
    })).post(route('sale.update', props.sale), {
        onSuccess: () => {
            showEdit.value = false;
        }
    })
}
</script>
<style scoped>
.select {

    --vs-border-color: #454545;
    --vs-dropdown-bg: #282c34;
    --vs-dropdown-color: #ffffff;
    --vs-dropdown-option-color: #ffffff;
    --vs-selected-color: #eeeeee;
    --vs-search-input-color: #eeeeee;
}
</style>
