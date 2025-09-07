<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';

interface Nota { id:number; title:string; content:string; created_at:string|null }
interface Props { notas: Nota[] }

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Notas', href: route('notas.index') },
];

const delForm = useForm({});
const deleteNota = (id: number) => {
  if (confirm('¿Eliminar esta nota?')) {
    delForm.delete(route('notas.destroy', id));
  }
};
</script>

<template>
  <Head title="Notas" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
        <div class="max-w-4xl mx-auto">
          <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Notas</h1>
            <Link :href="route('notas.create')" class="px-3 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">Nueva nota</Link>
          </div>
          <div v-if="props.notas.length === 0" class="text-gray-500">No hay notas aún.</div>
          <ul class="space-y-3" v-else>
            <li v-for="n in props.notas" :key="n.id" class="p-4 border rounded-md dark:border-gray-700">
              <div class="flex items-start justify-between">
                <div>
                  <h3 class="font-medium text-lg">{{ n.title }}</h3>
                  <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">{{ n.content }}</p>
                  <p class="text-xs text-gray-400 mt-1">{{ n.created_at }}</p>
                </div>
                <div class="flex gap-2">
                  <Link :href="route('notas.show', n.id)" class="text-blue-600 hover:underline text-sm">Ver</Link>
                  <Link :href="route('notas.edit', n.id)" class="text-yellow-700 hover:underline text-sm">Editar</Link>
                  <button @click="deleteNota(n.id)" class="text-red-600 hover:underline text-sm">Eliminar</button>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
