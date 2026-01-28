<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Muestra la vista de edición de horarios (RF-02).
     */
    public function edit()
    {
        // Buscamos los horarios del usuario logueado (Médico/Admin)
        $schedules = Schedule::where('doctor_id', Auth::id())->get();

        // Si es un médico nuevo y no tiene horarios, podríamos crearlos aquí
        // o mostrar una vista vacía. Asumiremos que el Seeder ya creó los 5 o 7 días base.

        return Inertia::render('Admin/Schedules', [
            'schedules' => $schedules
        ]);
    }

    /**
     * Guarda los cambios masivos en los horarios.
     */
    public function update(Request $request)
    {
        // Validamos que venga un array de horarios
        $request->validate([
            'schedules' => 'required|array',
            'schedules.*.id' => 'required|exists:schedules,id',
            'schedules.*.start_time' => 'required',
            'schedules.*.end_time' => 'required',
            'schedules.*.is_active' => 'boolean',
        ]);

        // Recorremos cada día modificado y actualizamos la base de datos
        foreach ($request->schedules as $scheduleData) {
            $schedule = Schedule::find($scheduleData['id']);
            
            // Seguridad: Asegurar que el horario pertenece al médico que lo edita
            if ($schedule->doctor_id === Auth::id()) {
                $schedule->update([
                    'start_time' => $scheduleData['start_time'],
                    'end_time' => $scheduleData['end_time'],
                    'is_active' => $scheduleData['is_active'],
                ]);
            }
        }

        return redirect()->back()->with('success', 'Horarios actualizados correctamente.');
    }
}