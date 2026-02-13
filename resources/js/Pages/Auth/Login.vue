<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Iniciar Sesión" />

        <!-- Contenedor principal con fondo degradado e imagen -->
        <div class="min-h-screen relative bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
            
            <!-- Imagen de fondo con overlay -->
            <div class="absolute inset-0 z-0">
                <!-- Imagen médica profesional desde Unsplash -->
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=1920&q=80')] bg-cover bg-center opacity-15"></div>
                <!-- Overlay con gradiente para mejor legibilidad -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50/95 via-white/95 to-purple-50/95 backdrop-blur-[2px]"></div>
            </div>
            
            <div class="max-w-md mx-auto relative z-10">
                
                <!-- Header decorativo -->
                <div class="text-center mb-8">
                    <div class="relative inline-block mb-6">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 via-purple-400 to-pink-400 rounded-full animate-pulse opacity-20 blur-2xl"></div>
                        <div class="relative w-20 h-20 mx-auto bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-2xl shadow-purple-500/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-4xl font-extrabold bg-gradient-to-r from-blue-700 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                        Bienvenido
                    </h2>
                    <p class="text-gray-600 font-medium text-lg">Ingresa a tu cuenta de San Alfonso</p>
                </div>

                <!-- Mensaje de estado -->
                <div v-if="status" class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-xl shadow-lg backdrop-blur-sm flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="font-semibold">{{ status }}</p>
                </div>

                <!-- Tarjeta del formulario -->
                <div class="bg-white rounded-2xl shadow-2xl border-2 border-gray-100 overflow-hidden">
                    
                    <!-- Barra decorativa superior -->
                    <div class="h-2 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>
                    
                    <div class="p-8">
                        <form @submit.prevent="submit" class="space-y-6">
                            
                            <!-- Email -->
                            <div class="group">
                                <label for="email" class="block font-bold text-sm text-gray-700 mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Correo Electrónico
                                </label>
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="w-full px-4 py-3 border-2 border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 rounded-xl shadow-sm transition-all font-medium"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="tu@email.com"
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <!-- Contraseña -->
                            <div class="group">
                                <label for="password" class="block font-bold text-sm text-gray-700 mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Contraseña
                                </label>
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="w-full px-4 py-3 border-2 border-gray-300 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 rounded-xl shadow-sm transition-all font-medium"
                                    v-model="form.password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <!-- Recordarme -->
                            <div class="flex items-center justify-between w-full">
                                <label class="flex items-center group cursor-pointer">
                                    <Checkbox name="remember" v-model:checked="form.remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" />
                                    <span class="ms-2 text-sm font-medium text-gray-600 group-hover:text-gray-900 transition">Recordarme</span>
                                </label>

                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="text-sm font-bold text-transparent bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text hover:underline text-right ml-4"
                                >
                                    ¿Olvidaste tu contraseña?
                                </Link>
                            </div>

                            <!-- Botón de login -->
                            <div class="pt-2">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    <svg v-else class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>{{ form.processing ? 'Iniciando sesión...' : 'Iniciar Sesión' }}</span>
                                </button>
                            </div>

                            <!-- Enlace a registro -->
                            <div class="text-center pt-4 border-t-2 border-gray-200">
                                <p class="text-gray-600 mb-3">¿No tienes una cuenta?</p>
                                <Link
                                    :href="route('register')"
                                    class="inline-flex items-center gap-2 font-bold text-lg text-transparent bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text hover:underline"
                                >
                                    <span>Crear Cuenta Nueva</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </Link>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-8 text-sm text-gray-500">
                    <p>Centro Médico San Alfonso - Sistema Seguro</p>
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