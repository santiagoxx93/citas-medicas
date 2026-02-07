<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    doctors: Array,
    schedules: Array,
    patients: {
        type: Array,
        default: () => []
    } // (RF03) Lista de pacientes para el Admin
});

const form = useForm({
    doctor_id: '',
    date: '',
    time: '',
    reason: '',
    patient_id: '' // (RF03) Campo para el admin
});

// --- 1. LÓGICA DE DOCTOR SELECCIONADO ---
const selectedDoctor = computed(() => {
    return props.doctors.find(doc => doc.id === form.doctor_id);
});

// --- 2. LÓGICA DE FILTRADO DE HORARIO ---
const activeSchedule = computed(() => {
    if (!form.doctor_id || !form.date) return null;
    const dateObj = new Date(form.date + 'T00:00:00'); 
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const dayName = days[dateObj.getDay()];
    return props.schedules.find(s => s.doctor_id === form.doctor_id && s.day_of_week === dayName && s.is_active);
});

// --- 3. GENERADOR DE HORARIOS (Mejora UI: Dropdown AM/PM) ---
const formatTime12h = (time24) => {
    if (!time24) return '';
    const [hours, minutes] = time24.split(':');
    let h = parseInt(hours);
    const m = minutes ? minutes.slice(0, 2) : '00';
    const ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12;
    h = h ? h : 12; // la hora 0 es 12
    return `${h}:${m} ${ampm}`;
};

const availableTimeSlots = computed(() => {
    if (!activeSchedule.value) return [];
    
    const slots = [];
    const start = activeSchedule.value.start_time; // ej: "08:00:00"
    const end = activeSchedule.value.end_time;     // ej: "16:00:00"

    let current = new Date(`2000-01-01T${start}`);
    const endTime = new Date(`2000-01-01T${end}`);

    // Generamos intervalos de 30 min
    while (current < endTime) {
        // Formatear a HH:mm para el value (backend espera 24h)
        const hours = current.getHours().toString().padStart(2, '0');
        const minutes = current.getMinutes().toString().padStart(2, '0');
        const value = `${hours}:${minutes}`;

        // Formatear a AM/PM para el label (frontend muestra bonito)
        const label = formatTime12h(value);

        slots.push({ value, label });

        // Sumar 30 minutos
        current.setMinutes(current.getMinutes() + 30);
    }
    return slots;
});

const availabilityMessage = computed(() => {
    if (!form.doctor_id) return 'Seleccione un especialista primero.';
    if (!form.date) return 'Seleccione una fecha en el calendario.';
    if (activeSchedule.value) {
        return `✅ Disponible: ${formatTime12h(activeSchedule.value.start_time)} - ${formatTime12h(activeSchedule.value.end_time)}`;
    } else {
        return '❌ El doctor no atiende este día.';
    }
});

const submit = () => {
    form.post(route('appointments.store'));
};
</script>

<template>
    <Head title="Agendar Cita" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión de Citas</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                    
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-8 text-white relative overflow-hidden">
                        <div class="relative z-10 flex items-center gap-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold">Reservar Nueva Cita</h1>
                                <p class="text-blue-100 text-sm mt-1">Complete el formulario para agendar su consulta médica.</p>
                            </div>
                        </div>
                        <div class="absolute right-0 top-0 h-full w-1/3 bg-white/10 skew-x-12 transform translate-x-12"></div>
                    </div>

                    <div class="p-8">
                        <form @submit.prevent="submit" class="space-y-8">
                            
                            <!-- (RF03) SELECTOR DE PACIENTE (SOLO VISIBLE SI ERES ADMIN) -->
                            <div v-if="patients && patients.length > 0" class="bg-yellow-50 p-4 rounded-xl border border-yellow-200">
                                <label class="block text-sm font-bold text-yellow-800 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Agendar para Paciente (Modo Admin)
                                </label>
                                <select 
                                    v-model="form.patient_id"
                                    class="w-full px-4 py-3 border-yellow-300 rounded-xl focus:border-yellow-500 focus:ring-yellow-500 transition-all cursor-pointer bg-white"
                                    required
                                >
                                    <option value="" disabled>-- Seleccione el Paciente --</option>
                                    <option v-for="p in patients" :key="p.id" :value="p.id">
                                        {{ p.name }} ({{ p.email }})
                                    </option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Especialista
                                    </label>
                                    <div class="relative">
                                        <select 
                                            v-model="form.doctor_id"
                                            class="w-full pl-4 pr-10 py-3 border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition-all cursor-pointer hover:bg-white"
                                            required
                                        >
                                            <option value="" disabled>-- Seleccione un Doctor --</option>
                                            <option v-for="doc in doctors" :key="doc.id" :value="doc.id">
                                                {{ doc.name }} {{ doc.specialty ? `(${doc.specialty})` : '' }}
                                            </option>
                                        </select>
                                    </div>

                                    <transition enter-active-class="transition ease-out duration-300" enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0">
                                        <div v-if="selectedDoctor" class="mt-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100 flex items-start gap-3">
                                            <div class="bg-indigo-100 p-2 rounded-lg">
                                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-indigo-500 uppercase tracking-wide">Especialidad</p>
                                                <p class="text-gray-900 font-bold text-lg leading-tight">{{ selectedDoctor.specialty || 'Medicina General' }}</p>
                                                
                                                <div class="mt-2 space-y-1">
                                                    <p class="text-xs text-gray-500 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 00-2-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                        {{ selectedDoctor.email }}
                                                    </p>
                                                    <p v-if="selectedDoctor.phone" class="text-xs text-gray-500 flex items-center gap-1 font-semibold">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                        {{ selectedDoctor.phone }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </transition>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Fecha Deseada
                                    </label>
                                    <input 
                                        type="date" 
                                        v-model="form.date"
                                        class="w-full px-4 py-3 border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition-all cursor-pointer"
                                        :min="new Date().toISOString().split('T')[0]" 
                                        required
                                    >
                                    <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0">
                                        <div v-if="form.doctor_id && form.date" class="mt-2 text-sm font-medium flex items-center gap-1" :class="activeSchedule ? 'text-emerald-600' : 'text-red-500'">
                                            <span>{{ availabilityMessage }}</span>
                                        </div>
                                    </transition>
                                </div>
                            </div>

                            <div v-if="activeSchedule" class="bg-blue-50 rounded-xl p-6 border border-blue-100 animate-fade-in-up">
                                <label class="block text-sm font-bold text-blue-800 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Seleccione Hora Disponible
                                </label>
                                <div class="relative">
                                    <select 
                                        v-model="form.time"
                                        class="w-full sm:w-64 px-4 py-3 border-blue-200 rounded-xl focus:border-blue-600 focus:ring-blue-600 text-lg font-semibold text-center text-blue-900 cursor-pointer bg-white"
                                        required
                                    >
                                        <option value="" disabled>-- Seleccionar Hora --</option>
                                        <option v-for="slot in availableTimeSlots" :key="slot.value" :value="slot.value">
                                            {{ slot.label }}
                                        </option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-blue-700">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </div>
                                </div>
                                <p class="text-xs text-blue-600 italic mt-2">
                                    * Horario de atención: {{ formatTime12h(activeSchedule.start_time) }} - {{ formatTime12h(activeSchedule.end_time) }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Motivo de Consulta
                                </label>
                                <textarea 
                                    v-model="form.reason"
                                    rows="3"
                                    class="w-full px-4 py-3 border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition-all resize-none"
                                    placeholder="Describa brevemente sus síntomas..."
                                    required
                                ></textarea>
                            </div>

                            <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                                <button 
                                    type="submit" 
                                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-widest hover:from-blue-700 hover:to-purple-700 focus:outline-none transition ease-in-out duration-150 transform hover:scale-[1.02] shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                    :disabled="form.processing || !activeSchedule"
                                >
                                    {{ form.processing ? 'Procesando...' : 'Confirmar Cita' }}
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.animate-fade-in-up {
    animation: fadeInUp 0.4s ease-out;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>