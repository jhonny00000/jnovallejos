<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { home } from '@/routes';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="flex min-h-svh items-center justify-center bg-[linear-gradient(135deg,theme(colors.muted)_0%,theme(colors.background)_100%)] p-4 sm:p-6 lg:p-8"
    >
        <div class="flex w-full max-w-md flex-col items-center gap-4">
            <Link
                :href="home()"
                class="flex items-center gap-2 self-center rounded-full border border-border/70 bg-background/90 px-3 py-2 shadow-sm backdrop-blur"
            >
                <div class="flex h-9 w-9 items-center justify-center">
                    <AppLogoIcon
                        class="size-9 fill-current text-black dark:text-white"
                    />
                </div>
            </Link>

            <Card class="w-full overflow-hidden rounded-2xl border border-border/80 bg-background/95 py-0 shadow-xl shadow-black/5 backdrop-blur-sm">
                <CardHeader class="px-8 pt-8 pb-0 text-center">
                    <CardTitle class="text-xl font-semibold">{{ title }}</CardTitle>
                    <CardDescription class="mt-2 text-sm text-muted-foreground">
                        {{ description }}
                    </CardDescription>
                </CardHeader>
                <CardContent class="px-8 pb-8 pt-6">
                    <slot />
                </CardContent>
            </Card>
        </div>
    </div>
</template>
