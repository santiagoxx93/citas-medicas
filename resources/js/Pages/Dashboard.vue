<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';

// Recibimos solo las citas (Sin gráfico)
defineProps({
    appointments: Array
});

// Helper para formato de fecha
const formatDate = (dateStr) => {
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateStr + 'T00:00:00').toLocaleDateString('es-ES', options);
};

// Función para cancelar
const cancelAppointment = (id) => {
    if (confirm('¿Estás seguro de que deseas cancelar esta cita?')) {
        router.patch(route('appointments.cancel', id));
    }
};

const getStatusColor = (status) => {
    const colors = {
        pending: 'bg-yellow-100 text-yellow-800 border-yellow-200',
        confirmed: 'bg-emerald-100 text-emerald-800 border-emerald-200',
        cancelled: 'bg-red-100 text-red-800 border-red-200',
        completed: 'bg-blue-100 text-blue-800 border-blue-200',
    };
    return colors[status] || 'bg-gray-100';
};
const getStatusLabel = (status) => {
    const labels = { pending: 'Pendiente', confirmed: 'Confirmada', cancelled: 'Cancelada', completed: 'Completada' };
    return labels[status] || status;
};
</script>

<template>
    <Head title="Mis Citas" />

    <AuthenticatedLayout>
        <template #header>
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-2xl shadow-2xl p-6">
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
                    <Link :href="route('appointments.create')" class="hidden sm:flex items-center gap-2 py-3 px-6 text-purple-700 bg-white hover:bg-blue-50 rounded-xl shadow-xl hover:shadow-2xl transition-all font-bold text-sm hover:scale-105 transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Nueva Cita</span>
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Mis Citas Programadas
                    </h3>

                    <div v-if="appointments.length === 0" class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-gray-500 text-lg">Aún no tienes citas registradas.</p>
                        <Link :href="route('appointments.create')" class="text-blue-600 font-bold hover:underline mt-2 inline-block">Agendar ahora</Link>
                    </div>

                    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="cita in appointments" :key="cita.id" 
                             class="bg-white border border-gray-200 rounded-xl hover:shadow-xl transition duration-300 flex flex-col relative overflow-hidden group">
                            
                            <div class="h-2 w-full" :class="{
                                'bg-yellow-400': cita.status === 'pending',
                                'bg-emerald-500': cita.status === 'confirmed',
                                'bg-red-500': cita.status === 'cancelled',
                                'bg-blue-500': cita.status === 'completed'
                            }"></div>

                            <div class="p-6 flex-grow">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="text-center bg-gray-50 p-2 rounded-lg border border-gray-100 min-w-[70px]">
                                        <p class="text-xs font-bold text-gray-500 uppercase">{{ new Date(cita.date).toLocaleString('es-ES', { month: 'short' }) }}</p>
                                        <p class="text-2xl font-black text-gray-800">{{ new Date(cita.date).getDate() }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide border" 
                                          :class="getStatusColor(cita.status)">
                                        {{ getStatusLabel(cita.status) }}
                                    </span>
                                </div>

                                <h4 class="text-lg font-bold text-gray-800 mb-0.5">Dr. {{ cita.doctor.name }}</h4>
                                <p class="text-sm text-indigo-600 font-medium">{{ cita.doctor.specialty || 'Medicina General' }}</p>
                                
                                <div v-if="cita.doctor && cita.doctor.phone" class="flex items-center gap-2 mt-2 mb-3">
                                    <div class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded-md flex items-center gap-1.5 border border-indigo-100">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <span class="text-xs font-bold">{{ cita.doctor.phone }}</span>
                                    </div>
                                </div>
                                <div v-else class="mb-4"></div> <div class="space-y-2 text-sm text-gray-600 border-t pt-3 border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="font-semibold">{{ cita.time.slice(0, 5) }} hrs</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <span class="italic text-gray-500 truncate">"{{ cita.observation || 'Sin observación' }}"</span>
                                    </div>
                                </div>
                            </div>

                            <div v-if="cita.status === 'pending'" class="bg-gray-50 p-4 border-t border-gray-100 flex justify-center">
                                <button @click="cancelAppointment(cita.id)"
                                      class="text-red-600 hover:text-red-800 text-sm font-bold flex items-center gap-1 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Cancelar Cita
                                </button>
                            </div>

                            <!-- (RF_EXTRA) MOSTRAR DIAGNÓSTICO Y RECETA -->
                            <div v-if="cita.diagnosis || cita.prescription" class="bg-blue-50 p-4 border-t border-blue-100">
                                <h5 class="text-sm font-bold text-blue-800 mb-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Resultados de Consulta
                                </h5>
                                <div v-if="cita.diagnosis" class="mb-2">
                                    <p class="text-xs font-semibold text-blue-600 uppercase">Diagnóstico:</p>
                                    <p class="text-sm text-gray-700">{{ cita.diagnosis }}</p>
                                </div>
                                <div v-if="cita.prescription">
                                    <p class="text-xs font-semibold text-blue-600 uppercase">Receta / Indicaciones:</p>
                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ cita.prescription }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <Link :href="route('appointments.create')" class="sm:hidden fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-r from-blue-600 to-pink-600 rounded-full shadow-lg flex items-center justify-center text-white z-50">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            </Link>
        </div>
    </AuthenticatedLayout>
</template>