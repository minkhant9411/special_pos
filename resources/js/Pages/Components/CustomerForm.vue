<template>
    <div class="mt-20 m-2 h-[90vh] flex justify-center items-center">
        <div class="w-full">
            <form @submit.prevent="submit">
                <div class="my-7">
                    <Input type="text" placeholder="Customer Name" v-model="form.name" />
                </div>
                <div class="my-7">
                    <TextAreaTag v-model="form.description" />
                </div>
                <div class="my-7">
                    <button type="submit" :disabled="form.processing"
                        class="bg-yellow-500 focus:ring-yellow-800 focus:ring-2 dark:bg-blue-700 dark:focus:ring-blue-500 rounded-xl p-3 w-full">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup>
import { useForm } from "@inertiajs/vue3";
import Input from "./Input.vue";
import TextAreaTag from "./TextAreaTag.vue";

const prop = defineProps({
    customer: {
        type: Object,
    },
});
const emit = defineEmits(["submit"]);
const form = useForm({
    name: null,
    description: null,
});

if (prop.customer) {
    form.name = prop.customer.name;
    form.description = prop.customer.description;
}

const submit = () => {
    emit("submit", form);
};
</script>
<style scoped></style>
