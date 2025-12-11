<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

interface VentaPorMes {
    mes: string;
    total: number;
    ingresos: number;
}

interface MotaMasVendida {
    marca: string;
    modelo: string;
    ventas: number;
}

interface MetodoPago {
    metodo_pago: string;
    total: number;
}

interface VentaReciente {
    id: number;
    cliente: {
        nombre: string;
        apellido: string;
    };
    moto: {
        marca: string;
        modelo: string;
    };
    precio_venta: number;
    fecha_venta: string;
}

interface Props {
    stats: {
        totalVentas: number;
        totalIngresos: number;
        totalClientes: number;
        totalMotos: number;
        stockDisponible: number;
    };
    ventasPorMes: VentaPorMes[];
    motasMasVendidas: MotaMasVendida[];
    metodosPago: MetodoPago[];
    ventasRecientes: VentaReciente[];
}

defineProps<Props>();

const page = usePage();
const userRole = computed(() => page.props.auth.role);
const isAdmin = computed(() => userRole.value === 'admin');

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

const formatMonth = (mes: string) => {
    const [year, month] = mes.split('-');
    const date = new Date(parseInt(year), parseInt(month) - 1);
    return date.toLocaleDateString('es-ES', { year: 'numeric', month: 'short' });
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
    <Head title="Dashboard" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Bienvenido al sistema de gestión de ventas de motos</p>
                </div>

                <!-- Estadísticas Principales -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
                    <Card title="Total Ventas">
                        <div class="text-center">
                            <p class="text-4xl font-bold text-blue-600">{{ stats.totalVentas }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Ventas realizadas</p>
                        </div>
                    </Card>

                    <Card title="Ingresos Totales">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-green-600">{{ formatPrice(stats.totalIngresos) }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Generados</p>
                        </div>
                    </Card>

                    <Card title="Clientes">
                        <div class="text-center">
                            <p class="text-4xl font-bold text-purple-600">{{ stats.totalClientes }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Registrados</p>
                        </div>
                    </Card>

                    <Card title="Motos">
                        <div class="text-center">
                            <p class="text-4xl font-bold text-orange-600">{{ stats.totalMotos }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">En catálogo</p>
                        </div>
                    </Card>

                    <Card title="Stock">
                        <div class="text-center">
                            <p class="text-4xl font-bold text-indigo-600">{{ stats.stockDisponible }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Unidades disponibles</p>
                        </div>
                    </Card>
                </div>

                <!-- Gráficos y Datos -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <Card title="Ventas por Mes (Últimos 6 meses)">
                        <div class="space-y-3">
                            <div v-for="item in ventasPorMes" :key="item.mes" class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ formatMonth(item.mes) }}
                                </span>
                                <div class="text-right">
                                    <span class="text-sm font-semibold text-blue-600">{{ item.total }} ventas</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">
                                        {{ formatPrice(item.ingresos) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </Card>

                    <Card title="Motos Más Vendidas">
                        <div class="space-y-3">
                            <div v-for="moto in motasMasVendidas" :key="`${moto.marca}-${moto.modelo}`" 
                                 class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ moto.marca }} {{ moto.modelo }}
                                </span>
                                <span class="text-sm font-semibold text-green-600">
                                    {{ moto.ventas }} ventas
                                </span>
                            </div>
                        </div>
                    </Card>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <Card title="Métodos de Pago">
                        <div class="space-y-3">
                            <div v-for="metodo in metodosPago" :key="metodo.metodo_pago" 
                                 class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ metodoPagoLabel(metodo.metodo_pago) }}
                                </span>
                                <span class="text-sm font-semibold text-purple-600">
                                    {{ metodo.total }} ventas
                                </span>
                            </div>
                        </div>
                    </Card>

                    <Card title="Ventas Recientes">
                        <div class="space-y-3">
                            <div v-for="venta in ventasRecientes" :key="venta.id" 
                                 class="border-b border-gray-200 dark:border-gray-700 pb-2 last:border-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ venta.cliente.nombre }} {{ venta.cliente.apellido }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ venta.moto.marca }} {{ venta.moto.modelo }}
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">
                                            {{ formatDate(venta.fecha_venta) }}
                                        </p>
                                    </div>
                                    <span class="text-sm font-semibold text-green-600">
                                        {{ formatPrice(venta.precio_venta) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </Card>
                </div>

                <!-- Acciones Rápidas -->
                <Card title="Acciones Rápidas">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <Button href="/ventas/create" variant="success" class="w-full">
                            💰 Nueva Venta
                        </Button>
                        <Button v-if="isAdmin" href="/motos/create" variant="primary" class="w-full">
                            🏍️ Nueva Moto
                        </Button>
                        <Button v-if="isAdmin" href="/clientes/create" variant="primary" class="w-full">
                            👤 Nuevo Cliente
                        </Button>
                        <Button v-if="isAdmin" href="/reportes" variant="secondary" class="w-full">
                            📊 Ver Reportes
                        </Button>
                    </div>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
