<template>
    <div class="grid grid-cols-2 gap-2 my-3">
        <div v-for="data in datas" :key="data.id"
            class="w-full relative border rounded-lg dark:border-gray-800 border-gray-300 shadow-sm dark:shadow-gray-900 shadow-gray-100">
            <a href="#">
                <img class="rounded-lg mx-auto w-[100%] object-cover h-40"
                    :src="[data.image_path != null ? '/storage/' + data.image_path : '/storage/profiles/default.jpg']"
                    alt="data image" />
            </a>
            <button @click="() => { emit('add-cart', [data, 1]) }"
                class="absolute top-30 right-2 cursor-pointe rounded-full">
                <svg class="w-10 h-10 text-gray-300 active:text-gray-400 rounded-full hover:text-gray-300"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div class="p-2">
                <p class=" font-bold">{{ data.name }}</p>
                <p class="text-sm" v-if="page.url == url">MMK {{
                    data.cost_price
                    }}
                </p>
                <p class="text-sm" v-else>MMK {{ data.price }}</p>
                <p class="text-gray-500 text-sm">
                    {{ data?.category?.name ?? "No Category" }}
                </p>
            </div>
        </div>
    </div>
</template>
<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';


const props = defineProps({
    datas: { type: Object, default: [] }
})
const page = usePage();
const emit = defineEmits(['add-cart'])
// console.log()
const url = ref(new URL(route('purchase.index')).pathname)
</script>
<style scoped></style>
