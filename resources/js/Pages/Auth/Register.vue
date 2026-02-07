<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    phone: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Registro" />

        <!-- Contenedor principal con fondo degradado -->
        <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto">
                
                <!-- Header decorativo -->
                <div class="text-center mb-8">
                    <div class="relative inline-block mb-6">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 via-purple-400 to-pink-400 rounded-full animate-pulse opacity-20 blur-2xl"></div>
                        <div class="relative w-20 h-20 mx-auto bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-2xl shadow-purple-500/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-extrabold bg-gradient-to-r from-blue-700 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                        Crear Cuenta
                    </h2>
                    <p class="text-gray-600 font-medium">Únete a Centro Médico San Alfonso</p>
                </div>

                <!-- Tarjeta del formulario -->
                <div class="bg-white rounded-2xl shadow-2xl border-2 border-gray-100 overflow-hidden">
                    
                    <!-- Barra decorativa superior -->
                    <div class="h-2 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>
                    
                    <div class="p-8">
                        <form @submit.prevent="submit" class="space-y-6">
                            
                            <!-- Nombre completo -->
                            <div class="group">
                                <label for="name" class="block font-bold text-sm text-gray-700 mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Nombre Completo
                                </label>
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="w-full px-4 py-3 border-2 border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 rounded-xl shadow-sm transition-all font-medium"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    placeholder="Ingresa tu nombre completo"
                                />
                                <InputError class="mt-2 text-red-600 text-sm font-semibold flex items-center gap-1" :message="form.errors.name">
                                    <svg v-if="form.errors.name" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </InputError>
                            </div>

                            <!-- Email -->
                            <div class="group">
                                <label for="email" class="block font-bold text-sm text-gray-700 mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Correo Electrónico
                                </label>
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="w-full px-4 py-3 border-2 border-gray-300 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 rounded-xl shadow-sm transition-all font-medium"
                                    v-model="form.email"
                                    required
                                    autocomplete="username"
                                    placeholder="tu@email.com"
                                />
                                <InputError class="mt-2 text-red-600 text-sm font-semibold flex items-center gap-1" :message="form.errors.email">
                                    <svg v-if="form.errors.email" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </InputError>
                            </div>

                            <!-- Teléfono -->
                            <div class="group">
                                <label for="phone" class="block font-bold text-sm text-gray-700 mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    Teléfono
                                </label>
                                <TextInput
                                    id="phone"
                                    type="text"
                                    class="w-full px-4 py-3 border-2 border-gray-300 focus:border-pink-500 focus:ring-4 focus:ring-pink-100 rounded-xl shadow-sm transition-all font-medium"
                                    v-model="form.phone"
                                    required
                                    placeholder="+58 412 1234567"
                                    autocomplete="tel"
                                />
                                <InputError class="mt-2 text-red-600 text-sm font-semibold flex items-center gap-1" :message="form.errors.phone">
                                    <svg v-if="form.errors.phone" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </InputError>
                            </div>

                            <!-- Contraseña -->
                            <div class="group">
                                <label for="password" class="block font-bold text-sm text-gray-700 mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Contraseña
                                </label>
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="w-full px-4 py-3 border-2 border-gray-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 rounded-xl shadow-sm transition-all font-medium"
                                    v-model="form.password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Mínimo 8 caracteres"
                                />
                                <InputError class="mt-2 text-red-600 text-sm font-semibold flex items-center gap-1" :message="form.errors.password">
                                    <svg v-if="form.errors.password" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </InputError>
                            </div>

                            <!-- Confirmar contraseña -->
                            <div class="group">
                                <label for="password_confirmation" class="block font-bold text-sm text-gray-700 mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Confirmar Contraseña
                                </label>
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="w-full px-4 py-3 border-2 border-gray-300 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100 rounded-xl shadow-sm transition-all font-medium"
                                    v-model="form.password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Repite tu contraseña"
                                />
                                <InputError class="mt-2 text-red-600 text-sm font-semibold flex items-center gap-1" :message="form.errors.password_confirmation">
                                    <svg v-if="form.errors.password_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </InputError>
                            </div>

                            <!-- Botón de registro -->
                            <div class="pt-4">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    :class="[
                                        'w-full flex items-center justify-center gap-3 py-4 px-8 text-white font-bold text-lg rounded-xl shadow-2xl transition-all transform',
                                        form.processing 
                                            ? 'bg-gray-400 cursor-not-allowed' 
                                            : 'bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:shadow-purple-500/50 hover:scale-105'
                                    ]"
                                >
                                    <svg v-if="!form.processing" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                    <svg v-else class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>{{ form.processing ? 'Creando cuenta...' : 'Crear Cuenta' }}</span>
                                </button>
                            </div>

                            <!-- Enlace a login -->
                            <div class="text-center pt-4 border-t border-gray-200">
                                <p class="text-gray-600 mb-2">¿Ya tienes una cuenta?</p>
                                <Link
                                    :href="route('login')"
                                    class="inline-flex items-center gap-2 font-bold text-transparent bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text hover:underline"
                                >
                                    <span>Iniciar Sesión</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </Link>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-8 text-sm text-gray-500">
                    <p>Al registrarte, aceptas nuestros términos y condiciones</p>
                </div>

            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
@keyframes spin {
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>