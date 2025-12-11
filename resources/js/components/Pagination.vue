<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface Link {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginationData {
    current_page: number;
    last_page: number;
    links: Link[];
}

interface Props {
    pagination: PaginationData;
}

defineProps<Props>();
</script>

<template>
    <div class="flex items-center justify-between border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 sm:px-6 rounded-b-lg">
        <div class="flex flex-1 justify-between sm:hidden">
            <Link
                v-if="pagination.links[0].url"
                :href="pagination.links[0].url"
                class="relative inline-flex items-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600"
            >
                Anterior
            </Link>
            <Link
                v-if="pagination.links[pagination.links.length - 1].url"
                :href="pagination.links[pagination.links.length - 1].url"
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600"
            >
                Siguiente
            </Link>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Página
                    <span class="font-medium">{{ pagination.current_page }}</span>
                    de
                    <span class="font-medium">{{ pagination.last_page }}</span>
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <template v-for="(link, index) in pagination.links" :key="index">
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            :class="[
                                'relative inline-flex items-center px-4 py-2 text-sm font-medium',
                                link.active
                                    ? 'z-10 bg-blue-600 text-white focus:z-20'
                                    : 'text-gray-900 dark:text-gray-300 ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 focus:z-20',
                                index === 0 ? 'rounded-l-md' : '',
                                index === pagination.links.length - 1 ? 'rounded-r-md' : '',
                            ]"
                            v-html="link.label"
                        />
                        <span
                            v-else
                            :class="[
                                'relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-500',
                                index === 0 ? 'rounded-l-md' : '',
                                index === pagination.links.length - 1 ? 'rounded-r-md' : '',
                            ]"
                            v-html="link.label"
                        />
                    </template>
                </nav>
            </div>
        </div>
    </div>
</template>
