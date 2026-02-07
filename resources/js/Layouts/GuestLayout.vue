<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-cyan-50">
        
        <!-- Medical Background Image -->
        <div class="absolute inset-0 z-0 opacity-15">
            <img 
                src="https://images.unsplash.com/photo-1631815588090-d4bfec5b1ccb?w=1920&q=80" 
                alt="Medical Background" 
                class="w-full h-full object-cover"
            />
        </div>

        <!-- Light Overlay -->
        <div class="absolute inset-0 bg-white/60 backdrop-blur-sm z-0"></div>

        <!-- Decorative Elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute top-[10%] left-[5%] w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-[20%] right-[10%] w-72 h-72 bg-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-[15%] left-[30%] w-72 h-72 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative z-10 flex flex-col items-center">
            <Link href="/" class="mb-8 transform hover:scale-105 transition-transform duration-300">
                <ApplicationLogo class="w-24 h-24 fill-current text-blue-600 drop-shadow-lg" />
            </Link>

            <div
                class="w-full sm:max-w-md px-8 py-8 bg-white/80 backdrop-blur-lg border border-blue-100 shadow-2xl overflow-hidden sm:rounded-2xl transform transition-all duration-500 hover:shadow-blue-200/50"
            >
                <slot />
            </div>
            
            <p class="mt-4 text-sm text-gray-600">
                &copy; {{ new Date().getFullYear() }} Sistema de Citas Médicas
            </p>
        </div>
    </div>
</template>

<style scoped>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob {
    animation: blob 7s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
