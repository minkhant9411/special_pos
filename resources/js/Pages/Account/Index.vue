<template>

    <NormalNav name="အကောင့်" url="home" />
    <div class="m-2 my-20">
        <div class="grid grid-cols-2 gap-2">
            <Select v-model="filter.search" :data="Stuff" name="All Stuff" />
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
        <div class="my-2 grid grid-cols-2 text-center gap-2">
            <button class=" py-2 px-1 border-b" :class="[filter.is_income ? 'border-b' : 'border-b-transparent']"
                @click="filter.is_income = !filter.is_income">အဝင်</button>
            <button class=" py-2 px-1 border-b" :class="[filter.is_income ? 'border-b-transparent' : ' border-b']"
                @click="filter.is_income = !filter.is_income">အထွက်
            </button>
        </div>
        <FwbTable hoverable class="rounded-lg cursor-pointer">
            <FwbTableHead>
                <FwbTableHeadCell>
                    Name
                </FwbTableHeadCell>
                <FwbTableHeadCell>
                    Desc
                </FwbTableHeadCell>
                <FwbTableHeadCell>
                    Amount
                </FwbTableHeadCell>
                <FwbTableHeadCell>
                    Date
                </FwbTableHeadCell>
            </FwbTableHead>
            <FwbTableBody>
                <template v-for="account in accounts" :key="account.id">
                    <FwbTableRow @click="() => { !showActionId ? showActionId = account.id : showActionId = null }"
                        class=" border-b border-gray-200 dark:border-gray-700 rounded-lg dark:hover:bg-gray-600">
                        <FwbTableCell>
                            {{ account.stuff.name }}
                        </FwbTableCell>
                        <FwbTableCell>
                            {{ account.description }}
                        </FwbTableCell>
                        <FwbTableCell>
                            {{ account.amount }}
                        </FwbTableCell>
                        <FwbTableCell class=" relative">
                            {{ new Date(account?.created_at).toLocaleDateString() || 'no date!' }}
                            <Link :href="route('account.destroy', account.id)" method="post"
                                v-if="account.id == showActionId"
                                class="top-0 right-0 h-full w-14 flex justify-center items-center bg-red-500 absolute rounded-md">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                            </svg>
                            </Link>
                            <Link :href="route('account.edit', account.id)" v-if="account.id == showActionId"
                                class="top-0 right-14  h-full w-14 flex justify-center items-center rounded-md bg-green-500 absolute">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                            </svg>
                            </Link>
                        </FwbTableCell>
                    </FwbTableRow>
                </template>

                <FwbTableRow class="border-b border-gray-200 dark:border-gray-700 rounded-lg dark:hover:bg-gray-600">
                    <FwbTableCell colspan="4">
                        <div ref="loader">
                            <div v-if="accountPagination.next_page_url" role="status"
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
                                no more accounts
                            </div>
                        </div>
                    </FwbTableCell>
                </FwbTableRow>
            </FwbTableBody>
        </FwbTable>
    </div>
    <div
        class=" dark:bg-gray-800 bg-white border border-t dark:border-gray-700 border-gray-200  p-6 rounded-t-lg flex justify-between fixed bottom-0 left-0 right-0 items-center">
        <Link :href="route('account.create')">
        <fwb-button color="default">အကောင့်ထည့်ရန်</fwb-button>
        </Link>
        <span> Total : {{ totalAmount }} </span>
    </div>
</template>
<script setup>
import { FwbButton, FwbTable, FwbTableBody, FwbTableCell, FwbTableHead, FwbTableHeadCell, FwbTableRow } from 'flowbite-vue';
import NormalNav from '../Components/NormalNav.vue';
import { onMounted, onUnmounted, reactive, ref, watch } from 'vue';
import { debounce } from 'lodash';
import { router, usePage } from '@inertiajs/vue3';
import Select from '../Components/Select.vue';
const loader = ref(null)
const page = usePage();
const queryParams = Object.fromEntries(
    new URLSearchParams(page.url.split("?")[1])
);
const showActionId = ref(null);
const filter = reactive({
    search: queryParams.search || null,
    date: queryParams.date || new Date().toISOString().slice(0, 7),
    is_income: queryParams.is_income || true,

})
const prop = defineProps({
    Stuff: Object,
    accounts: Object,
    accountPagination: Object,
    totalAmount: Number
})
watch(filter, debounce(filter => {
    // console.log(filter.date);
    // return
    // let date = new Date(filter.date).toLocaleString('sv-SE', { timeZone: 'Asia/Yangon' }).replace(' ', 'T');
    // if (filter.date == '') {
    //     date = null
    // }
    router.get('', { search: filter.search, date: filter.date, is_income: filter.is_income }, {
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
    if (!prop.accountPagination.next_page_url) return
    router.get(prop.accountPagination.next_page_url, {}, {
        preserveState: true,
        preserveScroll: true,
        preserveUrl: true,
        only: ['accounts', 'accountPagination', 'grand_total']
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
