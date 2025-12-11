<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import Input from '@/components/Input.vue';
import Textarea from '@/components/Textarea.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    nombre: '',
    apellido: '',
    documento: '',
    email: '',
    telefono: '',
    direccion: '',
});

const submit = () => {
    form.post('/clientes');
};
</script>

<template>
    <Head title="Nuevo Cliente" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nuevo Cliente</h1>
                </div>

                <Card title="Información del Cliente">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <Input
                                v-model="form.nombre"
                                label="Nombre"
                                placeholder="Juan"
                                :error="form.errors.nombre"
                                required
                            />

                            <Input
                                v-model="form.apellido"
                                label="Apellido"
                                placeholder="Pérez"
                                :error="form.errors.apellido"
                                required
                            />

                            <Input
                                v-model="form.documento"
                                label="Documento"
                                placeholder="12345678"
                                :error="form.errors.documento"
                                required
                            />

                            <Input
                                v-model="form.email"
                                type="email"
                                label="Email"
                                placeholder="juan@ejemplo.com"
                                :error="form.errors.email"
                                required
                            />

                            <Input
                                v-model="form.telefono"
                                label="Teléfono"
                                placeholder="+1234567890"
                                :error="form.errors.telefono"
                                required
                            />
                        </div>

                        <Textarea
                            v-model="form.direccion"
                            label="Dirección"
                            placeholder="Calle Principal 123, Ciudad"
                            :error="form.errors.direccion"
                            :rows="3"
                            required
                        />

                        <div class="flex justify-end gap-3 mt-6">
                            <Button href="/clientes" variant="secondary">
                                Cancelar
                            </Button>
                            <Button
                                type="submit"
                                variant="primary"
                                :disabled="form.processing"
                            >
                                {{ form.processing ? 'Guardando...' : 'Guardar Cliente' }}
                            </Button>
                        </div>
                    </form>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
