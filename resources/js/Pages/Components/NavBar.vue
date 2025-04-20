<template>
    <nav class="p-5 bg-gray-100 flex justify-between items-center dark:bg-gray-800">
        <div class="flex items-center gap-4">
            <img class="w-10 h-10 rounded-full" src="/public/storage/profiles/default.jpg" alt="" />
            <div class="font-medium dark:text-white text-gray-700">
                <div>{{ $page.props.auth.user.name }}</div>
                <!-- <div class="text-sm text-gray-700 dark:text-gray-400">
                    Joined in August 2014
                </div> -->
            </div>
        </div>
        <div class="flex justify-end items-center gap-1">
            <Link :href="route('logout')" method="post"
                class="border-1 px-4 py-2 font-medium rounded-xl hover:bg-gray-600 hover:text-white cursor-pointer">
            logout
            </Link>
            <!-- <Cart /> -->
            <ThemeSwitch />
        </div>
    </nav>
</template>
<script setup>
import ThemeSwitch from "@/Pages/Components/ThemeSwitch.vue";
// import Cart from "./Cart.vue";
</script>
<style scoped></style>
