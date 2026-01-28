<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

defineProps({
    appointments: Array
});

// Función para confirmar/cancelar
const updateStatus = (id, newStatus) => {
    const action = newStatus === 'confirmed' ? 'CONFIRMAR' : 'CANCELAR';
    if (confirm(`¿Estás seguro de que deseas ${action} esta cita?`)) {
        router.patch(route('admin.appointments.status', id), { status: newStatus });
    }
};

// Configuración de colores y textos según estado
const getStatusConfig = (status) => {
    const configs = {
        pending: { color: 'bg-yellow-100 text-yellow-800 border-yellow-200', label: 'Pendiente' },
        confirmed: { color: 'bg-emerald-100 text-emerald-800 border-emerald-200', label: 'Confirmada' },
        cancelled: { color: 'bg-red-100 text-red-800 border-red-200', label: 'Cancelada' },
        completed: { color: 'bg-blue-100 text-blue-800 border-blue-200', label: 'Completada' },
    };
    return configs[status] || { color: 'bg-gray-100', label: status };
};

// Funciones para formatear fecha bonita (Ej: 28 ENE)
const getDay = (dateStr) => dateStr.split('-')[2];
const getMonth = (dateStr) => {
    const months = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];
    return months[parseInt(dateStr.split('-')[1]) - 1];
};
</script>

<template>
    <Head title="Agenda Médica" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión de Agenda</h2>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-2">
                            <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h1 class="text-3xl font-bold">Agenda Médica</h1>
                        </div>
                        <p class="text-blue-100 text-lg max-w-2xl">
                            Administra las solicitudes de tus pacientes, confirma asistencias y gestiona tu disponibilidad.
                        </p>
                    </div>
                    <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12 transform translate-x-12"></div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
                            Solicitudes Recientes
                        </h3>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold uppercase tracking-wide">
                            {{ appointments.length }} Registros
                        </span>
                    </div>

                    <div v-if="appointments.length === 0" class="text-center py-12">
                        <div class="bg-gray-50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <p class="text-gray-500 font-medium">No hay citas registradas aún.</p>
                    </div>

                    <div class="space-y-4">
                        <div v-for="cita in appointments" :key="cita.id" 
                             class="group flex flex-col md:flex-row items-center bg-white border border-gray-100 rounded-xl p-4 hover:shadow-md transition-all duration-300 hover:border-blue-200">
                            
                            <div class="flex-shrink-0 mr-0 md:mr-6 mb-4 md:mb-0">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex flex-col items-center justify-center text-white shadow-lg shadow-blue-200">
                                    <span class="text-xs font-bold uppercase tracking-wider opacity-80">{{ getMonth(cita.date) }}</span>
                                    <span class="text-2xl font-extrabold leading-none">{{ getDay(cita.date) }}</span>
                                </div>
                            </div>

                            <div class="flex-grow text-center md:text-left w-full md:w-auto">
                                <div class="flex flex-col md:flex-row md:items-center gap-2 mb-1">
                                    <div class="text-sm font-semibold text-gray-400 flex items-center justify-center md:justify-start gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ cita.time }}
                                    </div>
                                    <span :class="['px-2.5 py-0.5 rounded-full text-xs font-bold border uppercase tracking-wide', getStatusConfig(cita.status).color]">
                                        {{ getStatusConfig(cita.status).label }}
                                    </span>
                                </div>
                                
                                <h4 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                                    {{ cita.patient.name }}
                                </h4>
                                <p class="text-sm text-gray-500 mb-2">{{ cita.patient.email }}</p>
                                
                                <div class="flex items-start justify-center md:justify-start gap-2">
                                    <svg class="w-4 h-4 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="text-sm text-gray-600 italic">"{{ cita.observation || 'Sin motivo especificado' }}"</p>
                                </div>
                            </div>

                            <div class="flex-shrink-0 flex flex-row md:flex-col gap-2 mt-4 md:mt-0 w-full md:w-auto justify-center">
                                
                                <button v-if="cita.status === 'pending'"
                                        @click="updateStatus(cita.id, 'confirmed')"
                                        class="flex items-center justify-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 transition-colors border border-emerald-200 font-semibold text-sm w-full md:w-32">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Confirmar
                                </button>

                                <button v-if="cita.status !== 'cancelled' && cita.status !== 'completed'"
                                        @click="updateStatus(cita.id, 'cancelled')"
                                        class="flex items-center justify-center gap-2 px-4 py-2 bg-white text-red-600 rounded-lg hover:bg-red-50 transition-colors border border-red-200 font-medium text-sm w-full md:w-32">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Cancelar
                                </button>
                                
                                <div v-if="cita.status === 'completed' || cita.status === 'cancelled'" class="text-center md:text-right">
                                    <span class="text-xs text-gray-400">Sin acciones disponibles</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>