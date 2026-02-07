<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    schedules: Array,
    doctors: Array,
    selectedDoctorId: [Number, String],
    isAdmin: Boolean
});

const currentDoctor = ref(props.selectedDoctorId || '');

const form = useForm({
    schedules: props.schedules
});

// Recargar página al cambiar de doctor
const onDoctorChange = () => {
    if (currentDoctor.value) {
        router.get(route('admin.schedules.edit'), { doctor_id: currentDoctor.value }, {
            preserveState: true,
            preserveScroll: true
        });
    }
};

watch(() => props.schedules, (newSchedules) => {
    form.schedules = newSchedules;
});

const submit = () => {
    form.post(route('admin.schedules.update'));
};

// Función auxiliar para nombres de día
const getDayName = (day) => {
    const names = { Monday: 'Lunes', Tuesday: 'Martes', Wednesday: 'Miércoles', Thursday: 'Jueves', Friday: 'Viernes', Saturday: 'Sábado', Sunday: 'Domingo' };
    return names[day] || day;
};
</script>

<template>
    <Head title="Configurar Horarios" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión de Disponibilidad</h2>
        </template>

        <div class="py-8">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">Horarios de Atención</h1>
                            <p class="text-blue-100 text-sm mt-1">Define los días y horas en que se pueden agendar citas.</p>
                        </div>
                    </div>
                    <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12 transform translate-x-12"></div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-8">

                    <div v-if="isAdmin" class="mb-8">
                        <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Seleccionar Médico para Editar:
                        </label>
                        <div class="relative">
                            <select 
                                v-model="currentDoctor" 
                                @change="onDoctorChange"
                                class="w-full pl-4 pr-10 py-3 border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition-all cursor-pointer text-gray-700 font-medium shadow-sm"
                            >
                                <option value="" disabled>-- Elegir Especialista --</option>
                                <option v-for="doc in doctors" :key="doc.id" :value="doc.id">
                                    {{ doc.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <form v-if="form.schedules.length > 0" @submit.prevent="submit" class="space-y-6">
                        
                        <div class="flex items-center justify-between border-b pb-4 mb-6">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-purple-500 rounded-full"></span>
                                Configuración Semanal
                            </h3>
                            <span class="text-sm text-gray-500">Ajusta los interruptores y horas.</span>
                        </div>

                        <div class="space-y-4">
                            <div v-for="(day, index) in form.schedules" :key="day.id" 
                                 class="group flex flex-col md:flex-row items-center gap-4 bg-white border border-gray-100 p-4 rounded-xl transition-all duration-300 hover:shadow-md hover:border-blue-200"
                                 :class="!day.is_active ? 'bg-gray-50 opacity-75' : ''"
                            >
                                
                                <div class="flex items-center justify-between w-full md:w-1/3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white shadow-sm"
                                             :class="day.is_active ? 'bg-gradient-to-br from-blue-500 to-purple-600' : 'bg-gray-300'">
                                            {{ getDayName(day.day_of_week).charAt(0) }}
                                        </div>
                                        <span class="text-lg font-bold text-gray-800">{{ getDayName(day.day_of_week) }}</span>
                                    </div>
                                    
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" v-model="day.is_active" class="sr-only peer" :true-value="1" :false-value="0">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>

                                <div class="flex items-center gap-4 w-full md:w-2/3 justify-end">
                                    <div class="flex flex-col">
                                        <label class="text-xs font-bold text-gray-500 mb-1 uppercase">Entrada</label>
                                        <input type="time" v-model="day.start_time" :disabled="!day.is_active"
                                               class="px-3 py-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 font-semibold text-gray-700 disabled:bg-gray-100 disabled:text-gray-400 transition-all">
                                    </div>
                                    
                                    <span class="text-gray-400 font-bold text-xl mt-5">→</span>

                                    <div class="flex flex-col">
                                        <label class="text-xs font-bold text-gray-500 mb-1 uppercase">Salida</label>
                                        <input type="time" v-model="day.end_time" :disabled="!day.is_active"
                                               class="px-3 py-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 font-semibold text-gray-700 disabled:bg-gray-100 disabled:text-gray-400 transition-all">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="flex justify-end pt-6 mt-6 border-t border-gray-100">
                            <button type="submit" 
                                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-widest hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-[1.02] shadow-lg disabled:opacity-50"
                                    :disabled="form.processing">
                                {{ form.processing ? 'Guardando...' : 'Guardar Cambios' }}
                            </button>
                        </div>

                    </form>

                    <div v-else-if="isAdmin && !currentDoctor" class="text-center py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <p class="text-gray-500 text-lg font-medium">Seleccione un médico arriba para comenzar.</p>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>