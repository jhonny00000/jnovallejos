<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Pencil, Plus, Search, Trash2 } from '@lucide/vue';
import { computed, ref, watch } from 'vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { create, destroy, edit, index } from '@/routes/roles';

type Role = {
    id: number;
    nombre: string;
    descripcion: string | null;
    users_count: number;
};

type PaginatedRoles = {
    data: Role[];
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
};

const props = defineProps<{
    roles: PaginatedRoles;
    filters: {
        search: string;
    };
}>();

const page = usePage();
const canAdmin = computed(() => page.props.auth.can.admin);

const search = ref(props.filters.search);

watch(search, (value) => {
    router.get(
        index().url,
        { search: value },
        {
            preserveState: true,
            replace: true,
        },
    );
});

const deleteRole = (role: Role) => {
    if (window.confirm(`Eliminar el rol ${role.nombre}?`)) {
        router.delete(destroy(role.id).url);
    }
};

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Roles',
                href: index(),
            },
        ],
    },
});
</script>

<template>
    <div>
        <Head title="Roles" />

        <div class="flex flex-col gap-6">
            <div class="flex items-center justify-between gap-4">
                <Heading
                    variant="small"
                    title="Roles"
                    description="Gestiona los roles disponibles del sistema"
                />

                <Button as-child>
                    <Link :href="create()"> <Plus /> Nuevo rol </Link>
                </Button>
            </div>

            <div class="relative max-w-md">
                <Search
                    class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                />
                <Input
                    v-model="search"
                    class="pl-9"
                    placeholder="Buscar por nombre"
                />
            </div>

            <div class="overflow-hidden rounded-lg border">
                <table class="w-full text-sm">
                    <thead class="bg-muted/50 text-left">
                        <tr>
                            <th class="px-4 py-3 font-medium">ID</th>
                            <th class="px-4 py-3 font-medium">Nombre</th>
                            <th class="px-4 py-3 font-medium">Descripcion</th>
                            <th class="px-4 py-3 font-medium">Usuarios</th>
                            <th class="w-28 px-4 py-3 text-right font-medium">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="role in roles.data"
                            :key="role.id"
                            class="border-t"
                        >
                            <td class="px-4 py-3">{{ role.id }}</td>
                            <td class="px-4 py-3 font-medium">{{ role.nombre }}</td>
                            <td class="px-4 py-3 text-muted-foreground">
                                {{ role.descripcion || 'Sin descripcion' }}
                            </td>
                            <td class="px-4 py-3">{{ role.users_count }}</td>
                            <td class="px-4 py-3">
                                <TooltipProvider>
                                    <div class="flex justify-end gap-2">
                                        <Tooltip>
                                            <TooltipTrigger as-child>
                                                <Button
                                                    variant="ghost"
                                                    size="sm"
                                                    as-child
                                                >
                                                    <Link :href="edit(role.id)">
                                                        <Pencil class="h-4 w-4" />
                                                    </Link>
                                                </Button>
                                            </TooltipTrigger>
                                            <TooltipContent>
                                                <p>Editar</p>
                                            </TooltipContent>
                                        </Tooltip>

                                        <Tooltip v-if="canAdmin">
                                            <TooltipTrigger as-child>
                                                <Button
                                                    variant="ghost"
                                                    size="sm"
                                                    @click="deleteRole(role)"
                                                >
                                                    <Trash2 class="h-4 w-4" />
                                                </Button>
                                            </TooltipTrigger>
                                            <TooltipContent>
                                                <p>Eliminar</p>
                                            </TooltipContent>
                                        </Tooltip>
                                    </div>
                                </TooltipProvider>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p
                    v-if="roles.data.length === 0"
                    class="border-t px-4 py-8 text-center text-muted-foreground"
                >
                    No hay roles registrados.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <Button
                    v-for="link in roles.links"
                    :key="link.label"
                    variant="outline"
                    size="sm"
                    :disabled="!link.url"
                    :class="{ 'bg-muted': link.active }"
                    @click="link.url && router.visit(link.url)"
                    v-text="link.label"
                />
            </div>
        </div>
    </div>
</template>
