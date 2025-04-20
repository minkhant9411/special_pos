<template>
    <form class="mt-20 px-3">
        <div class="my-7 text-center">
            <img src="/public/storage/profiles/default.jpg" alt="" class="h-40 w-40 object-cover mx-auto rounded-xl" />
        </div>
        <div class="my-7">
            <input
                class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                id="default_size" type="file" />
        </div>
        <div class="my-7">
            <DatePicker />
        </div>
        <div class="grid grid-cols-2 gap-2 my-7">
            <Input type="text" placeholder="Product Name" />
            <Input type="text" placeholder="Product Unit" />
        </div>

        <div class="grid grid-cols-2 gap-2 my-7">
            <select
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Product Category</option>
                <option value="US">General</option>
            </select>
            <select
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Product Supplier</option>
                <option value="US">General</option>
            </select>
        </div>

        <div class="my-7">
            <TextAreaTag />
        </div>
        <div class="grid grid-cols-2 gap-2 my-7">
            <Input type="number" placeholder="Product Price" />

            <Input type="number" placeholder="Product Cost Price" />
        </div>
        <div class="my-7">
            <Input type="number" placeholder="Product Stock" />
        </div>
        <div class="my-7">
            <button type="button"
                class="bg-yellow-500 focus:ring-yellow-800 focus:ring-2 dark:bg-blue-700 dark:focus:ring-blue-500 rounded-xl p-3 w-full">
                Submit
            </button>
        </div>
    </form>
</template>
<script setup>
import DatePicker from "./datePicker.vue";
import Input from "./Input.vue";
import TextAreaTag from "./TextAreaTag.vue";
</script>
<style scoped></style>
