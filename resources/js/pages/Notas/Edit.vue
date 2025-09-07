<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';

interface Nota { id:number; title:string; content:string }
interface Props { nota: Nota }

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Notas', href: route('notas.index') },
  { title: 'Editar', href: '#' },
];

const form = useForm({
  title: props.nota.title,
  content: props.nota.content,
  _method: 'PUT' as const,
});

const submit = () => {
  form.post(route('notas.update', props.nota.id), {
    onSuccess: () => {},
  });
};
</script>

<template>
  <Head :title="`Editar: ${props.nota.title}`" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
        <div class="max-w-2xl mx-auto">
          <h1 class="text-2xl font-semibold mb-6">Editar Nota</h1>
          <form @submit.prevent="submit" class="space-y-6">
            <div>
              <label for="title" class="block text-sm font-medium mb-2">Título</label>
              <input id="title" v-model="form.title" type="text" required maxlength="150"
                     class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600"/>
              <div v-if="form.errors.title" class="text-sm text-red-600 mt-1">{{ form.errors.title }}</div>
            </div>
            <div>
              <label for="content" class="block text-sm font-medium mb-2">Contenido</label>
              <textarea id="content" v-model="form.content" required rows="8"
                        class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600"></textarea>
              <div v-if="form.errors.content" class="text-sm text-red-600 mt-1">{{ form.errors.content }}</div>
            </div>
            <div class="flex items-center justify-between">
              <Link :href="route('notas.show', props.nota.id)" class="px-4 py-2 text-sm border rounded-md">Cancelar</Link>
              <button type="submit" :disabled="form.processing" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-md disabled:opacity-50">
                {{ form.processing ? 'Actualizando...' : 'Actualizar' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
