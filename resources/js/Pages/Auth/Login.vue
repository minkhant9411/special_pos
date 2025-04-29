<template>

    <Head>
        <title>Login</title>
    </Head>
    <div class="bg-gray-100 dark:bg-gray-800 h-[100vh] w-[100vw] flex justify-center items-center">
        <form @submit.prevent="submit"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 w-[100vw]">
            <h1 class="text-5xl text-center pb-10">Login</h1>
            <div class="mb-6">
                <input v-model="form.email" type="email" id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="john.doe@company.com" />
                <small class="text-red-500" v-if="errors.email">{{
                    errors.email
                    }}</small>
            </div>

            <div class="mb-6 relative">
                <input v-model="form.password" :type="type" id="password"
                    class="bg-gray-50 border pe-10 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="•••••••••" />
                <span class="absolute inset-y-0 end-2 flex items-center ps-3.5 cursor-pointer"><svg
                        v-if="type === 'password'" @click="type = 'text'" class="w-6 h-6 text-gray-800 dark:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2"
                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg v-else @click="type = 'password'" class="w-6 h-6 text-gray-800 dark:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </span>
                <small class="text-red-500" v-if="errors.password">{{
                    errors.password
                    }}</small>
            </div>
            <div class="mb-6 text-center">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
                </button>
            </div>
        </form>
    </div>
</template>
<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
defineProps({ errors: Object });
const type = ref("password");
const form = useForm({
    email: null,
    password: null,
});
const submit = () => {
    form.post("/login", {
        onError: () => form.reset("password", "remember"),
    });
};
</script>
<style scoped></style>
