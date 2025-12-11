<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import Pagination from '@/components/Pagination.vue';
import Alert from '@/components/Alert.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

interface Venta {
    id: number;
    cliente: {
        nombre: string;
        apellido: string;
    };
    moto: {
        marca: string;
        modelo: string;
    };
    user: {
        name: string;
    };
    precio_venta: number;
    metodo_pago: string;
    fecha_venta: string;
}

interface Props {
    ventas: {
        data: Venta[];
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
    router.get('/ventas', { search: search.value }, { preserveState: true });
};

const deleteVenta = (id: number) => {
    if (confirm('¿Estás seguro de eliminar esta venta? Se restaurará el stock.')) {
        router.delete(`/ventas/${id}`);
    }
};

const formatPrice = (price: number) => {
    return new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'USD',
    }).format(price);
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const metodoPagoLabel = (metodo: string) => {
    const labels: Record<string, string> = {
        efectivo: 'Efectivo',
        tarjeta: 'Tarjeta',
        transferencia: 'Transferencia',
        financiamiento: 'Financiamiento',
    };
    return labels[metodo] || metodo;
};
</script>

<template>
    <Head title="Ventas" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gestión de Ventas</h1>
                    <Button href="/ventas/create" variant="success">
                        + Nueva Venta
                    </Button>
                </div>

                <Alert v-if="successMessage" :message="successMessage" type="success" />

                <Card title="Registro de Ventas">
                    <div class="mb-4">
                        <div class="flex gap-2">
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Buscar por cliente o moto..."
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
                                        Fecha
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Cliente
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Moto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Precio
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Método Pago
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Vendedor
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="venta in ventas.data" :key="venta.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ formatDate(venta.fecha_venta) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ venta.cliente.nombre }} {{ venta.cliente.apellido }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ venta.moto.marca }} {{ venta.moto.modelo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                        {{ formatPrice(venta.precio_venta) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                            {{ metodoPagoLabel(venta.metodo_pago) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ venta.user.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link
                                            :href="`/ventas/${venta.id}`"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 mr-3"
                                        >
                                            Ver
                                        </Link>
                                        <button
                                            v-if="$page.props.auth.role === 'admin'"
                                            @click="deleteVenta(venta.id)"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :pagination="ventas" />
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
