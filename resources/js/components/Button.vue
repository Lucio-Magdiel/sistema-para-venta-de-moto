<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface Props {
    href?: string;
    type?: 'button' | 'submit' | 'reset';
    variant?: 'primary' | 'secondary' | 'danger' | 'success';
    size?: 'sm' | 'md' | 'lg';
    disabled?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    type: 'button',
    variant: 'primary',
    size: 'md',
    disabled: false,
});

const variantClasses = {
    primary: 'bg-blue-600 hover:bg-blue-700 text-white',
    secondary: 'bg-gray-600 hover:bg-gray-700 text-white',
    danger: 'bg-red-600 hover:bg-red-700 text-white',
    success: 'bg-green-600 hover:bg-green-700 text-white',
};

const sizeClasses = {
    sm: 'px-3 py-1.5 text-sm',
    md: 'px-4 py-2 text-base',
    lg: 'px-6 py-3 text-lg',
};

const buttonClass = `inline-flex items-center justify-center rounded-md font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed ${variantClasses[props.variant]} ${sizeClasses[props.size]}`;
</script>

<template>
    <Link
        v-if="href"
        :href="href"
        :class="buttonClass"
    >
        <slot />
    </Link>
    <button
        v-else
        :type="type"
        :disabled="disabled"
        :class="buttonClass"
    >
        <slot />
    </button>
</template>
