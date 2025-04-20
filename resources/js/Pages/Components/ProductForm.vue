<template>
    <form class="mt-20 px-3" @submit.prevent="submit">
        <div class="my-7 text-center">
            <img v-if="!temp_image" src="/storage/app/public/profiles/default.jpg" alt=""
                class="h-40 w-40 object-cover mx-auto rounded-xl" />
            <img v-else :src="temp_image" alt="" class="h-40 w-40 object-cover mx-auto rounded-xl" />
        </div>
        <div class="my-7">
            <input @change="changeInput" accept="image/*"
                class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                type="file" />
            <small class="text-red-500" v-if="$page.props.errors.image">{{
                $page.props.errors.image
                }}</small>
        </div>

        <div class="grid grid-cols-2 gap-2 my-7">
            <Input v-model="form.name" type="text" placeholder="Product Name" />
            <Input v-model="form.unit" type="text" placeholder="Product Unit" />
            <small class="text-red-500" v-if="$page.props.errors.name">{{
                $page.props.errors.name
                }}</small>
            <small class="text-red-500" v-if="$page.props.errors.unit">{{
                $page.props.errors.unit
                }}</small>
        </div>

        <div class="my-7">
            <select v-model="form.category_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected :value="null">Product Category</option>

                <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                </option>
            </select>
            <small class="text-red-500" v-if="$page.props.errors.category_id">{{
                $page.props.errors.category_id
                }}</small>
        </div>

        <div class="grid grid-cols-2 gap-2 my-7">
            <Input v-model="form.price" type="number" placeholder="Product Price" />
            <Input v-model="form.cost_price" type="number" placeholder="Product Cost Price" />
            <small class="text-red-500" v-if="$page.props.errors.price">{{
                $page.props.errors.price
                }}</small>
            <small class="text-red-500" v-if="$page.props.errors.cost_price">{{
                $page.props.errors.cost_price
                }}</small>
        </div>
        <div class="my-7">
            <TextAreaTag v-model="form.description" />
            <small class="text-red-500" v-if="$page.props.errors.description">{{
                $page.props.errors.description
                }}</small>
        </div>
        <div class="my-7">
            <button type="submit"
                class="bg-yellow-500 focus:ring-yellow-800 focus:ring-2 dark:bg-blue-700 dark:focus:ring-blue-500 rounded-xl p-3 w-full">
                Submit
            </button>
        </div>
    </form>
</template>
<script setup>
import { useForm } from "@inertiajs/vue3";
import Input from "./Input.vue";
import TextAreaTag from "./TextAreaTag.vue";
import { ref } from "vue";
const temp_image = ref(null);
const prop = defineProps({
    categories: {
        type: Object,
        required: true,
    },
    product: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["submit"]);
const form = useForm({
    image: null,
    name: null,
    unit: null,
    category_id: null,
    price: null,
    cost_price: null,
    description: null,
});

if (prop.product) {
    if (prop.product.image_path) {
        temp_image.value = "/storage/" + prop.product.image_path;
    } else temp_image.value = null;
    form.name = prop.product.name;
    form.unit = prop.product.unit;
    form.category_id = prop.product.category_id;
    form.price = prop.product.price;
    form.cost_price = prop.product.cost_price;
    form.description = prop.product.description;
}
const submit = () => {
    emit("submit", form);
};
const changeInput = (e) => {
    form.image = e.target.files[0];
    temp_image.value = URL.createObjectURL(e.target.files[0]);
};
</script>
<style scoped></style>
