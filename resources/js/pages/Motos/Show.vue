<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import { Head } from '@inertiajs/vue3';

interface Moto {
    id: number;
    marca: string;
    modelo: string;
    año: number;
    color: string;
    cilindrada: number;
    precio: number;
    stock: number;
    descripcion: string;
    imagen: string;
    estado: string;
    created_at: string;
    updated_at: string;
}

interface Props {
    moto: Moto;
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
    <Head :title="`${moto.marca} ${moto.modelo}`" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ moto.marca }} {{ moto.modelo }}
                    </h1>
                    <div class="flex gap-3">
                        <Button v-if="$page.props.auth.role === 'admin'" :href="`/motos/${moto.id}/edit`" variant="primary">
                            Editar
                        </Button>
                        <Button href="/motos" variant="secondary">
                            Volver
                        </Button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <Card title="Detalles de la Moto">
                        <div v-if="moto.imagen" class="mb-4">
                            <img
                                :src="moto.imagen"
                                :alt="`${moto.marca} ${moto.modelo}`"
                                class="w-full h-48 object-cover rounded-lg"
                            >
                        </div>

                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Marca</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ moto.marca }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Modelo</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ moto.modelo }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Año</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ moto.año }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Color</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ moto.color }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cilindrada</dt>
                                <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ moto.cilindrada }} cc</dd>
                            </div>
                        </dl>
                    </Card>

                    <Card title="Información Comercial">
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Precio</dt>
                                <dd class="mt-1 text-2xl font-bold text-blue-600 dark:text-blue-400">
                                    {{ formatPrice(moto.precio) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock Disponible</dt>
                                <dd class="mt-1 text-lg" :class="moto.stock > 0 ? 'text-green-600' : 'text-red-600'">
                                    {{ moto.stock }} unidades
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                                <dd class="mt-1">
                                    <span
                                        :class="[
                                            'px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full',
                                            moto.estado === 'nuevo' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
                                        ]"
                                    >
                                        {{ moto.estado }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Registrado</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ formatDate(moto.created_at) }}
                                </dd>
                            </div>
                        </dl>
                    </Card>
                </div>

                <Card v-if="moto.descripcion" title="Descripción" class="mt-6">
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                        {{ moto.descripcion }}
                    </p>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
