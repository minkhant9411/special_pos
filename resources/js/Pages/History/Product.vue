<template>

    <NormalNav name="စာရင်း" url="history.index" />
    <div class="m-2 mt-20">
        <div class="mb-2 grid grid-cols-2 gap-2">
            <FwbInput v-model="filter.search" placeholder="Search" type="search" />
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
        <div class="my-2 grid grid-cols-2 text-center gap-2">
            <button class=" py-2 px-1 border-b" :class="[filter.is_sale ? 'border-b' : 'border-b-transparent']"
                @click="filter.is_sale = !filter.is_sale">Sale</button>
            <button class=" py-2 px-1 border-b" :class="[filter.is_sale ? 'border-b-transparent' : ' border-b']"
                @click="filter.is_sale = !filter.is_sale">Purchase</button>
        </div>
        <FwbTable class="rounded-lg">
            <FwbTableHead>
                <FwbTableHeadCell>
                    Name
                </FwbTableHeadCell>
                <FwbTableHeadCell>
                    Quantity
                </FwbTableHeadCell>
                <FwbTableHeadCell>
                    Total
                </FwbTableHeadCell>
            </FwbTableHead>
            <FwbTableBody>
                <template v-for="product in products" :key="product.id">
                    <FwbTableRow class=" border-b border-gray-200 dark:border-gray-700 rounded-lg"
                        v-if="(product.category.transaction_type == 'for_sale' || product.category.transaction_type == 'for_both') && filter.is_sale">
                        <FwbTableCell>
                            {{ product.name }}
                        </FwbTableCell class="text-sm">
                        <template v-for="total in grand_total">
                            <FwbTableCell v-if="total.id == product.id">
                                <p> {{ total.sale_total_quantity }} {{ product.unit }}</p>
                            </FwbTableCell>
                        </template>
                        <template v-for="total in grand_total">
                            <FwbTableCell v-if="total.id == product.id">
                                <p> {{ total.sale_total_price }}</p>
                            </FwbTableCell>
                        </template>
                    </FwbTableRow>
                </template>

                <template v-for="product in products" :key="product.id">
                    <FwbTableRow class=" border-b border-gray-200 dark:border-gray-700 rounded-lg"
                        v-if="(product.category.transaction_type == 'for_purchase' || product.category.transaction_type == 'for_both') && !filter.is_sale">
                        <FwbTableCell>
                            {{ product.name }}
                        </FwbTableCell class="text-sm">
                        <template v-for="total in grand_total">
                            <FwbTableCell v-if="total.id == product.id">
                                <p>{{ total.purchase_total_quantity }} {{ product.unit }}</p>
                            </FwbTableCell>
                        </template>
                        <template v-for="total in grand_total">
                            <FwbTableCell v-if="total.id == product.id">
                                <p>{{ total.purchase_total_price }}</p>
                            </FwbTableCell>
                        </template>
                    </FwbTableRow>
                </template>
                <FwbTableRow>
                    <FwbTableCell colspan="3">
                        <div ref="loader">
                            <div v-if="productPagination.next_page_url" role="status"
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
                                no more products
                            </div>
                        </div>
                    </FwbTableCell>
                </FwbTableRow>
            </FwbTableBody>
        </FwbTable>
    </div>
</template>
<script setup>
import { FwbInput, FwbTable, FwbTableBody, FwbTableCell, FwbTableHead, FwbTableHeadCell, FwbTableRow } from 'flowbite-vue';
import NormalNav from '../Components/NormalNav.vue';
import { onMounted, onUnmounted, reactive, ref, watch } from 'vue';
import { debounce } from 'lodash';
import { router, usePage } from '@inertiajs/vue3';
const loader = ref(null)
const page = usePage();
const queryParams = Object.fromEntries(
    new URLSearchParams(page.url.split("?")[1])
);
const filter = reactive({
    search: queryParams.search || null,
    date: queryParams.date || new Date().toLocaleDateString('sv-SE', { timeZone: 'Asia/Yangon' }),
    is_sale: queryParams.is_sale || true,

})
const prop = defineProps({
    products: Object,
    grand_total: Object,
    productPagination: Object
})
watch(filter, debounce(filter => {
    let date = new Date(filter.date).toLocaleString('sv-SE', { timeZone: 'Asia/Yangon' }).replace(' ', 'T');
    if (filter.date == '') {
        date = null
    }
    router.get('', { search: filter.search, date: date, is_sale: filter.is_sale }, {
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
    if (!prop.productPagination.next_page_url) return
    router.get(prop.productPagination.next_page_url, {}, {
        preserveState: true,
        preserveScroll: true,
        preserveUrl: true,
        only: ['products', 'productPagination', 'grand_total']
    });
};

onMounted(() => {
    window.addEventListener('scroll', checkVisibility);
    checkVisibility(); // Trigger immediately
});

onUnmounted(() => {
    window.removeEventListener('scroll', checkVisibility);
});
</script>

<style scoped>
table th td {
    border: 1px;
}
</style>
