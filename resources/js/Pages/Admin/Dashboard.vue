<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import BarChart from '@/Components/BarChart.vue';
import PieChart from '@/Components/PieChart.vue'; // <--- NUEVO: Importamos el gráfico de torta

// Recibimos las estadísticas y datos del gráfico
defineProps({
    stats: Object,
    chartData: Object
});
</script>

<template>
    <Head title="Panel de Control" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Resumen Ejecutivo</h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                
                <div class="bg-gradient-to-r from-blue-700 to-indigo-600 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <h1 class="text-3xl font-bold">Panel Médico</h1>
                            <p class="text-blue-100 text-lg mt-1">
                                Bienvenido, {{ $page.props.auth.user.name }}. Aquí tienes el estado actual de la clínica.
                            </p>
                        </div>
                        <div class="bg-white/10 p-4 rounded-xl backdrop-blur-sm border border-white/10">
                            <p class="text-xs text-blue-200 uppercase tracking-wider font-bold">Citas para Hoy</p>
                            <p class="text-3xl font-bold">{{ stats.today }}</p>
                        </div>
                    </div>
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-50 flex items-center gap-4 transition hover:scale-105 duration-300">
                        <div class="p-4 bg-blue-50 rounded-xl text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-bold uppercase">Total Citas</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ stats.total }}</h3>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-50 flex items-center gap-4 transition hover:scale-105 duration-300">
                        <div class="p-4 bg-yellow-50 rounded-xl text-yellow-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-bold uppercase">Pendientes</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ stats.pending }}</h3>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-50 flex items-center gap-4 transition hover:scale-105 duration-300">
                        <div class="p-4 bg-emerald-50 rounded-xl text-emerald-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-bold uppercase">Confirmadas</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ stats.confirmed }}</h3>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-50 flex items-center gap-4 transition hover:scale-105 duration-300">
                        <div class="p-4 bg-red-50 rounded-xl text-red-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-bold uppercase">Canceladas</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ stats.cancelled }}</h3>
                        </div>
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-700 flex items-center gap-2">
                                <span class="w-2 h-6 bg-blue-500 rounded-full"></span>
                                Volumen de Citas
                            </h3>
                        </div>
                        <div class="h-80 w-full">
                            <BarChart v-if="chartData" :chartData="chartData" />
                            <div v-else class="h-full flex items-center justify-center text-gray-400">
                                Cargando datos del gráfico...
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-700 flex items-center gap-2">
                                <span class="w-2 h-6 bg-purple-500 rounded-full"></span>
                                Distribución por Estado
                            </h3>
                        </div>
                        <div class="h-80 w-full">
                            <PieChart v-if="chartData" :chartData="chartData" />
                            <div v-else class="h-full flex items-center justify-center text-gray-400">
                                Cargando datos del gráfico...
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>