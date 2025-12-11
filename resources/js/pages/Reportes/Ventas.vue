<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import { Head } from '@inertiajs/vue3';

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

interface VentaPorMetodo {
    metodo: string;
    cantidad: number;
    total: number;
}

interface VentaPorVendedor {
    vendedor: string;
    cantidad: number;
    total: number;
}

interface Props {
    ventas: Venta[];
    resumen: {
        totalIngresos: number;
        totalVentas: number;
        promedioVenta: number;
    };
    ventasPorMetodo: VentaPorMetodo[];
    ventasPorVendedor: VentaPorVendedor[];
    filtros: {
        fecha_inicio: string;
        fecha_fin: string;
    };
}

defineProps<Props>();

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

const printReport = () => {
    window.print();
};
</script>

<template>
    <Head title="Reporte de Ventas" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between items-center print:hidden">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Reporte de Ventas</h1>
                    <div class="flex gap-3">
                        <Button @click="printReport" variant="primary">
                            🖨️ Imprimir
                        </Button>
                        <Button href="/reportes" variant="secondary">
                            Volver
                        </Button>
                    </div>
                </div>

                <!-- Header para impresión -->
                <div class="hidden print:block mb-6">
                    <h1 class="text-2xl font-bold text-center mb-2">Sistema de Venta de Motos</h1>
                    <h2 class="text-xl text-center mb-4">Reporte de Ventas</h2>
                    <p class="text-center text-gray-600">
                        Período: {{ formatDate(filtros.fecha_inicio) }} - {{ formatDate(filtros.fecha_fin) }}
                    </p>
                </div>

                <!-- Resumen -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <Card title="Total Ventas">
                        <div class="text-center">
                            <p class="text-4xl font-bold text-blue-600">{{ resumen.totalVentas }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Ventas realizadas</p>
                        </div>
                    </Card>

                    <Card title="Total Ingresos">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-green-600">{{ formatPrice(resumen.totalIngresos) }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Ingresos generados</p>
                        </div>
                    </Card>

                    <Card title="Promedio por Venta">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-purple-600">{{ formatPrice(resumen.promedioVenta) }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Ticket promedio</p>
                        </div>
                    </Card>
                </div>

                <!-- Análisis -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <Card title="Ventas por Método de Pago">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Método
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Cantidad
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Total
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="item in ventasPorMetodo" :key="item.metodo">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ metodoPagoLabel(item.metodo) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500 dark:text-gray-300">
                                            {{ item.cantidad }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-green-600">
                                            {{ formatPrice(item.total) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </Card>

                    <Card title="Ventas por Vendedor">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Vendedor
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Cantidad
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                            Total
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="item in ventasPorVendedor" :key="item.vendedor">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ item.vendedor }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500 dark:text-gray-300">
                                            {{ item.cantidad }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-green-600">
                                            {{ formatPrice(item.total) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </Card>
                </div>

                <!-- Detalle de Ventas -->
                <Card title="Detalle de Ventas">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                        Fecha
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                        Cliente
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                        Moto
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                        Método
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                        Vendedor
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                        Precio
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="venta in ventas" :key="venta.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ formatDate(venta.fecha_venta) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ venta.cliente.nombre }} {{ venta.cliente.apellido }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ venta.moto.marca }} {{ venta.moto.modelo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ metodoPagoLabel(venta.metodo_pago) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ venta.user.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-green-600">
                                        {{ formatPrice(venta.precio_venta) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>

<style>
@media print {
    .print\:hidden {
        display: none !important;
    }
    
    .print\:block {
        display: block !important;
    }
}
</style>
