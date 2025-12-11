<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface Props {
    message: string;
    type?: 'success' | 'error' | 'warning' | 'info';
}

const props = withDefaults(defineProps<Props>(), {
    type: 'success',
});

const typeClasses = {
    success: 'bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-300 border-green-200 dark:border-green-800',
    error: 'bg-red-50 dark:bg-red-900/20 text-red-800 dark:text-red-300 border-red-200 dark:border-red-800',
    warning: 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800',
    info: 'bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 border-blue-200 dark:border-blue-800',
};
</script>

<template>
    <div
        :class="[
            'mb-4 rounded-lg border p-4',
            typeClasses[type],
        ]"
    >
        <p class="text-sm font-medium">{{ message }}</p>
    </div>
</template>
