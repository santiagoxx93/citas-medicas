<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Centro Médico San Alfonso" />

    <div class="bg-gradient-to-br from-blue-50 via-white to-purple-50 text-gray-900 antialiased min-h-screen">
        
        <header class="fixed w-full bg-white/95 backdrop-blur-sm z-50 border-b border-gray-200/50 shadow-sm">
            <nav class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
                <div class="flex items-center justify-between py-4">
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <div class="absolute inset-0 bg-blue-600 rounded-2xl blur opacity-50 group-hover:opacity-75 transition"></div>
                            <div class="relative bg-gradient-to-br from-blue-500 to-blue-600 p-2.5 rounded-2xl shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <span class="text-xl font-bold text-gray-900">San Alfonso</span>
                            <p class="text-xs text-gray-500 font-medium">Centro Médico</p>
                        </div>
                    </a>

                    <div class="flex items-center space-x-4">
                        <Link
                            v-if="canLogin"
                            :href="route('login')"
                            class="hidden sm:block py-2.5 px-6 text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 hover:border-blue-300 rounded-xl shadow-sm hover:shadow-md transition-all font-semibold text-sm"
                        >
                            Iniciar Sesión
                        </Link>
                        
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="py-2.5 px-6 text-white bg-gradient-to-r from-blue-600 to-blue-500 rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all font-semibold text-sm"
                        >
                            Registrarse
                        </Link>
                    </div>
                </div>
            </nav>
        </header>

        <div class="pt-32 md:pt-40 pb-20 relative overflow-hidden">
            <div class="absolute top-20 right-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
            <div class="absolute bottom-20 left-10 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
            
            <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6 relative">
                <div class="grid md:grid-cols-2 items-center gap-12 lg:gap-16">
                    
                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 border border-blue-200/50">
                            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
                            <span class="text-blue-800 font-semibold text-sm">Sistema de Gestión de Citas Médicas</span>
                        </div>
                        
                        <h1 class="text-5xl md:text-6xl xl:text-7xl font-extrabold text-gray-900 leading-tight">
                            Tu salud en
                            <span class="block mt-2 bg-gradient-to-r from-blue-600 via-blue-500 to-purple-600 bg-clip-text text-transparent">
                                las mejores manos
                            </span>
                        </h1>
                        
                        <p class="text-xl text-gray-600 max-w-xl leading-relaxed">
                            Centro Integral de Reflexología Podal y Medicina General. Agenda tus citas en línea de forma rápida, segura y sin complicaciones.
                        </p>
                        
                        <div class="flex flex-wrap gap-4 pt-4">
                            <Link
                                v-if="canLogin"
                                :href="route('login')"
                                class="py-4 px-8 text-gray-700 bg-white hover:bg-gray-50 rounded-xl border-2 border-gray-300 hover:border-blue-300 transition-all font-bold text-lg shadow-lg"
                            >
                                Iniciar Sesión
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="group py-4 px-8 text-white bg-gradient-to-r from-blue-600 to-blue-500 rounded-xl shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:shadow-blue-500/40 transition-all font-bold text-lg flex items-center gap-3"
                            >
                                <span>Agendar Cita Ahora</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 group-hover:translate-x-1 transition-transform">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </Link>
                        </div>

                        <div class="grid grid-cols-3 gap-6 pt-8">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600">500+</div>
                                <div class="text-sm text-gray-600 font-medium mt-1">Pacientes</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-purple-600">15+</div>
                                <div class="text-sm text-gray-600 font-medium mt-1">Especialistas</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600">98%</div>
                                <div class="text-sm text-gray-600 font-medium mt-1">Satisfacción</div>
                            </div>
                        </div>
                    </div>

                    <div class="hidden md:block relative">
                        <div class="relative">
                            <div class="relative h-[600px] rounded-3xl overflow-hidden shadow-2xl group">
                                
                                <img src="/img/doctores.png" alt="Equipo Médico" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>
                                
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 to-purple-900/80 mix-blend-multiply"></div>
                                
                                <div class="absolute inset-0 flex items-center justify-center p-8 z-10">
                                    <div class="text-center text-white">
                                        <div class="w-32 h-32 mx-auto mb-6 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center shadow-xl border border-white/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold mb-3 drop-shadow-md">Atención de Calidad</h3>
                                        <p class="text-white/90 text-lg max-w-md drop-shadow-sm">Profesionales certificados dedicados a tu bienestar</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="absolute -right-6 -top-12 bg-white rounded-2xl shadow-2xl p-6 max-w-xs animate-pulse z-20">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">Cita Confirmada</p>
                                        <p class="text-xs text-gray-500 mt-1">Dr. García - 10:00 AM</p>
                                    </div>
                                </div>
                            </div>
                            </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="py-20 bg-white/50">
            <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                        ¿Por qué elegir <span class="text-blue-600">San Alfonso</span>?
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Ofrecemos un servicio integral con tecnología de última generación
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Agenda Online 24/7</h3>
                        <p class="text-gray-600 leading-relaxed">Reserva tus citas en cualquier momento desde la comodidad de tu hogar</p>
                    </div>

                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Equipo Profesional</h3>
                        <p class="text-gray-600 leading-relaxed">Médicos especializados y certificados comprometidos con tu salud</p>
                    </div>

                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-green-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Atención Garantizada</h3>
                        <p class="text-gray-600 leading-relaxed">Seguimiento personalizado y control de tu historial médico</p>
                    </div>
                </div>
            </div>
        </div>

        <footer class="py-12 bg-gradient-to-br from-gray-900 to-gray-800 text-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid md:grid-cols-4 gap-8 mb-8">
                    <div class="md:col-span-2">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-2.5 rounded-2xl shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xl font-bold">San Alfonso</span>
                                <p class="text-sm text-gray-400">Centro Médico</p>
                            </div>
                        </div>
                        <p class="text-gray-400 leading-relaxed max-w-md">
                            Centro Integral de Reflexología Podal y Medicina General dedicado a tu bienestar y salud.
                        </p>
                    </div>
                    
                    <div>
                        <h4 class="font-bold mb-4">Enlaces Rápidos</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-blue-400 transition">Servicios</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition">Nosotros</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition">Especialistas</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition">Contacto</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-bold mb-4">Legal</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-blue-400 transition">Privacidad</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition">Términos</a></li>
                            <li><a href="#" class="hover:text-blue-400 transition">Cookies</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 pt-8 text-center text-gray-400 text-sm">
                    <p>© 2026 Centro Integral de Reflexología Podal San Alfonso, C.A. · UTS-Ampliación Charallave</p>
                    <p class="mt-1">Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>

    </div>
</template>

<style scoped>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}
</style>