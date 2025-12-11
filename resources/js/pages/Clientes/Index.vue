<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import Pagination from '@/components/Pagination.vue';
import Alert from '@/components/Alert.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

interface Cliente {
    id: number;
    nombre: string;
    apellido: string;
    documento: string;
    email: string;
    telefono: string;
    direccion: string;
}

interface Props {
    clientes: {
        data: Cliente[];
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
    router.get('/clientes', { search: search.value }, { preserveState: true });
};

const deleteCliente = (id: number) => {
    if (confirm('¿Estás seguro de eliminar este cliente?')) {
        router.delete(`/clientes/${id}`);
    }
};
</script>

<template>
    <Head title="Clientes" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestión de Clientes</h1>
                    <Button v-if="$page.props.auth.role === 'admin'" href="/clientes/create" variant="primary">
                        + Nuevo Cliente
                    </Button>
                </div>

                <Alert v-if="successMessage" :message="successMessage" type="success" />

                <Card title="Lista de Clientes">
                    <div class="mb-4">
                        <div class="flex gap-2">
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Buscar por nombre, documento o email..."
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
                                        Nombre Completo
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Documento
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Teléfono
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="cliente in clientes.data" :key="cliente.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ cliente.nombre }} {{ cliente.apellido }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ cliente.documento }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ cliente.email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ cliente.telefono }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link
                                            :href="`/clientes/${cliente.id}`"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-3"
                                        >
                                            Ver
                                        </Link>
                                        <Link
                                            v-if="$page.props.auth.role === 'admin'"
                                            :href="`/clientes/${cliente.id}/edit`"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 mr-3"
                                        >
                                            Editar
                                        </Link>
                                        <button
                                            v-if="$page.props.auth.role === 'admin'"
                                            @click="deleteCliente(cliente.id)"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :pagination="clientes" />
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
