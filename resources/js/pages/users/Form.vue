<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index, store, update } from '@/routes/users';

type RoleOption = {
    id: number;
    nombre: string;
};

type User = {
    id: number;
    role_id: number | null;
    name: string;
    a_paterno: string | null;
    a_materno: string | null;
    ci: string | null;
    email: string;
};

const props = defineProps<{
    user?: User;
    roles: RoleOption[];
}>();

const pageTitle = props.user ? 'Editar usuario' : 'Nuevo usuario';

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
        <Head :title="pageTitle" />

        <div class="max-w-3xl space-y-6">
            <Heading
                variant="small"
                :title="pageTitle"
                description="Completa los datos del usuario y asigna su rol"
            />

            <Form
                v-bind="user ? update.form(user.id) : store.form()"
                class="grid gap-6 md:grid-cols-2"
                v-slot="{ errors, processing }"
            >
                <div class="grid gap-2">
                    <Label for="name">Nombre</Label>
                    <Input
                        id="name"
                        name="name"
                        :default-value="user?.name"
                        required
                    />
                    <InputError :message="errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="a_paterno">Apellido paterno</Label>
                    <Input
                        id="a_paterno"
                        name="a_paterno"
                        :default-value="user?.a_paterno || ''"
                        required
                    />
                    <InputError :message="errors.a_paterno" />
                </div>

                <div class="grid gap-2">
                    <Label for="a_materno">Apellido materno</Label>
                    <Input
                        id="a_materno"
                        name="a_materno"
                        :default-value="user?.a_materno || ''"
                    />
                    <InputError :message="errors.a_materno" />
                </div>

                <div class="grid gap-2">
                    <Label for="ci">CI</Label>
                    <Input
                        id="ci"
                        name="ci"
                        :default-value="user?.ci || ''"
                        required
                    />
                    <InputError :message="errors.ci" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Correo</Label>
                    <Input
                        id="email"
                        name="email"
                        type="email"
                        :default-value="user?.email"
                        required
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="role_id">Rol</Label>
                    <select
                        id="role_id"
                        name="role_id"
                        class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:cursor-not-allowed disabled:opacity-50"
                        required
                    >
                        <option value="" disabled :selected="!user?.role_id">
                            Selecciona un rol
                        </option>
                        <option
                            v-for="role in roles"
                            :key="role.id"
                            :value="role.id"
                            :selected="role.id === user?.role_id"
                        >
                            {{ role.nombre }}
                        </option>
                    </select>
                    <InputError :message="errors.role_id" />
                </div>

                <div class="grid gap-2 md:col-span-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        name="password"
                        type="password"
                        :required="!user"
                        autocomplete="new-password"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="flex gap-3 md:col-span-2">
                    <Button type="submit" :disabled="processing"> Guardar </Button>
                    <Button variant="outline" as-child>
                        <Link :href="index()">Cancelar</Link>
                    </Button>
                </div>
            </Form>
        </div>
    </div>
</template>
