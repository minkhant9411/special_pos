<template>
    <div class="h-[100vh] flex justify-center items-center">
        <form class="mt-20 px-3 w-full" @submit.prevent="submit">
            <div class="grid grid-cols-2 gap-2 my-7">
                <Select v-model="form.stuff_id" :data="stuff" name="Select Name" />
                <Select v-model="form.type" :data="[
                    { name: 'အဝင်', id: 'I' },
                    { name: 'အထွက်', id: 'E' }]" name="Select type" />
                <small class="text-red-500" v-if="$page.props.errors.stuff_id">{{
                    $page.props.errors.stuff_id
                }}</small>
                <small class="text-red-500" v-if="$page.props.errors.type">{{
                    $page.props.errors.type
                }}</small>
            </div>
            <div class="my-7">
                <Input placeholder="Amount" type="number" v-model="form.amount" />
                <small class="text-red-500" v-if="$page.props.errors.amount">{{
                    $page.props.errors.amount
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
    </div>
</template>
<script setup>
import { useForm } from "@inertiajs/vue3";
import Input from "./Input.vue";
import TextAreaTag from "./TextAreaTag.vue";
import { ref } from "vue";
import Select from "./Select.vue";
const temp_image = ref(null);
const prop = defineProps({
    stuff: {
        type: Object,
        required: true,
    },
    account: Object
});

const emit = defineEmits(["submit"]);
const form = useForm({
    type: null,
    amount: null,
    stuff_id: null,
    description: null,
});

if (prop.account) {
    if (prop.account.image_path) {
        temp_image.value = "/storage/" + prop.account.image_path;
    } else temp_image.value = null;
    form.type = prop.account.type;
    form.amount = prop.account.amount;
    form.stuff_id = prop.account.stuff_id;
    form.description = prop.account.description;
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
