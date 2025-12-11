<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import Pagination from '@/components/Pagination.vue';
import Alert from '@/components/Alert.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

interface Moto {
    id: number;
    marca: string;
    modelo: string;
    año: number;
    color: string;
    cilindrada: number;
    precio: number;
    stock: number;
    estado: string;
}

interface Props {
    motos: {
        data: Moto[];
        current_page: number;
        last_page: number;
        links: any[];
    };
    filters: {
        search?: string;
    };
}

const props = defineProps<Props>();
const page = usePage();
const search = ref(props.filters.search || '');

const successMessage = computed(() => page.props.flash?.success);

const handleSearch = () => {
    router.get('/motos', { search: search.value }, { preserveState: true });
};

const deleteMoto = (id: number) => {
    if (confirm('¿Estás seguro de eliminar esta moto?')) {
        router.delete(`/motos/${id}`);
    }
};

const formatPrice = (price: number) => {
    return new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'USD',
    }).format(price);
};
</script>

<template>
    <Head title="Motos" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestión de Motos</h1>
                    <Button v-if="$page.props.auth.role === 'admin'" href="/motos/create" variant="primary">
                        + Nueva Moto
                    </Button>
                </div>

                <Alert v-if="successMessage" :message="successMessage" type="success" />

                <Card title="Lista de Motos">
                    <div class="mb-4">
                        <div class="flex gap-2">
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Buscar por marca, modelo o color..."
                                class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                @keyup.enter="handleSearch"
                            >
                            <Button @click="handleSearch" variant="primary">
                                Buscar
                            </Button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Marca
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Modelo
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Año
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Color
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Cilindrada
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Precio
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Stock
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="moto in motos.data" :key="moto.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ moto.marca }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ moto.modelo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ moto.año }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ moto.color }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ moto.cilindrada }} cc
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ formatPrice(moto.precio) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        <span :class="moto.stock > 0 ? 'text-green-600' : 'text-red-600'">
                                            {{ moto.stock }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span
                                            :class="[
                                                'px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                moto.estado === 'nuevo' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
                                            ]"
                                        >
                                            {{ moto.estado }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link
                                            :href="`/motos/${moto.id}`"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-3"
                                        >
                                            Ver
                                        </Link>
                                        <Link
                                            v-if="$page.props.auth.role === 'admin'"
                                            :href="`/motos/${moto.id}/edit`"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 mr-3"
                                        >
                                            Editar
                                        </Link>
                                        <button
                                            v-if="$page.props.auth.role === 'admin'"
                                            @click="deleteMoto(moto.id)"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :pagination="motos" />
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
