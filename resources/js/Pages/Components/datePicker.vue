<template>
    <input type="date" v-model="date"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

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
