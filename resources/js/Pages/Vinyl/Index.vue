<template>

    <NormalNav name="Vinyl" url="history.index" />
    <div class="m-2 my-20">
        <div class="grid grid-cols-2 gap-2">
            <!-- <Select v-model="filter.search" :data="customers" name="All Customers" /> -->
            <Input type="search" v-model="filter.search" placeholder="Search Customer" />
            <!-- <v-select class="select" v-model="filter.search" :options="customers.map(p => {
                return { label: p.name, id: p.id }
            })" /> -->
            <div class="relative">
                <label for="Date" class="absolute inset-y-0 start-0 flex items-center ps-3.5">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </label>
                <input type="month" v-model="filter.date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ps-10  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

        </div>

        <FwbTable hoverable class="rounded-lg cursor-pointer mt-2">
            <FwbTableHead>
                <FwbTableHeadCell>
                    Name
                </FwbTableHeadCell>
                <FwbTableHeadCell>
                    Total Amount
                </FwbTableHeadCell>
                <FwbTableHeadCell>
                    Total Length
                </FwbTableHeadCell>
            </FwbTableHead>
            <FwbTableBody>
                <template v-for="data in customersData">
                    <FwbTableRow @click="showModal(data)"
                        class=" border-b border-gray-200 dark:border-gray-700 rounded-lg dark:hover:bg-gray-600">
                        <FwbTableCell>
                            {{ data.customer_name }}
                        </FwbTableCell>
                        <FwbTableCell>
                            {{ data.totalpaid }}
                        </FwbTableCell>
                        <FwbTableCell>
                            {{ data.totalfeet }}
                        </FwbTableCell>
                    </FwbTableRow>
                </template>

                <FwbTableRow class="border-b border-gray-200 dark:border-gray-700 rounded-lg dark:hover:bg-gray-600">
                    <FwbTableCell colspan="4">
                        <div ref="loader">
                            <div v-if="vinylPagination.next_page_url" role="status"
                                class="p-4 border border-gray-200  rounded-sm shadow-sm animate-pulse md:p-6 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center justify-between">
                                        <div
                                            class="flex items-center justify-center h-20 w-20 me-2 bg-gray-300 rounded-sm dark:bg-gray-700">
                                            <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 16 20">
                                                <path
                                                    d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z" />
                                                <path
                                                    d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5">
                                            </div>
                                            <div class="w-32 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
                                        </div>
                                    </div>
                                    <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-700 w-12"></div>
                                </div>
                                <span class="sr-only">Loading...</span>
                            </div>

                            <div v-else class="text-center">
                                no more data
                            </div>
                        </div>
                    </FwbTableCell>
                </FwbTableRow>
            </FwbTableBody>
        </FwbTable>
    </div>
    <div
        class=" dark:bg-gray-800 bg-white border border-t dark:border-gray-700 border-gray-200  p-6 rounded-t-lg flex justify-between fixed bottom-0 left-0 right-0 items-center">
        <Link :href="route('vinyl.create')">
        <fwb-button color="default">Create Vinyl</fwb-button>
        </Link>
    </div>

    <div class="relative top-0 left-0 w-[100vw] h-[100vh] modal" @click.self="modalShow = !modalShow" v-if="modalShow">
        <div
            class="absolute w-100 h-[100vh] overflow-y-auto  bg-gray-950 top-1/2 left-1/2  transform -translate-x-1/2 -translate-y-1/2 rounded">
            <div class=" sticky top-0 left-0 right-0 bg-gray-900 flex justify-between p-3">
                <h1 class="font-bold self-center p">Debt Left</h1>
                <IconWrapper class="w-11 h-11" @click="modalShow = !modalShow">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                </IconWrapper>
            </div>
            <div class=" m-2">
                <div v-if="modalData">

                    <template v-for="(item, index) in modalData" :key="index">
                        <FwbCard class="p-3 min-w-full mb-3">

                            <div class="px-2 py-1">
                                <span>Date: </span>
                                <span> {{ new Date(item.date).toLocaleDateString([], {
                                    hour: "2-digit",
                                    minute: "2-digit",
                                }) }}</span>
                            </div>
                            <div class="px-2 py-1">
                                <span>Voucher: </span>
                                <span>
                                    <Link class=" text-blue-600 underline"
                                        :href="route('sale.show', { id: item.voucher_id })">{{ item.voucher_id }}
                                    </Link>
                                </span>
                            </div>
                            <hr class="h-px my-3 bg-gray-200 border-0 dark:bg-gray-700">
                            <div class="flex justify-between px-2 py-1">
                                <span>Total: {{ item.total }}</span>
                                <span>MMK </span>
                            </div>
                            <div class="flex justify-between px-2 py-1">
                                <span>paid: {{ item.paid }}</span>
                                <span>MMK </span>
                            </div>
                            <hr class="h-px my-3 bg-gray-200 border-0 dark:bg-gray-700">
                            <div class="flex justify-between px-2 py-1">
                                <span>Left:{{ item.total - item.paid }} </span>
                                <span>MMK </span>
                            </div>
                        </FwbCard>
                    </template>
                </div>
            </div>
        </div>
    </div>

</template>
<script setup>
import { FwbButton, FwbCard, FwbTable, FwbTableBody, FwbTableCell, FwbTableHead, FwbTableHeadCell, FwbTableRow } from 'flowbite-vue';
import NormalNav from '../Components/NormalNav.vue';
import { onMounted, onUnmounted, reactive, ref, watch } from 'vue';
import { debounce } from 'lodash';
import { router, usePage } from '@inertiajs/vue3';
import Select from '../Components/Select.vue';
import Input from '../Components/Input.vue';
import IconWrapper from '../Components/IconWrapper.vue';
import axios from 'axios';
const modalShow = ref(false)
const modalData = ref([])
const loader = ref(null)
const page = usePage();
const queryParams = Object.fromEntries(
    new URLSearchParams(page.url.split("?")[1])
);
const filter = reactive({
    search: queryParams.search || null,
    date: queryParams.date || new Date().toISOString().slice(0, 7)

})
const prop = defineProps({
    customers: Object,
    vinyls: Object,
    vinylPagination: Object,
    customersData: Object
})
watch(filter, debounce(filter => {
    router.get('', { search: filter.search, date: filter.date }, {
        preserveState: true,
        preserveUrl: true,
        onSuccess: (e) => {
        }
    })
}, 500))
const checkVisibility = () => {
    if (!loader.value) return;

    const rect = loader.value.getBoundingClientRect();
    if (rect.top < window.innerHeight) {
        loadMore();
    }
};

const loadMore = () => {
    if (!prop.vinylPagination.next_page_url) return
    router.get(prop.vinylPagination.next_page_url, {}, {
        preserveState: true,
        preserveScroll: true,
        preserveUrl: true,
        only: ['vinyls', 'vinylPagination', 'grand_total']
    });
};

onMounted(() => {
    window.addEventListener('scroll', checkVisibility);
    checkVisibility(); // Trigger immediately
});

onUnmounted(() => {
    window.removeEventListener('scroll', checkVisibility);
});


const showModal = (data) => {
    modalShow.value = !modalShow.value;
    axios.get(route('customer.history', { id: data.customer_id })).then(res => modalData.value = res.data);
}
</script>

<style>
table th td {
    border: 1px;
}



/* :deep(.v-input__control) {
    height: 60px !important;
} */

/* .select {
    @apply bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500;
} */
</style>
