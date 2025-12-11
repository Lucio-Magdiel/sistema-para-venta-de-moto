<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    modelValue?: string | number;
    label?: string;
    type?: string;
    placeholder?: string;
    error?: string;
    required?: boolean;
    disabled?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    type: 'text',
    required: false,
    disabled: false,
});

const emit = defineEmits<{
    'update:modelValue': [value: string | number];
}>();

const inputId = computed(() => `input-${Math.random().toString(36).substr(2, 9)}`);

const handleInput = (event: Event) => {
    const target = event.target as HTMLInputElement;
    emit('update:modelValue', target.value);
};
</script>

<template>
    <div class="mb-4">
        <label
            v-if="label"
            :for="inputId"
            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
        >
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        <input
            :id="inputId"
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            :required="required"
            :disabled="disabled"
            @input="handleInput"
            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100 dark:bg-gray-800 dark:text-white"
            :class="{ 'border-red-500': error }"
        >
        <p v-if="error" class="mt-1 text-sm text-red-600">
            {{ error }}
        </p>
    </div>
</template>
