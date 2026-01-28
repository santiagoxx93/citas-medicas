<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    schedules: Array
});

// Inicializamos el formulario con los datos que vienen de la BD
const form = useForm({
    schedules: props.schedules
});

const submit = () => {
    form.post(route('admin.schedules.update'), {
        onSuccess: () => alert('Horarios guardados correctamente'),
    });
};
</script>

<template>
    <Head title="Configurar Horarios" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mi Disponibilidad Semanal</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    
                    <form @submit.prevent="submit">
                        <table class="min-w-full divide-y divide-gray-200 mb-6">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Día</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Hora Inicio</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Hora Fin</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="(day, index) in form.schedules" :key="day.id">
                                    
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ 
                                            day.day_of_week === 'Monday' ? 'Lunes' :
                                            day.day_of_week === 'Tuesday' ? 'Martes' :
                                            day.day_of_week === 'Wednesday' ? 'Miércoles' :
                                            day.day_of_week === 'Thursday' ? 'Jueves' :
                                            day.day_of_week === 'Friday' ? 'Viernes' : day.day_of_week
                                        }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" v-model="day.is_active" 
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                                   :true-value="1" :false-value="0">
                                            <span class="ml-2 text-sm text-gray-600">
                                                {{ day.is_active ? 'Trabajable' : 'Descanso' }}
                                            </span>
                                        </label>
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="time" v-model="day.start_time" 
                                               :disabled="!day.is_active"
                                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    </td>

                                    <td class="px-6 py-4">
                                        <input type="time" v-model="day.end_time" 
                                               :disabled="!day.is_active"
                                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-bold shadow-md transition"
                                    :disabled="form.processing">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>