<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { index, store, update } from '@/routes/roles';

type Role = {
    id: number;
    nombre: string;
    descripcion: string | null;
};

const props = defineProps<{
    role?: Role;
}>();

const pageTitle = props.role ? 'Editar rol' : 'Nuevo rol';

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
        <Head :title="pageTitle" />

        <div class="max-w-2xl space-y-6">
            <Heading
                variant="small"
                :title="pageTitle"
                description="Completa los datos del rol"
            />

            <Form
                v-bind="role ? update.form(role.id) : store.form()"
                class="space-y-6"
                v-slot="{ errors, processing }"
            >
                <div class="grid gap-2">
                    <Label for="nombre">Nombre</Label>
                    <Input
                        id="nombre"
                        name="nombre"
                        :default-value="role?.nombre"
                        required
                    />
                    <InputError :message="errors.nombre" />
                </div>

                <div class="grid gap-2">
                    <Label for="descripcion">Descripcion</Label>
                    <Input
                        id="descripcion"
                        name="descripcion"
                        :default-value="role?.descripcion || ''"
                    />
                    <InputError :message="errors.descripcion" />
                </div>

                <div class="flex gap-3">
                    <Button type="submit" :disabled="processing"> Guardar </Button>
                    <Button variant="outline" as-child>
                        <Link :href="index()">Cancelar</Link>
                    </Button>
                </div>
            </Form>
        </div>
    </div>
</template>
