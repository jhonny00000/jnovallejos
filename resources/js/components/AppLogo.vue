<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
</script>

<template>
    <div class="flex items-center gap-2">
        <div
            class="flex aspect-square size-8 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground"
        >
            <AppLogoIcon class="size-5 fill-current text-white dark:text-black" />
        </div>
        <div class="grid flex-1 text-left text-sm group-data-[collapsible=icon]:hidden">
            <span class="mb-0.5 truncate leading-tight font-semibold"
                >Sistema de Gestión Web III</span
            >
        </div>
    </div>
</template>
