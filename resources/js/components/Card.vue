<script setup lang="ts">
interface Props {
    title: string;
}

defineProps<Props>();
</script>

<template>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            {{ title }}
        </h2>
        <slot />
    </div>
</template>
