<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/Button.vue';
import Card from '@/components/Card.vue';
import Input from '@/components/Input.vue';
import Select from '@/components/Select.vue';
import Textarea from '@/components/Textarea.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

interface Cliente {
    id: number;
    nombre: string;
    apellido: string;
}

interface Moto {
    id: number;
    marca: string;
    modelo: string;
    precio: number;
    stock: number;
}

interface Props {
    clientes: Cliente[];
    motos: Moto[];
}

const props = defineProps<Props>();

const form = useForm({
    cliente_id: '',
    moto_id: '',
    precio_venta: 0,
    metodo_pago: '',
    observaciones: '',
    fecha_venta: new Date().toISOString().split('T')[0],
});

const clienteOptions = computed(() =>
    props.clientes.map(c => ({
        value: c.id,
        label: `${c.nombre} ${c.apellido}`,
    }))
);

const motoOptions = computed(() =>
    props.motos.map(m => ({
        value: m.id,
        label: `${m.marca} ${m.modelo} - Stock: ${m.stock}`,
    }))
);

const metodoPagoOptions = [
    { value: 'efectivo', label: 'Efectivo' },
    { value: 'tarjeta', label: 'Tarjeta' },
    { value: 'transferencia', label: 'Transferencia' },
    { value: 'financiamiento', label: 'Financiamiento' },
];

// Auto-completar precio cuando se selecciona una moto
watch(() => form.moto_id, (motoId) => {
    if (motoId) {
        const moto = props.motos.find(m => m.id === Number(motoId));
        if (moto) {
            form.precio_venta = moto.precio;
        }
    }
});

const submit = () => {
    form.post('/ventas');
};
</script>

<template>
    <Head title="Nueva Venta" />

    <AppLayout>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Registrar Nueva Venta</h1>
                </div>

                <Card title="Información de la Venta">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <Select
                                v-model="form.cliente_id"
                                label="Cliente"
                                :options="clienteOptions"
                                placeholder="Seleccione un cliente"
                                :error="form.errors.cliente_id"
                                required
                            />

                            <Select
                                v-model="form.moto_id"
                                label="Moto"
                                :options="motoOptions"
                                placeholder="Seleccione una moto"
                                :error="form.errors.moto_id"
                                required
                            />

                            <Input
                                v-model="form.precio_venta"
                                type="number"
                                step="0.01"
                                label="Precio de Venta"
                                placeholder="5000.00"
                                :error="form.errors.precio_venta"
                                required
                            />

                            <Select
                                v-model="form.metodo_pago"
                                label="Método de Pago"
                                :options="metodoPagoOptions"
                                placeholder="Seleccione método"
                                :error="form.errors.metodo_pago"
                                required
                            />

                            <Input
                                v-model="form.fecha_venta"
                                type="date"
                                label="Fecha de Venta"
                                :error="form.errors.fecha_venta"
                                required
                            />
                        </div>

                        <Textarea
                            v-model="form.observaciones"
                            label="Observaciones"
                            placeholder="Observaciones adicionales de la venta..."
                            :error="form.errors.observaciones"
                            :rows="4"
                        />

                        <div class="flex justify-end gap-3 mt-6">
                            <Button href="/ventas" variant="secondary">
                                Cancelar
                            </Button>
                            <Button
                                type="submit"
                                variant="success"
                                :disabled="form.processing"
                            >
                                {{ form.processing ? 'Registrando...' : 'Registrar Venta' }}
                            </Button>
                        </div>
                    </form>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
