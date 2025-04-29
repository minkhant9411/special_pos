<template>
    <NormalNav name="ပစ္စည်း" />

    <div class="m-2 mt-20">
        <div v-if="$page.props.flash.message"
            class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            {{ $page.props.flash.message }}
        </div>
        <Filter :categories="categories" @filter="loadMore()" />
        <div v-for="product in products" :key="product.id">
            <SingleProduct :product="product" />
        </div>
        <div ref="loader">
            <div v-if="productPagination.next_page_url" role="status"
                class="p-4 border border-gray-200  rounded-sm shadow-sm animate-pulse md:p-6 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-between">
                        <div
                            class="flex items-center justify-center h-20 w-20 me-2 bg-gray-300 rounded-sm dark:bg-gray-700">
                            <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                <path
                                    d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM10.5 6a1.5 1.5 0 1 1 0 2.999A1.5 1.5 0 0 1 10.5 6Zm2.221 10.515a1 1 0 0 1-.858.485h-8a1 1 0 0 1-.9-1.43L5.6 10.039a.978.978 0 0 1 .936-.57 1 1 0 0 1 .9.632l1.181 2.981.541-1a.945.945 0 0 1 .883-.522 1 1 0 0 1 .879.529l1.832 3.438a1 1 0 0 1-.031.988Z" />
                                <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z" />
                            </svg>
                        </div>
                        <div>
                            <div class="h-2.5 bg-gray-300 rounded-full dark:bg-gray-600 w-24 mb-2.5"></div>
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
        <AddButton href="product.create" />
    </div>
</template>
<script setup>
import { onMounted, onUnmounted, ref } from "vue";
import AddButton from "../Components/AddButton.vue";
import Filter from "../Components/Filter.vue";
import NormalNav from "../Components/NormalNav.vue";
import SingleProduct from "../Components/SingleProduct.vue";
import { router, WhenVisible } from "@inertiajs/vue3";
const loader = ref(null)
const prop = defineProps({
    products: {
        type: Object,
        required: true,
    },
    productPagination: {
        type: Object
    },
    categories: {
        type: Object,
        required: true,
    },
    filters: Object

});

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
        only: ['products', 'productPagination']
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
<style scoped></style>
