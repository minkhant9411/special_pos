<template>

    <Head>
        <title>| Customers</title>
    </Head>
    <NormalNav name="ဝယ်ယူသူ" url="home" />
    <div class="mt-20 m-2">
        <div v-if="page.props.flash.message"
            class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            {{ page.props.flash.message }}
        </div>
        <div>
            <Input :type="'search'" :placeholder="'Search'" v-model="search" />
        </div>
        <div v-for="customer in customers" :key="customer.id">
            <SingleCustomer :customer="customer" />
        </div>
    </div>
    <AddButton href="customer.create" />
</template>
<script setup>
import { router, usePage } from "@inertiajs/vue3";
import AddButton from "../Components/AddButton.vue";
import Input from "../Components/Input.vue";
import NormalNav from "../Components/NormalNav.vue";
import SingleCustomer from "../Components/SingleCustomer.vue";
import { ref, watch } from "vue";
import { debounce } from "lodash";

const page = usePage();
const prop = defineProps({
    customers: {
        type: Array,
        required: true,
    },
});
const search = ref("");
watch(
    search,
    debounce((q) => {
        router.get(
            "",
            { search: q },
            {
                preserveState: true,
            }
        );
    }, 500)
);
</script>
<style scoped></style>
