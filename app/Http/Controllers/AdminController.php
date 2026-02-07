<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth; // Importante para detectar quién está logueado

class AdminController extends Controller
{
    /**
     * Muestra solo el Dashboard (Tarjetas y Gráficos).
     */
    public function index()
    {
        $user = Auth::user();

        // 1. PREPARAMOS LA CONSULTA BASE
        $query = Appointment::query();

        // FILTRO DE SEGURIDAD: Si es doctor, solo ve SUS citas
        if ($user->role === 'doctor') {
            $query->where('doctor_id', $user->id);
        }

        // 2. Calculamos estadísticas usando esa consulta base (usamos clone para no perder el filtro)
        $stats = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'confirmed' => (clone $query)->where('status', 'confirmed')->count(),
            'today' => (clone $query)->whereDate('date', now()->today())->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
        ];

        // 3. Gráfico (Datos filtrados también)
        $chartData = [
            'labels' => ['Pendientes', 'Confirmadas', 'Canceladas'],
            'datasets' => [
                [
                    'label' => 'Cantidad de Citas',
                    'backgroundColor' => ['#FBBF24', '#10B981', '#EF4444'],
                    'data' => [$stats['pending'], $stats['confirmed'], $stats['cancelled']]
                ]
            ]
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'chartData' => $chartData
        ]);
    }

    /**
     * Muestra solo la Tabla de Gestión (Panel Médico).
     */
    public function appointmentsIndex(Request $request)
    {
        $user = Auth::user();

        // 1. Iniciamos la consulta con relaciones
        $query = Appointment::with(['patient', 'doctor']);

        // 2. FILTRO DE SEGURIDAD: Si es doctor, filtramos por su ID
        if ($user->role === 'doctor') {
            $query->where('doctor_id', $user->id);
        }

        // 3. FILTRO POR ESTADO (RF05)
        if ($request->has('status') && in_array($request->status, ['pending', 'confirmed', 'cancelled', 'completed'])) {
            $query->where('status', $request->status);
        }

        // 4. Obtenemos los resultados ordenados
        $appointments = $query->orderBy('date', 'desc')
            ->orderBy('time', 'asc')
            ->get();

        return Inertia::render('Admin/Appointments', [
            'appointments' => $appointments,
            'filters' => $request->only(['status']) // Pasamos el filtro actual a la vista
        ]);
    }

    /**
     * Cambiar estado de la cita.
     */
    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // SEGURIDAD EXTRA: Evitar que un doctor confirme citas de otro doctor manipulando la URL
        if (Auth::user()->role === 'doctor' && $appointment->doctor_id !== Auth::id()) {
            abort(403, 'No tienes permiso para gestionar esta cita.');
        }

        $request->validate([
            'status' => 'required|in:confirmed,cancelled,completed'
        ]);

        $appointment->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Estado de la cita actualizado.');
    }

    // --- GESTIÓN DE MÉDICOS ---

    public function createDoctor()
    {
        return Inertia::render('Admin/RegisterDoctor');
    }

    public function storeDoctor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'specialty' => 'required|string|max:100',
            'phone' => 'required|string|max:20', // <--- NUEVA VALIDACIÓN
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'doctor',
            'specialty' => $request->specialty,
            'phone' => $request->phone, // <--- GUARDAR TELÉFONO
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Médico registrado exitosamente.');
    }

    /**
     * (RF_EXTRA) Actualizar historia clínica (Diagnóstico y Receta)
     */
    public function updateMedicalNotes(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Seguridad: Solo el doctor asignado o un admin pueden editar
        if (Auth::user()->role === 'doctor' && $appointment->doctor_id !== Auth::id()) {
            abort(403, 'No tienes permiso para editar esta cita.');
        }

        $request->validate([
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
        ]);

        $appointment->update([
            'diagnosis' => $request->diagnosis,
            'prescription' => $request->prescription,
            // Opcional: Si agregan notas, podríamos marcarla como completada automáticamente
            // 'status' => 'completed' 
        ]);

        return redirect()->back()->with('success', 'Historia clínica actualizada correctamente.');
    }
}