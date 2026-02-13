<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;      // <--- ESTA LÍNEA FALTABA
use App\Models\Schedule;  // <--- ESTA TAMBIÉN ES IMPORTANTE
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    /**
     * Muestra el formulario para crear una nueva cita.
     */
    public function create()
    {
        // 1. Obtenemos todos los doctores
        $doctors = User::where('role', 'doctor')->get();

        // 2. Obtenemos todos los horarios activos para filtrar en el frontend
        $schedules = Schedule::where('is_active', true)->get();

        // 3. (RF03) Si es Admin, obtenemos los pacientes para que pueda seleccionar por quién agenda
        $patients = [];
        if (auth()->user()->role === 'admin') {
            $patients = User::where('role', 'patient')->get();
        }

        return Inertia::render('Appointments/Create', [
            'doctors' => $doctors,
            'schedules' => $schedules,
            'patients' => $patients // Pasamos la lista (vacía si no es admin)
        ]);
    }

    /**
     * Guarda la cita en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            // 'reason' => 'required|string|max:255', // En el form se llama 'reason', en DB 'observation' ?
        ]);

        // Determinamos el ID del paciente real
        $patientId = auth()->id(); // Por defecto, es el usuario logueado
        if (auth()->user()->role === 'admin' && $request->has('patient_id') && $request->patient_id) {
            $patientId = $request->patient_id; // Si es admin y eligió a alguien, usamos ese ID
        }

        Appointment::create([
            'user_id' => $patientId,    // Usamos la variable calculada
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'time' => $request->time,
            'observation' => $request->reason ?? $request->observation ?? 'Sin motivo', // Simplificado
            'status' => 'pending',
        ]);

        // Redirección inteligente: Si es admin, vuelve al panel admin. Si es paciente, al dashboard.
        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.appointments.index' : 'dashboard';

        return redirect()->route($redirectRoute)->with('success', 'Cita agendada correctamente.');
    }

    /**
     * Cancela una cita.
     */
    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Seguridad: Solo el dueño de la cita puede cancelarla
        if ($appointment->user_id !== auth()->id()) {
            abort(403);
        }

        // REGLA DE NEGOCIO (RF04): No cancelar con menos de 24h de antelación
        $appointmentDate = \Carbon\Carbon::parse($appointment->date . ' ' . $appointment->time);
        if ($appointmentDate->lt(now()->addHours(24))) {
            return redirect()->back()->with('error', 'No puedes cancelar con menos de 24 horas de antelación. Por favor contacta al consultorio.');
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Cita cancelada.');
    }
}