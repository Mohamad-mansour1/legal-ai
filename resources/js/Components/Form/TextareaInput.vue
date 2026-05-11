<script setup>
defineProps({
    modelValue: String,
    rows: {
        type: Number,
        default: 4,
    },
    error: String,
})

defineEmits(['update:modelValue'])
</script>

<template>

    <textarea
        :rows="rows"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="w-full rounded-xl p-3 mt-2 border transition"
        :class="error
            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
            : 'border-gray-300 focus:border-[#D4AF37] focus:ring-[#D4AF37]'
        "
    />

</template>