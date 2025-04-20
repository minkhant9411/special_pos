<template>
    <div class="mt-20 m-2 h-[90vh] flex justify-center items-center">
        <div class="w-full">
            <form @submit.prevent="submit">
                <div class="my-7">
                    <Input type="text" placeholder="Category Name" v-model="form.name" />
                    <small class="text-red-500" v-if="$page.props.errors.name">{{ $page.props.errors.name }}</small>
                </div>
                <div class="my-7">
                    <Select name="Transaction type" v-model="form.transaction_type" :data="[
                        { id: 'for_both', name: 'For Both' },
                        { id: 'for_sale', name: 'For Sale' },
                        { id: 'for_purchase', name: 'For Purchase' },
                    ]" />

                    <small class="text-red-500" v-if="$page.props.errors.transaction_type">{{
                        $page.props.errors.transaction_type }}</small>
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
import Select from "./Select.vue";
const prop = defineProps({
    category: {
        type: Object,
    },
});
const emit = defineEmits(["submit"]);
const form = useForm({
    name: null,
    description: null,
    transaction_type: null
});

if (prop.category) {
    form.name = prop.category.name;
    form.description = prop.category.description;
    form.transaction_type = prop.category.transaction_type;
}

const submit = () => {
    emit("submit", form);
};
</script>
<style scoped></style>
