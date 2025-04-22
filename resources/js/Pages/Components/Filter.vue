<template>
    <div class="grid grid-cols-2 gap-2">
        <Select v-model="filter.category" :data="categories" name="All Category" :getByName="true" />
        <Input :type="'search'" :placeholder="'Search'" v-model="filter.search" />
    </div>
</template>
<script setup>
import { debounce } from 'lodash';
import { reactive, ref, watch } from 'vue';
import Input from './Input.vue';
import { router, usePage } from '@inertiajs/vue3';
import Select from './Select.vue';

const page = usePage()
const props = defineProps({
    categories: Object
})
const queryParams = Object.fromEntries(
    new URLSearchParams(page.url.split("?")[1])
);
const filter = reactive({
    search: queryParams.search || null,
    category: queryParams.category || null
})
const emit = defineEmits(['filter'])
// const search = ref(queryParams.search || null);
// const category = ref(queryParams.category || null);
watch(
    filter,
    debounce((q) => {
        // if (q.search == '' && q.category == '') return
        router.get(
            "",
            { search: q.search, category: q.category },
            {
                preserveState: true,
                preserveUrl: true,

                onSuccess: (e) => {
                    emit('filter', true)
                }
            }
        );
    }, 500)
);
// watch(
//     filter.category,
//     debounce((q) => {
//         router.get(
//             "",
//             { category: q },
//             {
//                 preserveState: true,
//                 preserveUrl: true,
//                 preserveScroll: true,
//                 replace: true,
//             }
//         );
//     }, 500)
// );
</script>
<style scoped></style>
