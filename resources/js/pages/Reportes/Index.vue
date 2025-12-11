<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import Input from '@/components/Input.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    fecha_inicio: '',
    fecha_fin: '',
});

const submit = () => {
    form.post('/reportes/ventas', {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Reportes" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Reportes del Sistema</h1>
                </div>

                <Card title="Reporte de Ventas">
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Genere reportes detallados de las ventas en un rango de fechas específico.
                    </p>

                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <Input
                                v-model="form.fecha_inicio"
                                type="date"
                                label="Fecha Inicio"
                                :error="form.errors.fecha_inicio"
                                required
                            />

                            <Input
                                v-model="form.fecha_fin"
                                type="date"
                                label="Fecha Fin"
                                :error="form.errors.fecha_fin"
                                required
                            />
                        </div>

                        <div class="mt-6">
                            <Button
                                type="submit"
                                variant="primary"
                                :disabled="form.processing"
                            >
                                {{ form.processing ? 'Generando...' : 'Generar Reporte' }}
                            </Button>
                        </div>
                    </form>
                </Card>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <Card title="Accesos Rápidos">
                        <div class="space-y-3">
                            <Button href="/dashboard" variant="secondary" class="w-full">
                                📊 Ver Dashboard
                            </Button>
                            <Button href="/ventas" variant="secondary" class="w-full">
                                💰 Ver Todas las Ventas
                            </Button>
                            <Button href="/motos" variant="secondary" class="w-full">
                                🏍️ Gestionar Motos
                            </Button>
                            <Button href="/clientes" variant="secondary" class="w-full">
                                👥 Gestionar Clientes
                            </Button>
                        </div>
                    </Card>

                    <Card title="Información">
                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                            <p>
                                <strong>Reporte de Ventas:</strong> Genera un informe detallado con todas las ventas realizadas en el período seleccionado.
                            </p>
                            <p class="mt-4">
                                El reporte incluye:
                            </p>
                            <ul class="list-disc list-inside space-y-1 mt-2">
                                <li>Listado completo de ventas</li>
                                <li>Total de ingresos</li>
                                <li>Ventas por método de pago</li>
                                <li>Ventas por vendedor</li>
                            </ul>
                        </div>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
