<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import Input from '@/components/Input.vue';
import Textarea from '@/components/Textarea.vue';
import Select from '@/components/Select.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    marca: '',
    modelo: '',
    año: new Date().getFullYear(),
    color: '',
    cilindrada: 0,
    precio: 0,
    stock: 0,
    descripcion: '',
    imagen: '',
    estado: 'nuevo',
});

const estadoOptions = [
    { value: 'nuevo', label: 'Nuevo' },
    { value: 'usado', label: 'Usado' },
];

const submit = () => {
    form.post('/motos');
};
</script>

<template>
    <Head title="Nueva Moto" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nueva Moto</h1>
                </div>

                <Card title="Información de la Moto">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <Input
                                v-model="form.marca"
                                label="Marca"
                                placeholder="Honda, Yamaha, etc."
                                :error="form.errors.marca"
                                required
                            />

                            <Input
                                v-model="form.modelo"
                                label="Modelo"
                                placeholder="CBR-600"
                                :error="form.errors.modelo"
                                required
                            />

                            <Input
                                v-model="form.año"
                                type="number"
                                label="Año"
                                :error="form.errors.año"
                                required
                            />

                            <Input
                                v-model="form.color"
                                label="Color"
                                placeholder="Rojo, Negro, etc."
                                :error="form.errors.color"
                                required
                            />

                            <Input
                                v-model="form.cilindrada"
                                type="number"
                                label="Cilindrada (cc)"
                                placeholder="125, 250, 500, etc."
                                :error="form.errors.cilindrada"
                                required
                            />

                            <Input
                                v-model="form.precio"
                                type="number"
                                step="0.01"
                                label="Precio"
                                placeholder="5000.00"
                                :error="form.errors.precio"
                                required
                            />

                            <Input
                                v-model="form.stock"
                                type="number"
                                label="Stock"
                                placeholder="10"
                                :error="form.errors.stock"
                                required
                            />

                            <Select
                                v-model="form.estado"
                                label="Estado"
                                :options="estadoOptions"
                                :error="form.errors.estado"
                                required
                            />
                        </div>

                        <Input
                            v-model="form.imagen"
                            label="URL de Imagen"
                            placeholder="https://ejemplo.com/imagen.jpg"
                            :error="form.errors.imagen"
                        />

                        <Textarea
                            v-model="form.descripcion"
                            label="Descripción"
                            placeholder="Descripción detallada de la moto..."
                            :error="form.errors.descripcion"
                            :rows="4"
                        />

                        <div class="flex justify-end gap-3 mt-6">
                            <Button href="/motos" variant="secondary">
                                Cancelar
                            </Button>
                            <Button
                                type="submit"
                                variant="primary"
                                :disabled="form.processing"
                            >
                                {{ form.processing ? 'Guardando...' : 'Guardar Moto' }}
                            </Button>
                        </div>
                    </form>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
