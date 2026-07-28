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
import { create, destroy, edit, index } from '@/routes/users';

type User = {
    id: number;
    name: string;
    a_paterno: string | null;
    a_materno: string | null;
    ci: string | null;
    email: string;
    role: {
        id: number;
        nombre: string;
    } | null;
};

type PaginatedUsers = {
    data: User[];
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
};

const props = defineProps<{
    users: PaginatedUsers;
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

const deleteUser = (user: User) => {
    if (window.confirm(`Eliminar el usuario ${user.name}?`)) {
        router.delete(destroy(user.id).url);
    }
};

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Usuarios',
                href: index(),
            },
        ],
    },
});
</script>

<template>
    <div>
        <Head title="Usuarios" />

        <div class="flex flex-col gap-6">
            <div
                class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
            >
                <Heading
                    variant="small"
                    title="Usuarios"
                    description="Listado con rol, buscador y paginacion"
                />

                <Button as-child>
                    <Link :href="create()"> <Plus /> Nuevo usuario </Link>
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
                            <th class="px-4 py-3 font-medium">CI</th>
                            <th class="px-4 py-3 font-medium">Correo</th>
                            <th class="px-4 py-3 font-medium">Rol</th>
                            <th class="w-28 px-4 py-3 text-right font-medium">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="user in users.data"
                            :key="user.id"
                            class="border-t"
                        >
                            <td class="px-4 py-3">{{ user.id }}</td>
                            <td class="px-4 py-3 font-medium">
                                {{ user.name }} {{ user.a_paterno }}
                                {{ user.a_materno }}
                            </td>
                            <td class="px-4 py-3">{{ user.ci }}</td>
                            <td class="px-4 py-3 text-muted-foreground">
                                {{ user.email }}
                            </td>
                            <td class="px-4 py-3">
                                {{ user.role?.nombre || 'Sin rol' }}
                            </td>
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
                                                    <Link :href="edit(user.id)">
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
                                                    @click="deleteUser(user)"
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
                    v-if="users.data.length === 0"
                    class="border-t px-4 py-8 text-center text-muted-foreground"
                >
                    No se encontraron usuarios.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <Button
                    v-for="link in users.links"
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
