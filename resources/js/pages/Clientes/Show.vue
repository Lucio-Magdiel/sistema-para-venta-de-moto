<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import { Head } from '@inertiajs/vue3';

interface Venta {
    id: number;
    moto: {
        marca: string;
        modelo: string;
    };
    precio_venta: number;
    fecha_venta: string;
}

interface Cliente {
    id: number;
    nombre: string;
    apellido: string;
    documento: string;
    email: string;
    telefono: string;
    direccion: string;
    created_at: string;
    ventas: Venta[];
}

interface Props {
    cliente: Cliente;
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
    });
};
</script>

<template>
    <Head :title="`${cliente.nombre} ${cliente.apellido}`" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ cliente.nombre }} {{ cliente.apellido }}
                    </h1>
                    <div class="flex gap-3">
                        <Button v-if="$page.props.auth.role === 'admin'" :href="`/clientes/${cliente.id}/edit`" variant="primary">
                            Editar
                        </Button>
                        <Button href="/clientes" variant="secondary">
                            Volver
                        </Button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <Card title="Información Personal">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-white">
                                    {{ cliente.nombre }} {{ cliente.apellido }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Documento</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ cliente.documento }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ cliente.email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ cliente.telefono }}</dd>
                            </div>
                        </dl>
                    </Card>

                    <Card title="Información Adicional">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dirección</dt>
                                <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ cliente.direccion }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cliente desde</dt>
                                <dd class="mt-1 text-base text-gray-900 dark:text-white">
                                    {{ formatDate(cliente.created_at) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Compras</dt>
                                <dd class="mt-1 text-2xl font-bold text-blue-600">
                                    {{ cliente.ventas.length }}
                                </dd>
                            </div>
                        </dl>
                    </Card>
                </div>

                <Card title="Historial de Compras">
                    <div v-if="cliente.ventas.length > 0" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                        Fecha
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                        Moto
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                        Precio
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr v-for="venta in cliente.ventas" :key="venta.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ formatDate(venta.fecha_venta) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ venta.moto.marca }} {{ venta.moto.modelo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-green-600">
                                        {{ formatPrice(venta.precio_venta) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <p>Este cliente aún no ha realizado compras.</p>
                    </div>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
