<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { home } from '@/routes';

const page = usePage();
const name = page.props.name;

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="min-h-dvh bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.14),_transparent_32%),linear-gradient(135deg,_rgba(255,255,255,0.98),_rgba(248,250,252,1))] dark:bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.18),_transparent_30%),linear-gradient(135deg,_rgba(2,6,23,0.98),_rgba(15,23,42,1))]">
        <div class="relative grid min-h-dvh flex-col items-center justify-center px-4 py-6 sm:px-0 lg:max-w-none lg:grid-cols-[1.05fr_0.95fr] lg:px-0">
            <div class="relative hidden h-full flex-col overflow-hidden bg-slate-950 p-10 text-white lg:flex dark:border-r dark:border-white/10">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(96,165,250,0.35),_transparent_35%),linear-gradient(135deg,_rgba(15,23,42,1),_rgba(2,6,23,1))]" />
                <div class="absolute -left-10 top-12 h-40 w-40 rounded-full bg-sky-500/20 blur-3xl" />
                <div class="absolute bottom-0 right-0 h-56 w-56 rounded-full bg-cyan-400/20 blur-3xl" />

                <Link
                    :href="home()"
                    class="relative z-20 flex items-center text-lg font-semibold tracking-tight"
                >
                    <AppLogoIcon class="mr-3 size-9 fill-current text-white" />
                    {{ name }}
                </Link>

                <div class="relative z-20 mt-auto max-w-md space-y-4">
                    <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-300">
                        Bienvenido de nuevo
                    </p>
                    <h2 class="text-3xl font-semibold leading-tight">
                        Gestiona tu cuenta con una experiencia más limpia y segura.
                    </h2>
                    <p class="text-sm leading-6 text-slate-300">
                        Accede a tus herramientas, configura tu perfil y mantén todo ordenado desde un solo lugar.
                    </p>
                </div>
            </div>

            <div class="flex w-full items-center justify-center lg:p-8">
                <div class="w-full max-w-md rounded-3xl border border-border/80 bg-background/95 p-6 shadow-2xl shadow-black/10 backdrop-blur-sm sm:p-8">
                    <div class="mb-6 flex flex-col space-y-2 text-center sm:text-left">
                        <h1 class="text-2xl font-semibold tracking-tight" v-if="title">
                            {{ title }}
                        </h1>
                        <p class="text-sm text-muted-foreground" v-if="description">
                            {{ description }}
                        </p>
                    </div>
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
