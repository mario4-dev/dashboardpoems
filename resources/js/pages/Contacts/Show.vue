<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

interface Contact {
    id: number;
    name: string;
    phone: string;
    avatar: string | null;
    privacy: 'public' | 'private';
    created_at: string;
    updated_at: string;
}

interface Props {
    contact: Contact;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Contacts',
        href: route('contacts.index'),
    },
    {
        title: 'View Contact',
        href: '#',
    },
];

const deleteContact = async () => {
    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Quieres eliminar el contacto "${props.contact.name}"? Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
        focusCancel: true,
        customClass: {
            popup: 'dark:bg-gray-800 dark:text-white',
            title: 'dark:text-white',
            htmlContainer: 'dark:text-gray-300',
        }
    });

    if (result.isConfirmed) {
        router.delete(route('contacts.destroy', props.contact.id), {
            onSuccess: () => {
                Swal.fire({
                    title: '¡Eliminado!',
                    text: 'El contacto ha sido eliminado correctamente.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'dark:bg-gray-800 dark:text-white',
                        title: 'dark:text-white',
                        htmlContainer: 'dark:text-gray-300',
                    }
                });
            },
            onError: (errors) => {
                console.error('Error deleting contact:', errors);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al eliminar el contacto. Inténtalo de nuevo.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    customClass: {
                        popup: 'dark:bg-gray-800 dark:text-white',
                        title: 'dark:text-white',
                        htmlContainer: 'dark:text-gray-300',
                    }
                });
            }
        });
    }
};
</script>

<template>
    <Head :title="`Contact: ${contact.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                <div class="max-w-4xl mx-auto">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold">Contact Details</h1>
                        <div class="flex space-x-3">
                            <Link
                                :href="route('contacts.edit', contact.id)"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Edit Contact
                            </Link>
                            <Link
                                :href="route('contacts.index')"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Back to Contacts
                            </Link>
                        </div>
                    </div>

                    <!-- Contact Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-6 mb-8">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <img
                                    v-if="contact.avatar"
                                    :src="contact.avatar"
                                    :alt="`${contact.name}'s avatar`"
                                    class="w-24 h-24 rounded-full object-cover border-4 border-gray-200 dark:border-gray-600"
                                />
                                <div
                                    v-else
                                    class="w-24 h-24 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center border-4 border-gray-200 dark:border-gray-600"
                                >
                                    <span class="text-gray-600 dark:text-gray-300 font-bold text-2xl">
                                        {{ contact.name.charAt(0).toUpperCase() }}
                                    </span>
                                </div>
                            </div>

                            <!-- Basic Info -->
                            <div class="flex-1 min-w-0">
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-white truncate">
                                    {{ contact.name }}
                                </h2>
                                <p class="text-xl text-gray-600 dark:text-gray-400 mt-1">
                                    {{ contact.phone }}
                                </p>
                                <div class="flex items-center mt-3">
                                    <span
                                        :class="{
                                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': contact.privacy === 'public',
                                            'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300': contact.privacy === 'private'
                                        }"
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                                    >
                                        {{ contact.privacy === 'public' ? '🌐 Public Contact' : '🔒 Private Contact' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Contact Information</h3>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-20">Name:</span>
                                            <span class="text-sm text-gray-900 dark:text-white">{{ contact.name }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-20">Phone:</span>
                                            <a
                                                :href="`tel:${contact.phone}`"
                                                class="text-sm text-blue-600 dark:text-blue-400 hover:underline"
                                            >
                                                {{ contact.phone }}
                                            </a>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-20">Privacy:</span>
                                            <span class="text-sm text-gray-900 dark:text-white capitalize">{{ contact.privacy }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Timestamps</h3>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-20">Created:</span>
                                            <span class="text-sm text-gray-900 dark:text-white">{{ contact.created_at }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-20">Updated:</span>
                                            <span class="text-sm text-gray-900 dark:text-white">{{ contact.updated_at }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-between">
                            <Link
                                :href="route('contacts.index')"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                ← Back to Contacts
                            </Link>
                            <div class="flex space-x-3">
                                <Link
                                    :href="route('contacts.edit', contact.id)"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Edit Contact
                                </Link>
                                <button
                                    type="button"
                                    @click="deleteContact"
                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                >
                                    Delete Contact
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>