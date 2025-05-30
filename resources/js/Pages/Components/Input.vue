<template>
    <template v-if="!vinyl">
        <label v-if="label">{{ label }}</label>
        <input :type="type" :placeholder="placeholder" v-model="model"
            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
    </template>
    <div class="my-4 grid grid-cols-4 place-items-center self-center" v-else>
        <label v-if="label" class=" font-bold col-span-1">{{ label }} :</label>
        <input :type="type" :placeholder="placeholder" v-model="model" @input="emit('input')"
            class="mt-3 col-span-3 w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
    </div>
</template>
<script setup>
const model = defineModel({
    type: null,
    // required: true,
    default: null
});
const emit = defineEmits(['input']);
const props = defineProps({
    type: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
    },
    label: String,
    vinyl: {
        default: false,
        type: Boolean
    }
});
</script>
<style scoped></style>
