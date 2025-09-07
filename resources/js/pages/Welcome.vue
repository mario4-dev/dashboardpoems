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
            <main class="flex flex-col lg:flex-row w-full max-w-6xl items-center justify-center gap-8 lg:gap-20 px-4">
                <div class="flex-1 max-w-2xl text-center lg:text-left order-1 lg:order-2">
                    <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-4 lg:mb-6 leading-tight">
                        Bienvenidos
                    </h1>

                    <p class="text-base md:text-lg lg:text-xl text-white/80 mb-6 lg:mb-8 leading-relaxed">
                        Un lugar seguro donde puedes ser tú mismo y encontrar paz.
                        Aquí encontrarás un espacio de tranquilidad y reflexión donde
                        tus pensamientos pueden fluir libremente.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <!-- <button class="bg-white text-purple-900 px-6 lg:px-8 py-3 rounded-lg font-semibold text-base lg:text-lg hover:bg-white/90 transition-colors shadow-lg">
                            Comenzar
                        </button> -->
                        <!-- <button class="border-2 border-white text-white px-6 lg:px-8 py-3 rounded-lg font-semibold text-base lg:text-lg hover:bg-white/10 transition-colors">
                            Explorar
                        </button> -->
                    </div>
                </div>
                <!-- Imagen a la izquierda -->
                <div class="flex-shrink-0 order-2 lg:order-1">
                    <!-- Imagen ajustada para no verse demasiado grande en pantallas grandes -->
                    <img
                        src="/rose.png"
                        alt="Ilustración de una rosa"
                        loading="lazy"
                        decoding="async"
                        class="w-28 sm:w-36 md:w-40 lg:w-48 xl:w-52 2xl:w-56 max-w-full h-auto object-contain opacity-90 drop-shadow-xl transition-transform duration-300 hover:scale-[1.03]"
                    />
                </div>

                <!-- Contenido principal a la derecha -->

            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
