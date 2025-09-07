<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { onMounted } from 'vue';

// Redirigir a la vista de contactos
onMounted(() => {
    router.visit(route('contacts.index'), { replace: true });
});
</script>

<template>
    <div class="flex items-center justify-center min-h-screen">
        <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto mb-4"></div>
            <p class="text-gray-600 dark:text-gray-400">Cargando contactos...</p>
        </div>
    </div>
</template>
