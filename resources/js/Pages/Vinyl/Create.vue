<template>

    <Head>
        <title>| Sale Vinyl</title>
    </Head>

    <NormalNav :name="!showCart ? 'Create Vinyl' : 'Vinyl Cart'" url="home" :hasDark="false" :back="!showCart">
        <Cart :qty="allItems.length" @click="showCart = !showCart; cartChange()" v-if="!showCart" />
        <IconWrapper @click="showCart = !showCart" v-else>
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 12h14m-7 7V5" />
            </svg>
        </IconWrapper>
    </NormalNav>
    <div class="flex m-2 h-[90vh] justify-center items-center">

        <div class="w-100">

            <div v-if="$page.props.flash.message"
                class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                {{ $page.props.flash.message }}
            </div>

            <div class=" pt-7">
                <Input vinyl label="Length" @input="getTotal()" v-model="singleItem.length" type="number"
                    placeholder="Length" />
                <Input vinyl label="Width" @input="getTotal()" v-model="singleItem.width" type="number"
                    placeholder="Width" />
                <Input vinyl label="Quantity" @input="getTotal()" v-model="singleItem.quantity" type="number"
                    placeholder="Quantity" />
                <Input vinyl label="Price" @input="getTotal()" v-model="singleItem.price" type="number"
                    placeholder="Price" />
            </div>
        </div>

    </div>
    <div
        class="fixed bottom-0 start-0 w-full bg-white dark:text-white text-black dark:bg-gray-800 rounded-t-md py-5 px-2">
        <div class="flex justify-between items-center">
            <h3>Total-{{ singleItem.total }}</h3>
            <fwb-button class="cursor-pointer" color="default" @click="AddItem()">Add</fwb-button>
        </div>
    </div>
    <div class="fixed top-0 left-0 h-[100vh] w-[100vw] dark:bg-gray-900 z-30" v-if="showCart">
        <div class="m-2 mt-20">
            <div class="grid grid-cols-2 gap-2">
                <DatePicker v-model="form.date" @date="(d) => {
                    const date = new Date(d);
                    form.date = date.toLocaleString('sv-SE', { timeZone: 'Asia/Yangon' }).replace(' ', 'T');
                }" />
                <Select v-model="form.customer_id" :data="customers" name="Customer" />
                <small class="text-red-500" v-if="$page.props.errors">{{ $page.props.errors.date }}</small>
                <small class="text-red-500" v-if="$page.props.errors">{{ $page.props.errors.customer_id
                }}</small>
            </div>
            <div class="overflow-scroll">
                <div v-for="item in allItems" :key="item.id"
                    class="grid grid-cols-2 gap-2 py-2 border-b-1 border-b-gray-500 dark:border-b-gray-700 px-10">
                    <div class="py-4 flex">
                        <span class="block">{{ item.width }}x{{ item.length }}</span>
                        <span
                            class="flex justify-between items-center py-1 px-2 rounded-4xl bg-gray-200 dark:bg-gray-700 text-sm  text-center ms-3 w-18">
                            <svg @click="() => { --item.quantity; cartChange() }"
                                class="w-5 h-5 text-gray-800 dark:text-white cursor-pointer rounded-full p-1 active:bg-gray-400 dark:active:bg-gray-900"
                                aria-hidden="
                            true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 12h14" />
                            </svg>
                            {{ item.quantity }}
                            <svg @click="() => { ++item.quantity; cartChange() }"
                                class="w-5 h-5 text-gray-800 dark:text-white cursor-pointer rounded-full p-1 active:bg-gray-400 dark:active:bg-gray-900"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 12h14m-7 7V5" />
                            </svg>
                        </span>
                    </div>
                    <div class="py-2 mx-auto self-center text-sm">MMK
                        <span class="py-1" contenteditable
                            @blur="(e) => { item.price = e.target.innerText; cartChange() }">
                            {{ item.price * item.width * item.length }}
                        </span>
                        X {{ item.quantity }}
                    </div>
                </div>
                <div v-if="allItems.length == 0">
                    <div colspan="5" class="py-3 text-center text-red-500" v-if="$page.props.errors.products">
                        {{ $page.props.errors.products }}</div>
                    <div colspan="5" class="py-3 text-center" v-else>there is no data</div>
                </div>
            </div>
            <div class="fixed py-3 bottom-0 left-0 w-full bg-white dark:bg-gray-800 rounded-t-xl px-3">
                <div class="flex justify-center" @click="showTotal = !showTotal; cartChange()">
                    <svg class="w-6 h-6 cursor-pointer text-gray-800 dark:text-white hover:text-gray-500 focus:text-gray-500 active:text-gray-500"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path v-if="showTotal" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="m19 9-7 7-7-7" />

                        <path v-else stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="m5 15 7-7 7 7" />
                    </svg>

                </div>

                <div v-if="showTotal">
                    <div class="py-3">
                        <h1 class=" font-bold text-2xl">Total: {{ allTotal }}</h1>
                        <div class="mt-4">
                            <label for="paid">Paid</label>
                            <Input type="number" v-model="form.paid" placeholder="Paid Amount" />
                            <small class=" text-red-500 " v-if="$page.props.errors.paid">{{ $page.props.errors.paid
                            }}</small>
                        </div>
                    </div>
                    <div>
                        <TextAreaTag v-model="form.description" />
                    </div>
                    <DefaultButton @click="Submit()">
                        Submit
                    </DefaultButton>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { FwbButton } from 'flowbite-vue';
import Cart from '../Components/Cart.vue';
import Input from '../Components/Input.vue';
import NormalNav from '../Components/NormalNav.vue';
import { ref } from 'vue';
import IconWrapper from '../Components/IconWrapper.vue';
import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import DatePicker from '../Components/datePicker.vue';
import Select from '../Components/Select.vue';
import DefaultButton from '../Components/DefaultButton.vue';
import TextAreaTag from '../Components/TextAreaTag.vue';
const props = defineProps({
    customers: Object,
    voucher_id: String
})
/**
 * for adding item to cart
 * **/
const showCart = ref(false)
const allTotal = ref(0)
const allItems = ref(JSON.parse(localStorage.getItem('vinyl-cart') || '[]'));
const singleItem = reactive({
    id: null,
    length: null,
    width: null,
    price: null,
    quantity: null,
    total: 0
});

const AddItem = () => {
    // if (!confirm(`
    // size:${singleItem.length}*${singleItem.width},
    // price:${singleItem.price},
    // quantity:${singleItem.quantity}`)) {
    //     return
    // };
    singleItem.id = allItems.value.length <= 0 ? singleItem.id++ : allItems.value[allItems.value.length - 1].id + 1
    allItems.value.push({ ...singleItem })
    localStorage.setItem('vinyl-cart', JSON.stringify(allItems.value))
    for (const key in singleItem) {
        if (key != 'id') singleItem[key] = null;
    }

}

const getTotal = () => {
    if (singleItem.length != null && singleItem.width != null && singleItem.price != null && singleItem.quantity != null)
        singleItem.total = singleItem.length * singleItem.width * singleItem.quantity * singleItem.price
}

/**
 * for adding cart to server
 * **/
const showTotal = ref();
const form = useForm({
    allItems: null,
    date: null,
    customer_id: null,
    description: null,
    paid: 0,
    voucher_id: props.voucher_id
});

const cartChange = () => {
    allTotal.value = 0;
    allItems.value.map((item) => {
        allTotal.value += item.width * item.length * item.price * item.quantity
        if (item.quantity <= 0) allItems.value = allItems.value.filter(i => i.id != item.id)
    })
    localStorage.setItem("vinyl-cart", JSON.stringify(allItems.value))

}

const Submit = () => {
    // confirm(`are you sure`);
    form.allItems = allItems.value;
    form.post(route('vinyl.store'), {
        onSuccess: () => {
            allItems.value = []
            cartChange()
        }
    })
}
</script>
<style scoped></style>
