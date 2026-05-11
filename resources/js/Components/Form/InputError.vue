<script setup>
defineProps({
    message: String,
})
</script>

<template>

    <p
        v-if="message"
        class="text-red-600 text-sm mt-2 font-medium"
    >
        {{ message }}
    </p>

</template>