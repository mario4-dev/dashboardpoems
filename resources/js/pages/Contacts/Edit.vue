<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Contact {
    id: number;
    name: string;
    phone: string;
    avatar: string | null;
    privacy: 'public' | 'private';
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
        title: 'Edit Contact',
        href: '#',
    },
];

const form = useForm({
    name: props.contact.name,
    phone: props.contact.phone,
    avatar: null as File | null,
    privacy: props.contact.privacy,
    _method: 'PUT' as string,  // Agregar explícitamente el método
});

const avatarInput = ref<HTMLInputElement>();
const avatarPreview = ref<string | null>(props.contact.avatar);
const successMessage = ref<string | null>(null);

// Handle avatar change and show preview
const handleAvatarChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file) {
        form.avatar = file;
        const reader = new FileReader();
        reader.onload = (e: any) => {
            avatarPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

// Clear selected image
const clearAvatar = () => {
    form.avatar = null;
    avatarPreview.value = props.contact.avatar; // Reset to original avatar
    if (avatarInput.value) avatarInput.value.value = '';
};

const submit = () => {
    successMessage.value = null;
    
    // Usar POST directo con _method incluido en el form data
    form.post(route('contacts.update', props.contact.id), {
        forceFormData: true,
        onSuccess: () => {
            successMessage.value = 'Contact updated successfully!';
        },
        onError: (errors) => {
            console.error('Error updating contact:', errors);
        },
    });
};
</script>

<template>
    <Head :title="`Edit Contact: ${contact.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">
                <div class="max-w-2xl mx-auto">
                    <h1 class="text-2xl font-semibold mb-6">Edit Contact</h1>

                    <!-- Success Message -->
                    <div v-if="successMessage" class="mb-4 rounded-md bg-green-100 border border-green-400 text-green-700 px-4 py-3">
                        {{ successMessage }}
                    </div>

                    <!-- Mensajes de error de validación -->
                    <div v-if="Object.keys(form.errors).length > 0" class="mb-4 rounded-md bg-red-50 border border-red-200 px-4 py-3">
                        <h3 class="text-sm font-medium text-red-800">Por favor, corrige los siguientes errores:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                <li v-for="(error, field) in form.errors" :key="field">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6" autocomplete="off" role="form">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                maxlength="100"
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white
                                    border-gray-300 dark:border-gray-600
                                    transition
                                    "
                                :class="{'border-red-500 ring-red-300': form.errors.name}"
                                placeholder="Ingresa el nombre del contacto"
                                aria-required="true"
                                aria-invalid="form.errors.name ? 'true' : 'false'"
                                aria-describedby="name-error"
                            />
                            <div v-if="form.errors.name" id="name-error" class="text-red-500 text-sm mt-1" role="alert">
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <!-- Phone Field -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Phone <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="phone"
                                v-model="form.phone"
                                type="tel"
                                required
                                maxlength="15"
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white
                                    border-gray-300 dark:border-gray-600
                                    transition"
                                :class="{'border-red-500 ring-red-300': form.errors.phone}"
                                placeholder="e.g. +52 123 456 7890"
                                aria-required="true"
                                aria-invalid="form.errors.phone ? 'true' : 'false'"
                            />
                            <div v-if="form.errors.phone" class="text-red-500 text-sm mt-1" role="alert">
                                {{ form.errors.phone }}
                            </div>
                        </div>

                        <!-- Avatar Field -->
                        <div>
                            <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Avatar (Optional)
                            </label>

                            <!-- Current Avatar -->
                            <div v-if="avatarPreview && !form.avatar" class="mb-3">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Current avatar:</p>
                                <img :src="avatarPreview" alt="Current avatar" class="w-16 h-16 rounded-full border object-cover" />
                            </div>

                            <div class="flex items-center gap-4">
                                <input
                                    id="avatar"
                                    ref="avatarInput"
                                    type="file"
                                    accept="image/*"
                                    @change="handleAvatarChange"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                />
                                <button
                                    v-if="form.avatar || (avatarPreview && avatarPreview !== contact.avatar)"
                                    type="button"
                                    @click="clearAvatar"
                                    class="text-xs text-red-500 border border-red-400 px-2 py-1 rounded hover:bg-red-100"
                                    aria-label="Clear avatar"
                                >Clear</button>
                            </div>

                            <!-- New Avatar Preview -->
                            <div v-if="form.avatar && avatarPreview && avatarPreview !== contact.avatar" class="mt-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">New avatar preview:</p>
                                <img :src="avatarPreview" alt="Avatar preview" class="w-16 h-16 rounded-full border object-cover" />
                            </div>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Choose an image file for the contact avatar (JPG, PNG, max 2MB). Leave empty to keep current avatar.
                            </p>
                            <div v-if="form.errors.avatar" class="text-red-500 text-sm mt-1" role="alert">
                                {{ form.errors.avatar }}
                            </div>
                        </div>

                        <!-- Privacy Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Privacy <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input
                                        id="privacy-private"
                                        v-model="form.privacy"
                                        type="radio"
                                        value="private"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600"
                                        aria-checked="form.privacy==='private'"
                                        aria-label="Private"
                                    />
                                    <label for="privacy-private" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Private
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input
                                        id="privacy-public"
                                        v-model="form.privacy"
                                        type="radio"
                                        value="public"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600"
                                        aria-checked="form.privacy==='public'"
                                        aria-label="Public"
                                    />
                                    <label for="privacy-public" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Public
                                    </label>
                                </div>
                            </div>
                            <div v-if="form.errors.privacy" class="text-red-500 text-sm mt-1" role="alert">
                                {{ form.errors.privacy }}
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-between pt-4">
                            <div class="flex space-x-3">
                                <Link
                                    :href="route('contacts.show', contact.id)"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Cancel
                                </Link>
                                <Link
                                    :href="route('contacts.index')"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Back to Contacts
                                </Link>
                            </div>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                            >
                                <svg v-if="form.processing" class="animate-spin h-4 w-4 text-white mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                </svg>
                                <span v-if="form.processing">Updating...</span>
                                <span v-else>Update Contact</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
