<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

// Recibimos la lista de citas
defineProps({
    appointments: Array
});

// Función para cancelar (RF-04)
const cancelAppointment = (id) => {
    if (confirm('¿Estás seguro de que deseas cancelar esta cita?')) {
        router.patch(route('appointments.cancel', id));
    }
};

const getStatusColor = (status) => {
    const colors = {
        pending: 'bg-gradient-to-r from-yellow-100 to-yellow-50 text-yellow-800 border border-yellow-200',
        confirmed: 'bg-gradient-to-r from-green-100 to-green-50 text-green-800 border border-green-200',
        cancelled: 'bg-gradient-to-r from-red-100 to-red-50 text-red-800 border border-red-200',
        completed: 'bg-gradient-to-r from-gray-100 to-gray-50 text-gray-800 border border-gray-200',
    };
    return colors[status] || 'bg-gray-100';
};

const getStatusIcon = (status) => {
    const icons = {
        pending: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>`,
        confirmed: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>`,
        cancelled: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>`,
        completed: `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>`
    };
    return icons[status] || '';
};

const getStatusText = (status) => {
    const texts = {
        pending: 'Pendiente',
        confirmed: 'Confirmada',
        cancelled: 'Cancelada',
        completed: 'Completada'
    };
    return texts[status] || status;
};
</script>

<template>
    <Head title="Mis Citas" />

    <AuthenticatedLayout>
        <template #header>
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-2xl shadow-2xl p-6">
                <!-- Elementos decorativos -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20 blur-2xl"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-16 -mb-16 blur-2xl"></div>
                
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-xl border border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-extrabold text-2xl md:text-3xl text-white drop-shadow-lg">Mis Citas Médicas</h2>
                            <p class="text-blue-100 text-sm font-medium mt-0.5">Gestiona tu agenda de salud</p>
                        </div>
                    </div>
                    <a :href="route('appointments.create')" class="hidden sm:flex items-center gap-2 py-3 px-6 text-purple-700 bg-white hover:bg-blue-50 rounded-xl shadow-xl hover:shadow-2xl transition-all font-bold text-sm hover:scale-105 transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Nueva Cita</span>
                    </a>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <!-- Notificaciones Flash -->
                <div v-if="$page.props.flash?.success" class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-xl shadow-lg backdrop-blur-sm flex items-start gap-3 animate-slide-in">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-semibold">¡Éxito!</p>
                        <p class="text-sm">{{ $page.props.flash.success }}</p>
                    </div>
                </div>
                
                <div v-if="$page.props.flash?.error" class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-xl shadow-lg backdrop-blur-sm flex items-start gap-3 animate-slide-in">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-semibold">Error</p>
                        <p class="text-sm">{{ $page.props.flash.error }}</p>
                    </div>
                </div>

                <!-- Tarjeta Principal -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                    
                    <!-- Header de la tarjeta -->
                    <div class="relative overflow-hidden bg-gradient-to-r from-cyan-50 via-blue-50 to-purple-50 px-6 py-6 border-b-2 border-blue-200">
                        <!-- Patrón decorativo -->
                        <div class="absolute inset-0 opacity-30" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMzYjgyZjYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzBoLTJ2LTJoMnYyem0tNiAwdi0yaDJ2Mmgtem0tNiAwdi0yaDJ2MmgtMnoiLz48L2c+PC9nPjwvc3ZnPg==');"></div>
                        
                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/40 transform hover:rotate-6 transition-transform">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-extrabold bg-gradient-to-r from-blue-700 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                                        Mis Próximas Consultas
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1 font-medium">Gestiona y revisa tus citas programadas</p>
                                </div>
                            </div>
                            <div class="hidden md:flex items-center gap-2 px-5 py-3 bg-white rounded-xl shadow-md border-2 border-blue-200">
                                <div class="w-2.5 h-2.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full animate-pulse"></div>
                                <span class="text-sm font-bold bg-gradient-to-r from-blue-700 to-purple-700 bg-clip-text text-transparent">
                                    {{ appointments?.length || 0 }} citas
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Contenido -->
                    <div class="p-6">
                        <!-- Lista de citas en cards (móvil-amigable) -->
                        <div v-if="appointments && appointments.length > 0" class="space-y-4">
                            <div v-for="cita in appointments" :key="cita.id" 
                                 class="group relative bg-gradient-to-br from-white via-blue-50/30 to-purple-50/30 rounded-2xl border-2 border-transparent hover:border-blue-400 p-6 transition-all duration-300 hover:shadow-2xl overflow-hidden">
                                
                                <!-- Efecto de brillo en hover -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform -skew-x-12 group-hover:translate-x-full" style="transition: transform 0.8s;"></div>
                                
                                <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    
                                    <!-- Columna izquierda: Fecha y hora -->
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-2xl flex flex-col items-center justify-center text-white shadow-xl shadow-purple-500/40 transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                            <span class="text-xs font-bold uppercase tracking-wide">{{ new Date(cita.date).toLocaleDateString('es', { month: 'short' }) }}</span>
                                            <span class="text-2xl font-extrabold">{{ new Date(cita.date).getDate() }}</span>
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span class="text-lg font-bold text-gray-900">{{ cita.time }}</span>
                                            </div>
                                            
                                            <div class="flex items-center gap-2 mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span class="font-semibold text-gray-900">
                                                    {{ cita.doctor ? 'Dr. ' + cita.doctor.name : 'Sin asignar' }}
                                                </span>
                                            </div>
                                            
                                            <div class="flex items-start gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="text-sm text-gray-600 leading-relaxed">
                                                    {{ cita.observation || 'Sin observaciones' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Columna derecha: Estado y acciones -->
                                    <div class="flex flex-col items-end gap-3 md:ml-4">
                                        <span :class="['px-4 py-2 inline-flex items-center gap-2 text-sm font-bold rounded-xl shadow-sm', getStatusColor(cita.status)]">
                                            <span v-html="getStatusIcon(cita.status)"></span>
                                            {{ getStatusText(cita.status) }}
                                        </span>
                                        
                                        <button v-if="cita.status !== 'cancelled' && cita.status !== 'completed'"
                                                @click="cancelAppointment(cita.id)"
                                                class="group/btn flex items-center gap-2 px-4 py-2 text-red-600 hover:text-white bg-red-50 hover:bg-red-600 border-2 border-red-200 hover:border-red-600 rounded-xl font-bold transition-all duration-300 shadow-sm hover:shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            <span>Cancelar Cita</span>
                                        </button>
                                        
                                        <span v-else class="text-gray-400 text-sm italic px-4 py-2">
                                            No disponible
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Estado vacío -->
                        <div v-else class="text-center py-16">
                            <div class="relative w-32 h-32 mx-auto mb-6">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-400 via-purple-400 to-pink-400 rounded-full animate-pulse opacity-20 blur-2xl"></div>
                                <div class="relative w-32 h-32 bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 rounded-full flex items-center justify-center shadow-xl border-4 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-2xl font-extrabold bg-gradient-to-r from-blue-700 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-3">
                                No tienes citas agendadas
                            </h3>
                            <p class="text-gray-600 mb-8 text-lg">Comienza a gestionar tu salud agendando tu primera consulta</p>
                            <a :href="route('appointments.create')" class="inline-flex items-center gap-3 py-4 px-10 text-white bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-xl shadow-2xl shadow-purple-500/40 hover:shadow-2xl hover:shadow-purple-500/60 transition-all font-bold text-lg hover:scale-105 transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Agendar Primera Cita</span>
                            </a>
                        </div>

                    </div>
                </div>

                <!-- Botón flotante móvil -->
                <a :href="route('appointments.create')" class="sm:hidden fixed bottom-6 right-6 w-16 h-16 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-full shadow-2xl shadow-purple-500/60 flex items-center justify-center text-white hover:scale-110 transition-transform z-50 animate-bounce-slow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                </a>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@keyframes slide-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce-slow {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.animate-slide-in {
    animation: slide-in 0.3s ease-out;
}

.animate-bounce-slow {
    animation: bounce-slow 2s ease-in-out infinite;
}
</style>