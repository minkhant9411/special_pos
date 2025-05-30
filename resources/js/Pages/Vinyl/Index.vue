<template>

    <Head>
        <title>| Sale Vinyl</title>
    </Head>
    <NormalNav name="vinyl" url="home" />
    <div class="mt-20 m-2">
        <div v-if="$page.props.flash.message"
            class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            {{ $page.props.flash.message }}
        </div>
        <template v-if="$page.props.errors">
            <div v-for="error in $page.props.errors"
                class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                {{ error }}
            </div>
        </template>



    </div>
</template>
<script setup>
import NormalNav from '../Components/NormalNav.vue';



</script>
<style scoped></style>
