<template>

    <Head>
        <title>| Home</title>
    </Head>
    <NavBar />

    <div v-if="$page.props.auth.user.role == 'admin'"
        class="m-4 p-2 relative bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 text-center">
        <p class="text-center">Today Reports</p>
        <Link :href="route('history.index')"
            class="absolute underline text-blue-500 right-0 top-0 p-3 hover:text-blue-600 text-sm">See Reports
        </Link>
        <div class="grid grid-cols-2 gap-4">
            <Link :href="route('sale.history')"
                class="my-3 py-3 bg-green-400 text-white border border-green-200 rounded-lg shadow-sm hover:bg-green-100 dark:bg-green-800 dark:border-green-700 dark:hover:bg-green-700">
            <div class="flex justify-center m-2">
                <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z" />
                </svg>
            </div>
            <span class="block">အရောင်း</span>
            <span>{{ totalSaleAmount }} MMK</span>
            </Link>
            <Link :href="route('purchase.history')"
                class="my-3 py-3 bg-red-300 border text-white border-red-200 rounded-lg shadow-sm hover:bg-red-100 dark:bg-red-800 dark:border-red-700 dark:hover:bg-red-700">
            <div class="flex justify-center m-2">
                <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                </svg>
            </div>
            <span class="block">အဝယ်</span>
            <span>{{ totalPurchaseAmount }} MMK</span>
            </Link>
            <!-- <div
                class="my-3 py-3 bg-yellow-300 border text-white border-yellow-200 rounded-lg shadow-sm hover:bg-yellow-100 dark:bg-yellow-800 dark:border-yellow-700 dark:hover:bg-yellow-700">
                <div class="flex justify-center m-2">
                    <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                </div>
                <span class="block">Expense</span>
                <span>100000ks</span>
            </div> -->
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4 m-4 p-2">
        <template v-for="card in cardsData">
            <Card :name="card.name" :href="card.href"
                v-if="$page.props.auth.user.role == card.role || $page.props.auth.user.role == 'admin'" />
        </template>
    </div>

</template>
<script setup>
import NavBar from "@/Pages/Components/NavBar.vue";
import Card from "./Components/Card.vue";
defineProps({
    totalSaleAmount: Number,
    totalPurchaseAmount: Number
})
// const cardsData = [
//     { href: "category.index", name: "Categories" },
//     { href: "supplier.index", name: "Suppliers" },
//     { href: "customer.index", name: "Customers" },
//     { href: "stuff.index", name: "Stuff" },
//     { href: "product.index", name: "Products" },
//     { href: "purchase.index", name: "Purchase" },
//     { href: "sale.index", name: "Sale" },
//     { href: "history.index", name: "History" },
// { href: "account.index", name: "Account", role: 'admin' },
// { href: "account.index", name: "Account", role: 'admin' },
// ];
const cardsData = [
    { href: "category.index", name: "အမျိုးအစား", role: 'admin' },
    { href: "supplier.index", name: "ရောင်းချသူ", role: 'admin' },
    { href: "customer.index", name: "ဝယ်ယူသူ", role: 'admin' },
    { href: "product.index", name: "ပစ္စည်း", role: 'admin' },
    { href: "sale.index", name: "အရောင်း", role: 'casher' },
    { href: "purchase.index", name: "အဝယ်", role: 'admin' },
    { href: "history.index", name: "စာရင်း", role: 'admin' },
    { href: "stuff.index", name: "အကောင့်အမည်", role: 'admin' },
    { href: "account.index", name: "အကောင့်", role: 'admin' },
];
</script>
<style scoped></style>
