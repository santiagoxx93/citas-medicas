<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User; // <--- Importante para buscar doctores
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Muestra la vista de edición de horarios.
     * Permite al Admin seleccionar un médico.
     */
    public function edit(Request $request)
    {
        $user = Auth::user();
        $doctors = [];
        $schedules = [];
        $targetDoctorId = null;

        // 1. LÓGICA SEGÚN ROL
        if ($user->role === 'admin') {
            // Si es Admin, obtenemos la lista de doctores para el dropdown
            $doctors = User::where('role', 'doctor')->get();
            
            // Verificamos si el admin seleccionó un doctor (viene por URL)
            $targetDoctorId = $request->input('doctor_id');
        } else {
            // Si es Doctor, solo puede ver sus propios horarios
            $targetDoctorId = $user->id;
        }

        // 2. CARGA O GENERACIÓN DE HORARIOS (Solo si hay un doctor definido)
        if ($targetDoctorId) {
            $schedules = Schedule::where('doctor_id', $targetDoctorId)->get();

            // Auto-generación (Lazy Loading) para el doctor seleccionado
            if ($schedules->isEmpty()) {
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                foreach ($days as $day) {
                    Schedule::create([
                        'doctor_id' => $targetDoctorId,
                        'day_of_week' => $day,
                        'is_active' => true,
                        'start_time' => '08:00:00',
                        'end_time' => '16:00:00',
                    ]);
                }
                $schedules = Schedule::where('doctor_id', $targetDoctorId)->get();
            }
        }

        return Inertia::render('Admin/Schedules', [
            'schedules' => $schedules,
            'doctors' => $doctors, // Lista vacía si no es admin
            'selectedDoctorId' => $targetDoctorId,
            'isAdmin' => $user->role === 'admin'
        ]);
    }

    /**
     * Guarda los cambios masivos en los horarios.
     */
    public function update(Request $request)
    {
        $request->validate([
            'schedules' => 'required|array',
            'schedules.*.id' => 'required|exists:schedules,id',
            'schedules.*.start_time' => 'required',
            'schedules.*.end_time' => 'required',
            'schedules.*.is_active' => 'boolean',
        ]);

        foreach ($request->schedules as $scheduleData) {
            $schedule = Schedule::find($scheduleData['id']);
            
            // PERMISO: El dueño PUEDE editar, el Admin TAMBIÉN PUEDE editar
            if ($schedule->doctor_id === Auth::id() || Auth::user()->role === 'admin') {
                $schedule->update([
                    'start_time' => $scheduleData['start_time'],
                    'end_time' => $scheduleData['end_time'],
                    'is_active' => (bool) $scheduleData['is_active'],
                ]);
            }
        }

        return redirect()->back()->with('success', 'Horarios actualizados correctamente.');
    }
}