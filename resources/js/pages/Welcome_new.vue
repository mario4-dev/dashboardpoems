<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex min-h-screen flex-col items-center bg-gradient-to-br from-purple-900 via-purple-700 to-indigo-800 p-6 text-white lg:justify-center lg:p-8">
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="inline-block rounded-sm border border-white/30 px-5 py-1.5 text-sm leading-normal text-white hover:border-white/50 hover:bg-white/10"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-white hover:border-white/30 hover:bg-white/10"
                    >
                        Log in
                    </Link>
                    <Link
                        :href="route('register')"
                        class="inline-block rounded-sm border border-white/30 px-5 py-1.5 text-sm leading-normal text-white hover:border-white/50 hover:bg-white/10"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>
        <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg lg:max-w-4xl lg:flex-row">
                <div
                    class="flex-1 rounded-br-lg rounded-bl-lg bg-white/90 backdrop-blur-sm p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(255,255,255,0.2)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 text-gray-800"
                >
                    <h1 class="mb-4 text-2xl font-bold text-center">Bienvenidos a tu safe space</h1>
                    <p class="mb-6 text-gray-600 text-center">
                        Un lugar seguro donde puedes ser tú mismo y encontrar paz.
                    </p>
                    <div class="mb-6 text-center">
                        <div class="mb-4 flex justify-center">
                            <img
                                src="/rose.png"
                                alt="Rosa"
                                class="w-24 h-24 object-contain opacity-80"
                            />
                        </div>
                        <p class="text-gray-700 leading-relaxed">
                            Aquí encontrarás un espacio de tranquilidad y reflexión.
                            Un lugar donde tus pensamientos pueden fluir libremente
                            y donde puedes encontrar la paz que necesitas.
                        </p>
                    </div>
                    <div class="flex justify-center gap-3 text-sm leading-normal">
                        <button class="inline-block rounded-sm border border-purple-600 bg-purple-600 px-6 py-2 text-sm leading-normal text-white hover:border-purple-700 hover:bg-purple-700 transition-colors shadow-md">
                            Comenzar
                        </button>
                    </div>
                </div>
                <div
                    class="relative -mb-px aspect-335/376 w-full shrink-0 overflow-hidden rounded-t-lg bg-gradient-to-br from-purple-400/20 to-indigo-400/20 backdrop-blur-sm lg:mb-0 lg:-ml-px lg:aspect-auto lg:w-[438px] lg:rounded-t-none lg:rounded-r-lg"
                >
                    <div class="flex items-center justify-center h-full p-8">
                        <div class="text-center">
                            <img
                                src="/rose.png"
                                alt="Rosa"
                                class="w-32 h-32 mx-auto mb-4 object-contain opacity-90"
                            />
                            <h2 class="text-2xl font-bold text-white mb-2">Safe Space</h2>
                            <p class="text-white/80 text-sm">Tu lugar de paz y reflexión</p>
                        </div>
                    </div>
                    <div
                        class="absolute inset-0 rounded-t-lg shadow-[inset_0px_0px_0px_1px_rgba(255,255,255,0.2)] lg:overflow-hidden lg:rounded-t-none lg:rounded-r-lg"
                    />
                </div>
            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
