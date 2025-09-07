<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';

interface Nota { id:number; title:string; content:string, created_at?:string|null, updated_at?:string|null }
interface Props { nota: Nota }

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Notas', href: route('notas.index') },
  { title: props.nota.title, href: '#' },
];

const delForm = useForm({});
const destroy = () => {
  if (confirm('¿Eliminar esta nota?')) {
    delForm.delete(route('notas.destroy', props.nota.id));
  }
};
</script>

<template>
  <Head :title="props.nota.title" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
        <div class="max-w-3xl mx-auto">
          <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">{{ props.nota.title }}</h1>
            <div class="flex gap-2">
              <Link :href="route('notas.edit', props.nota.id)" class="px-3 py-2 text-sm bg-yellow-500 text-white rounded-md">Editar</Link>
              <button @click="destroy" class="px-3 py-2 text-sm bg-red-600 text-white rounded-md">Eliminar</button>
              <Link :href="route('notas.index')" class="px-3 py-2 text-sm border rounded-md">Volver</Link>
            </div>
          </div>
          <article class="prose dark:prose-invert max-w-none">
            <p class="whitespace-pre-wrap">{{ props.nota.content }}</p>
          </article>
          <p class="text-xs text-gray-400 mt-6">Creada: {{ props.nota.created_at }} | Actualizada: {{ props.nota.updated_at }}</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
