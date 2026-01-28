<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('admin.doctors.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Registrar Médico" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar Nuevo Especialista</h2>
        </template>

        <div class="py-12">
            <div class="max-w-md mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-500">
                    
                    <p class="mb-6 text-gray-600 text-sm">
                        Ingrese los datos del nuevo médico. Este usuario tendrá acceso inmediato al Panel de Agenda.
                    </p>

                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Nombre Completo" />
                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus placeholder="Ej: Dr. Roberto Casas" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="email" value="Correo Institucional" />
                            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required placeholder="doctor@clinica.com" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="password" value="Contraseña Temporal" />
                            <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="password_confirmation" value="Confirmar Contraseña" />
                            <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <PrimaryButton class="ms-4 bg-blue-600 hover:bg-blue-700" :disabled="form.processing">
                                Registrar Médico
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>