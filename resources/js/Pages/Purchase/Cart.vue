<template>
    <NormalNav name="Cart" url="purchase.index" />
    <div class="m-2 mt-20">
        <div class="grid grid-cols-2 gap-2">
            <DatePicker v-model="date" @date="(d) => date = d" />
            <Select v-model="supplier" :data="suppliers" name="Supplier" />
            <small class="text-red-500" v-if="page.props.errors.date">{{ page.props.errors.date }}</small>
            <!-- <small class="text-red-500" v-if="page.props.errors.supplier"></small> -->
        </div>
        <div class="h-[340px] overflow-scroll">
            <div v-for="item in cart" :key="item.id"
                class="grid grid-cols-3 gap-2ß px-2 py-2 border-b-1 border-b-gray-500 dark:border-b-gray-700">
                <span class="py-2 mx-auto">
                    <img :src="[item.image_path != null ? '/storage/' + item.image_path : '/storage/profiles/default.png']"
                        class="w-15 h-15 object-cover mx-auto rounded-xl" alt="">
                </span>
                <div class="py-2">
                    <span class="block">{{ item.name }}</span>
                    <span
                        class="flex justify-between items-center py-1 px-2 rounded-4xl bg-gray-200 dark:bg-gray-700 text-sm  text-center mt-3 w-18">
                        <svg @click="() => { --item.qty; changeQty() }"
                            class="w-5 h-5 text-gray-800 dark:text-white cursor-pointer rounded-full p-1 active:bg-gray-400 dark:active:bg-gray-900"
                            aria-hidden="
                            true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14" />
                        </svg>
                        {{ item.qty }}
                        <svg @click="() => { ++item.qty; changeQty() }"
                            class="w-5 h-5 text-gray-800 dark:text-white cursor-pointer rounded-full p-1 active:bg-gray-400 dark:active:bg-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14m-7 7V5" />
                        </svg>
                    </span>
                </div>
                <span class="py-2 mx-auto self-center text-sm">MMK {{ item.price * item.qty }} </span>
                <!-- <spn class="py-2 self-center">
                    <svg @click="deleteItem(item.id)" class="w-5 h-5 mx-auto text-red-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                    </svg>
                </span> -->
            </div>
            <div v-if="cart.length == 0">
                <div colspan="5" class="py-3 text-center">there is no data</div>
            </div>
        </div>
        <div class="fixed py-3 bottom-0 left-0 w-full bg-white dark:bg-gray-800 rounded-t-xl px-3">
            <div class="py-3">
                <h1 class=" font-bold text-2xl">Total: {{ total }}</h1>
                <div class="mt-4">
                    <Input type="number" v-model="paid" placeholder="Paid Amount" />
                    <small class=" text-red-500 " v-if="page.props.errors.paid">{{ page.props.errors.paid }}</small>
                </div>
            </div>
            <div>
                <TextAreaTag v-model="description" />
            </div>
            <DefaultButton @click="Purchase()">
                Purchase
            </DefaultButton>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import NormalNav from '../Components/NormalNav.vue';
import DefaultButton from '../Components/DefaultButton.vue';
import { router, usePage } from '@inertiajs/vue3';
import DatePicker from '../Components/datePicker.vue';
import Select from '../Components/Select.vue';
import TextAreaTag from '../Components/TextAreaTag.vue';
import Input from '../Components/Input.vue';
const cart = ref(JSON.parse(localStorage.getItem("cart")));
const total = ref(0)
const paid = ref(0)
const supplier = ref(null)
const date = ref(null)
const page = usePage()
const description = ref(null)
const props = defineProps({
    suppliers: {
        type: Object,
        default: []
    }
})

const deleteItem = (id) => {
    cart.value = cart.value.filter(c => c.id != id)
    changeQty()
    getTotal()
}
const changeQty = () => {
    localStorage.setItem("cart", JSON.stringify(cart.value))
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


const Purchase = () => {
    // console.log(cart.value, date.value, supplier.value, description.value)
    router.post(route('purchase.store', { purchase: cart.value, date: date.value, supplier_id: supplier.value, description: description.value, paid: paid.value }))

}
</script>
<style scoped></style>
