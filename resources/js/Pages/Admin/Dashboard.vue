<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3'; // Ya no necesitamos Link
import BarChart from '@/Components/BarChart.vue';

// Solo recibimos datos visuales
defineProps({
    stats: Object,
    chartData: Object
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Administrativo</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div v-if="$page.props.flash?.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ $page.props.flash.success }}
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                        <div class="text-gray-500 text-sm font-medium uppercase">Citas para Hoy</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">{{ stats.today }}</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-400">
                        <div class="text-gray-500 text-sm font-medium uppercase">Pendientes</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">{{ stats.pending }}</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-emerald-500">
                        <div class="text-gray-500 text-sm font-medium uppercase">Confirmadas</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">{{ stats.confirmed }}</div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-gray-500">
                        <div class="text-gray-500 text-sm font-medium uppercase">Total Histórico</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">{{ stats.total }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-700">Resumen Visual</h3>
                    <div class="h-64">
                        <BarChart v-if="chartData" :chartData="chartData" />
                        <p v-else class="text-gray-500 text-center py-10">Cargando...</p>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>