<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;

class AppointmentController extends Controller
{
    /**
     * Muestra el formulario para agendar una nueva cita.
     * (Aquí el paciente ve los horarios disponibles)
     */
    public function create(): Response
    {
        // 1. Obtenemos los horarios activos de la base de datos
        // Eager loading 'doctor' para mostrar el nombre del médico
        $schedules = Schedule::with('doctor')
            ->where('is_active', true)
            ->get();

        // 2. Renderizamos la vista 'Appointments/Create' (que crearemos en breve)
        // y le pasamos los datos de los horarios
        return Inertia::render('Appointments/Create', [
            'schedules' => $schedules
        ]);
    }
    
    public function store(Request $request)
{
    // 1. Validar los datos que vienen del formulario
    $validated = $request->validate([
        'date' => 'required|date|after_or_equal:today', // No permitir fechas pasadas
        'time' => 'required',
        // 'doctor_id' lo sacaremos de la lógica o del formulario. 
        // Por simplificación inicial, asignaremos el primer médico disponible o el seleccionado.
        // Si tu formulario aún no envía doctor_id, lo podemos forzar temporalmente para probar.
        'observation' => 'nullable|string|max:255',
    ]);

    // 2. Crear la cita en la Base de Datos
    $request->user()->appointmentsAsPatient()->create([
        'doctor_id' => 2, // OJO: Aquí ponemos '2' fijo porque es el ID del médico que creamos en el Seeder. Luego lo haremos dinámico.
        'date' => $request->date,
        'time' => $request->time,
        'observation' => $request->observation,
        'status' => 'pending' // Estado inicial según RF-05
    ]);

    // 3. Redirigir al usuario con un mensaje de éxito
    return Redirect::route('dashboard')->with('success', '¡Cita agendada correctamente!');
}

/**
     * Permite al paciente cancelar su propia cita (RF-04).
     */
    public function cancel($id)
    {
        // Buscamos la cita, pero aseguramos que pertenezca al usuario conectado
        // Esto evita que un paciente cancele la cita de otro por error.
        $appointment = auth()->user()->appointmentsAsPatient()->findOrFail($id);

        // Validamos que no esté ya cancelada o completada
        if ($appointment->status === 'cancelled' || $appointment->status === 'completed') {
            return redirect()->back()->with('error', 'Esta cita ya no se puede cancelar.');
        }

        // Actualizamos el estado
        $appointment->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Has cancelado la cita exitosamente.');
    }
}