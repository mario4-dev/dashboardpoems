<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

interface Contact {
    id: number;
    name: string;
    phone: string;
    avatar: string | null;
    privacy: 'public' | 'private';
    created_at: string;
}

interface Props {
    contacts: Contact[];
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Contacts',
        href: route('contacts.index'),
    },
];
</script>

<template>
    <Head title="Contacts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                <div class="max-w-6xl mx-auto">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold">Contacts</h1>
                        <Link
                            :href="route('contacts.create')"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Create Contact
                        </Link>
                    </div>

                    <!-- Contacts List -->
                    <div v-if="contacts.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div
                            v-for="contact in contacts"
                            :key="contact.id"
                            class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700"
                        >
                            <div class="flex items-center space-x-4">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <img
                                        v-if="contact.avatar"
                                        :src="contact.avatar"
                                        :alt="`${contact.name}'s avatar`"
                                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                                    />
                                    <div
                                        v-else
                                        class="w-12 h-12 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center"
                                    >
                                        <span class="text-gray-600 dark:text-gray-300 font-medium text-lg">
                                            {{ contact.name.charAt(0).toUpperCase() }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Contact Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white truncate">
                                        {{ contact.name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ contact.phone }}
                                    </p>
                                    <div class="flex items-center mt-1">
                                        <span
                                            :class="{
                                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': contact.privacy === 'public',
                                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300': contact.privacy === 'private'
                                            }"
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                        >
                                            {{ contact.privacy === 'public' ? '🌐 Public' : '🔒 Private' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Actions -->
                            <div class="mt-4 flex justify-between items-center">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Created {{ contact.created_at }}
                                </p>
                                <div class="flex space-x-2">
                                    <Link
                                        :href="route('contacts.edit', contact.id)"
                                        class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                                        title="Edit Contact"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </Link>
                                    <Link
                                        :href="route('contacts.show', contact.id)"
                                        class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                                        title="View Details"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="text-center py-12">
                        <div class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-24 w-24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No contacts yet</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-400">Get started by creating a new contact.</p>
                        <div class="mt-6">
                            <Link
                                :href="route('contacts.create')"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                New Contact
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>