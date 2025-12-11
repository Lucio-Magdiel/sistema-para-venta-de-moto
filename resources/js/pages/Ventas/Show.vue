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
    observaciones: string | null;
    fecha_venta: string;
    created_at: string;
}

interface Props {
    venta: Venta;
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
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
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
    <Head title="Detalle de Venta" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Detalle de Venta #{{ venta.id }}
                    </h1>
                    <Button href="/ventas" variant="secondary">
                        Volver
                    </Button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <Card title="Información del Cliente">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cliente</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-white">
                                    {{ venta.cliente.nombre }} {{ venta.cliente.apellido }}
                                </dd>
                            </div>
                        </dl>
                    </Card>

                    <Card title="Información de la Moto">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Moto Vendida</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-white">
                                    {{ venta.moto.marca }} {{ venta.moto.modelo }}
                                </dd>
                            </div>
                        </dl>
                    </Card>
                </div>

                <Card title="Detalles de la Venta">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Precio de Venta</dt>
                            <dd class="mt-1 text-3xl font-bold text-green-600">
                                {{ formatPrice(venta.precio_venta) }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Método de Pago</dt>
                            <dd class="mt-1">
                                <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full">
                                    {{ metodoPagoLabel(venta.metodo_pago) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Venta</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-white">
                                {{ formatDate(venta.fecha_venta) }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Vendedor</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-white">
                                {{ venta.user.name }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Registrada el</dt>
                            <dd class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                                {{ formatDate(venta.created_at) }}
                            </dd>
                        </div>
                    </dl>

                    <div v-if="venta.observaciones" class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Observaciones</dt>
                        <dd class="text-base text-gray-900 dark:text-white whitespace-pre-line">
                            {{ venta.observaciones }}
                        </dd>
                    </div>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
