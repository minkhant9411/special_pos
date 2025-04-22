<template>
    <div class="m-2 mt-20">
        <div class="grid grid-cols-2 gap-2">
            <DatePicker v-model="form.date" @date="(d) => {
                const date = new Date(d);
                form.date = date.toLocaleString('sv-SE', { timeZone: 'Asia/Yangon' }).replace(' ', 'T');
            }" />
            <Select v-if="isPurchase" v-model="form.supplier_id" :data="suppliers" name="Supplier" />
            <Select v-else v-model="form.customer_id" :data="customers" name="Customer" />
            <small class="text-red-500" v-if="page.props.errors.date">{{ page.props.errors.date }}</small>
            <small class="text-red-500" v-if="page.props.errors.supplier_id">{{ page.props.errors.supplier_id }}</small>
            <small class="text-red-500" v-if="page.props.errors.customer_id">{{ page.props.errors.customer_id }}</small>
        </div>
        <div class="overflow-scroll">
            <div v-for="item in cart" :key="item.id"
                class="grid grid-cols-3 gap-2ß px-2 py-2 border-b-1 border-b-gray-500 dark:border-b-gray-700">
                <span class="py-2 mx-auto">
                    <img :src="[item.image_path != null ? '/storage/' + item.image_path : '/storage/profiles/default.jpg']"
                        class="w-15 h-15 object-contain mx-auto rounded-xl" alt="">
                </span>
                <div class="py-2">
                    <span class="block">{{ item.name }}</span>
                    <span
                        class="flex justify-between items-center py-1 px-2 rounded-4xl bg-gray-200 dark:bg-gray-700 text-sm  text-center mt-3 w-18">
                        <svg @click="() => { --item.qty; cartChange() }"
                            class="w-5 h-5 text-gray-800 dark:text-white cursor-pointer rounded-full p-1 active:bg-gray-400 dark:active:bg-gray-900"
                            aria-hidden="
                            true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14" />
                        </svg>
                        {{ item.qty }}
                        <svg @click="() => { ++item.qty; cartChange() }"
                            class="w-5 h-5 text-gray-800 dark:text-white cursor-pointer rounded-full p-1 active:bg-gray-400 dark:active:bg-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14m-7 7V5" />
                        </svg>
                    </span>
                </div>
                <div class="py-2 mx-auto self-center text-sm">MMK
                    <span class="px-2 py-1" contenteditable
                        @blur="(e) => { item.price = e.target.innerText; cartChange() }">
                        {{ item.price }}
                    </span>
                    X {{ item.qty }}
                </div>
                <!-- <spn class="py-2 self-center">
                    <svg @click="deleteItem(item.id)" class="w-5 h-5 mx-auto text-red-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                    </svg>
                </span> -->
            </div>
            <div v-if="cart.length == 0">
                <div colspan="5" class="py-3 text-center text-red-500" v-if="$page.props.errors.products">
                    {{ $page.props.errors.products }}</div>
                <div colspan="5" class="py-3 text-center" v-else>there is no data</div>
            </div>
        </div>
        <div class="fixed py-3 bottom-0 left-0 w-full bg-white dark:bg-gray-800 rounded-t-xl px-3">
            <div class="flex justify-center" @click="showTotal = !showTotal">
                <svg class="w-6 h-6 cursor-pointer text-gray-800 dark:text-white hover:text-gray-500 focus:text-gray-500 active:text-gray-500"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path v-if="showTotal" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m19 9-7 7-7-7" />

                    <path v-else stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m5 15 7-7 7 7" />
                </svg>

            </div>

            <div v-if="showTotal">
                <div class="py-3">
                    <h1 class=" font-bold text-2xl">Total: {{ total }}</h1>
                    <div class="mt-4">
                        <label for="paid">Paid</label>
                        <Input id="paid" type="number" v-model="form.paid" placeholder="Paid Amount" />
                        <small class=" text-red-500 " v-if="page.props.errors.paid">{{ page.props.errors.paid }}</small>
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
</template>
<script setup>
import { ref } from 'vue';
import DefaultButton from '../Components/DefaultButton.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import DatePicker from '../Components/datePicker.vue';
import Select from '../Components/Select.vue';
import TextAreaTag from '../Components/TextAreaTag.vue';
import Input from '../Components/Input.vue';

const props = defineProps({
    isPurchase: { type: Boolean, default: true },
    suppliers: { type: Object, default: [] },
    customers: { type: Object, default: [] }
})


const form = useForm({
    products: null,
    date: null,
    supplier_id: null,
    customer_id: null,
    description: null,
    paid: 0,
    voucher_id: Math.floor(Math.random() * 1000000)
});

const cart = ref(JSON.parse(localStorage.getItem(props.isPurchase ? "purchase-cart" : "sale-cart")) || []);
const total = ref(0)
const showTotal = ref(false)
const page = usePage()


const deleteItem = (id) => {
    cart.value = cart.value.filter(c => c.id != id)
    cartChange()
    getTotal()
}
const cartChange = () => {
    localStorage.setItem(props.isPurchase ? "purchase-cart" : "sale-cart", JSON.stringify(cart.value))
    getTotal()

}
const getTotal = () => {
    total.value = 0
    cart.value.map((item) => {
        total.value += item.price * item.qty
        if (item.qty <= 0) deleteItem(item.id)

    })
}
getTotal()

const Submit = () => {
    // console.log(form)
    form.products = cart.value.map(c => {
        return { 'product_id': c.id, 'qty': c.qty, 'price': c.price }
    })
    form.post(route(props.isPurchase ? 'purchase.store' : 'sale.store'), {
        onSuccess: () => {
            cart.value = [];
            cartChange()
        }
    })

}
</script>
<style scoped></style>
