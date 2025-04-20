<template>
    <div v-if="$page.props.flash.message"
        class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
        role="alert">
        {{ $page.props.flash.message }}
    </div>
</template>
<script setup>


</script>
<style scoped></style>
