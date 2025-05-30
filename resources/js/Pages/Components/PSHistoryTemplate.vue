<template>
    <NormalNav :name="name" url="history.index" />
    <div class="m-3 my-20">
        <FwbAlert closable icon type="danger" class="my-2" v-if="$page.props.flash.message">{{ $page.props.flash.message
            }}
        </FwbAlert>
        <!-- <FwbAlert closable icon type="danger" v-if="$page.props.flash.d_message">{{ $page.props.flash.d_message }}
        </FwbAlert> -->
        <div class="grid grid-cols-2 gap-2">
            <Input type="search" placeholder="Search Voucher" v-model="filter.search" />
            <div class="relative">
                <label for="Date" class="absolute inset-y-0 start-0 flex items-center ps-3.5">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </label>
                <input id="Date" type="date" v-model="filter.date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ps-10  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        </div>
        <div
            class=" dark:bg-gray-800 bg-white border border-t dark:border-gray-700 border-gray-200  p-6 rounded-t-lg flex justify-end fixed bottom-0 left-0 right-0">
            <span> {{ name }} Total : {{ totalAmount }}</span>
        </div>
        <template v-if="data.length > 0">
            <FwbCard class="mt-3 min-w-full" v-for="item in data" :key="item.id">
                <div class="flex justify-between">
                    <h5 class=" p-2"> {{ item.voucher_id }}</h5>
                    <h5 class=" p-2">{{ new Date(item.created_at).toLocaleDateString([], {
                        hour: "2-digit",
                        minute: "2-digit",
                    }) }}</h5>
                </div>
                <div class="px-5 pb-5">
                    <div class="my-3">
                        <h3 class=" font-bold text-xl mb-2" v-if="'customer' in item">
                            {{ item.customer?.name || 'Default Customer' }}
                        </h3>
                        <h3 class=" font-bold text-xl mb-2" v-else>
                            {{ item.supplier?.name || 'Default Supplier' }}
                        </h3>
                        <p v-if="!item.voucher_id.startsWith('V-')">Total amount : {{item.products.reduce((sum, item) => {
                            return sum + (item.pivot.quantity * item.pivot.price);
                            }, 0)}}</p>
                        <p v-else>Total amount : {{item.vinyls.reduce((sum, item) => {
                            return sum + (item.length * item.width * item.pivot.quantity * item.pivot.price);
                        }, 0)}}</p>
                        <p>Paid amount : {{ item.paid }}</p>
                        <p v-if="!item.voucher_id.startsWith('V-')">Left amount :
                            {{
                                item.products.reduce((sum, item) => {
                                    return sum + (item.pivot.quantity * item.pivot.price);
                                }, 0) - item.paid
                            }}
                        </p>
                        <p v-else>Left amount :
                            {{
                                item.vinyls.reduce((sum, item) => {
                                    return sum + (item.length * item.width * item.pivot.quantity * item.pivot.price);
                                }, 0) - item.paid
                            }}
                        </p>

                    </div>
                    <div class="flex">
                        <FwbButton class="w-full text-center">
                            <Link class="block w-full h-full"
                                :href="route('customer' in item ? 'sale.show' : 'purchase.show', { id: item.voucher_id })">
                            Show
                            Detail
                            </Link>
                        </FwbButton>
                    </div>
                </div>
            </FwbCard>
        </template>
        <template v-else>
            <p class="text-center p-5">
                there is no report in this day
            </p>
        </template>
    </div>
    <!-- <fwb-modal /> -->
</template>
<script setup>
import { FwbAlert, FwbButton, FwbCard } from 'flowbite-vue';
import NormalNav from '../Components/NormalNav.vue';
import Input from './Input.vue';
import { reactive, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { router } from '@inertiajs/vue3';

defineProps({
    data: Object,
    totalAmount: Number,
    name: String
})

const page = usePage();
const queryParams = Object.fromEntries(
    new URLSearchParams(page.url.split("?")[1])
);
const filter = reactive({
    search: queryParams.search || null,
    date: queryParams.date || new Date().toLocaleDateString('sv-SE', { timeZone: 'Asia/Yangon' })
})
watch(filter, debounce(filter => {
    let date = new Date(filter.date).toLocaleString('sv-SE', { timeZone: 'Asia/Yangon' }).replace(' ', 'T');

    if (filter.date == null || filter.date == '') {
        date = null
    }
    router.get('', { search: filter.search, date: date }, {
        preserveState: true,
        preserveUrl: true,
        onSuccess: (e) => {
        }
    })
}, 500))
</script>
<style scoped></style>
