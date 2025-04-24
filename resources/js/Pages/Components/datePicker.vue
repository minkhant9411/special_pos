<template>
    <div class="relative">
        <label for="Date" class="absolute inset-y-0 start-0 flex items-center ps-3.5">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
            </svg>
        </label>
        <input type="date" v-model="date"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ps-10  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    </div>
</template>
<script setup>
import { onMounted, ref, watch } from 'vue';
const date = ref(null);

const emit = defineEmits(['date'])
onMounted(() => {
    date.value = new Date().toISOString().split('T')[0]
})
watch(date, (n) => {
    emit('date', new Date(n).toLocaleString('sv-SE', { timeZone: 'Asia/Yangon' }).replace(' ', 'T'))
})
</script>
