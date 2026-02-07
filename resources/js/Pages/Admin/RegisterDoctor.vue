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
    phone: '', // <--- CAMPO NUEVO
    specialty: '',
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión de Personal</h2>
        </template>

        <div class="py-8">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">Registrar Especialista</h1>
                            <p class="text-blue-100 text-sm mt-1">Dar de alta a un nuevo médico en el sistema.</p>
                        </div>
                    </div>
                    <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12 transform translate-x-12"></div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-8">
                    
                    <form @submit.prevent="submit" class="space-y-6">
                        
                        <div>
                            <InputLabel for="name" value="Nombre Completo" />
                            <TextInput id="name" type="text" class="mt-1 block w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500" v-model="form.name" required autofocus placeholder="Ej: Dr. Roberto Casas" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div>
                            <InputLabel for="specialty" value="Especialidad Médica" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                </div>
                                <TextInput id="specialty" type="text" class="pl-10 block w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500" v-model="form.specialty" required placeholder="Ej: Cardiología, Pediatría, Medicina General" />
                            </div>
                            <InputError class="mt-2" :message="form.errors.specialty" />
                        </div>

                        <div>
                            <InputLabel for="email" value="Correo Institucional" />
                            <TextInput id="email" type="email" class="mt-1 block w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500" v-model="form.email" required placeholder="doctor@clinica.com" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div>
                            <InputLabel for="phone" value="Teléfono de Contacto" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <TextInput id="phone" type="text" class="pl-10 block w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500" v-model="form.phone" required placeholder="+58 414 0000000" />
                            </div>
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="password" value="Contraseña Temporal" />
                                <TextInput id="password" type="password" class="mt-1 block w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500" v-model="form.password" required />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <div>
                                <InputLabel for="password_confirmation" value="Confirmar Contraseña" />
                                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500" v-model="form.password_confirmation" required />
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-100 mt-6">
                            <PrimaryButton class="ms-4 bg-gradient-to-r from-blue-600 to-purple-600 border-0 hover:from-blue-700 hover:to-purple-700 py-3 px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all" :disabled="form.processing">
                                Registrar Médico
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>