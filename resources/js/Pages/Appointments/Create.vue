<script setup>
import { ref, computed } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
    schedules: Array,
})

const selectedSchedule = ref(null)

const form = useForm({
    date: '',
    time: '',
    doctor_id: '',
    observation: '',
})

/* ====== CALENDARIO 7 DÍAS ====== */
const today = new Date()
const days = [...Array(7)].map((_, i) => {
    const d = new Date()
    d.setDate(today.getDate() + i)
    return d
})

const selectDate = (day) => {
    form.date = day.toISOString().split('T')[0]
}

/* ====== HORAS ====== */
const availableHours = computed(() => {
    if (!selectedSchedule.value) return []

    const start = parseInt(selectedSchedule.value.start_time.split(':')[0])
    const end = parseInt(selectedSchedule.value.end_time.split(':')[0])

    return Array.from({ length: end - start }, (_, i) => `${start + i}:00`)
})

const submit = () => {
    form.post(route('appointments.store'), {
        onSuccess: () => {
            form.reset()
            selectedSchedule.value = null
        },
    })
}
</script>

<template>
    <Head title="Agendar Cita" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold text-gray-800">
                Nueva Cita Médica
            </h2>
        </template>

        <div class="min-h-screen bg-gray-50 py-10">
            <div class="max-w-7xl mx-auto px-6 space-y-8">

                <!-- HERO -->
                <div
                    class="rounded-xl p-6 text-white shadow bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                    <h3 class="text-2xl font-bold">Agenda tu consulta</h3>
                    <p class="opacity-90">Selecciona fecha, doctor y horario</p>
                </div>

                <!-- FECHA -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-semibold mb-4 text-gray-700">
                        Selecciona una fecha
                    </h3>

                    <div class="grid grid-cols-7 gap-3">
                        <button
                            v-for="day in days"
                            :key="day"
                            @click="selectDate(day)"
                            class="border rounded-lg p-3 text-center transition hover:border-indigo-500"
                            :class="form.date === day.toISOString().split('T')[0]
                                ? 'bg-indigo-500 text-white border-indigo-500'
                                : 'bg-white text-gray-700'"
                        >
                            <div class="text-sm capitalize">
                                {{ day.toLocaleDateString('es', { weekday: 'short' }) }}
                            </div>
                            <div class="font-bold">
                                {{ day.getDate() }}
                            </div>
                        </button>
                    </div>
                </div>

                <!-- DOCTOR -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-semibold mb-4 text-gray-700">
                        Doctor y horario
                    </h3>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div
                            v-for="schedule in schedules"
                            :key="schedule.id"
                            @click="() => {
                                selectedSchedule = schedule
                                form.doctor_id = schedule.doctor.id
                            }"
                            class="border rounded-lg p-4 cursor-pointer transition hover:shadow-md"
                            :class="selectedSchedule?.id === schedule.id
                                ? 'border-indigo-500 bg-indigo-50'
                                : 'bg-white'"
                        >
                            <div class="font-semibold text-indigo-600">
                                Dr. {{ schedule.doctor.name }}
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ schedule.day_of_week }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ schedule.start_time }} - {{ schedule.end_time }}
                            </div>
                        </div>
                    </div>

                    <!-- HORAS -->
                    <div v-if="availableHours.length" class="mt-6">
                        <h4 class="font-semibold mb-2 text-gray-700">
                            Hora disponible
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            <button
                                v-for="hour in availableHours"
                                :key="hour"
                                @click="form.time = hour"
                                class="px-4 py-2 rounded-md border transition"
                                :class="form.time === hour
                                    ? 'bg-indigo-500 text-white border-indigo-500'
                                    : 'bg-white hover:border-indigo-400'"
                            >
                                {{ hour }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- MOTIVO -->
                <div class="bg-white rounded-xl shadow p-6 max-w-xl">
                    <h3 class="font-semibold mb-3 text-gray-700">
                        Motivo de la consulta
                    </h3>

                    <textarea
                        v-model="form.observation"
                        rows="4"
                        class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Describe brevemente el motivo..."
                    />
                </div>

                <!-- BOTÓN -->
                <button
                    @click="submit"
                    :disabled="form.processing"
                    class="w-full max-w-xl text-white font-semibold py-3 rounded-lg shadow bg-gradient-to-r from-indigo-500 to-pink-500 hover:opacity-90 transition disabled:opacity-50"
                >
                    Confirmar Cita
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
