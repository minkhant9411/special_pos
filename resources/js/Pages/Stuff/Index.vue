<template>

    <Head>
        <title>| Stuff</title>
    </Head>
    <NormalNav name="အကောင့်" url="home" />
    <div class="mt-20 m-2">
        <div v-if="page.props.flash.message"
            class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            {{ page.props.flash.message }}
        </div>
        <div>
            <Input :type="'search'" :placeholder="'Search'" v-model="search" />
        </div>
        <div v-for="stuff in all_stuff" :key="stuff.id">
            <SingleStuff :stuff="stuff" />
        </div>
    </div>
    <AddButton href="stuff.create" />
</template>
<script setup>
import { router, usePage } from "@inertiajs/vue3";
import AddButton from "../Components/AddButton.vue";
import Input from "../Components/Input.vue";
import NormalNav from "../Components/NormalNav.vue";
import SingleStuff from "../Components/SingleStuff.vue";
import { ref, watch } from "vue";
import { debounce } from "lodash";

const page = usePage();
const prop = defineProps({
    all_stuff: {
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
