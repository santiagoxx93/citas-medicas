<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User; // <--- Importante: Para crear usuarios
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // <--- Importante: Para encriptar contraseña
use Illuminate\Validation\Rules; // <--- Importante: Para validar contraseña
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Muestra solo el Dashboard (Tarjetas y Gráficos).
     */
    public function index()
    {
        // 1. Estadísticas
        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'today' => Appointment::whereDate('date', now()->today())->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];

        // 2. Gráfico
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
    public function appointmentsIndex()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'asc')
            ->get();

        return Inertia::render('Admin/Appointments', [
            'appointments' => $appointments
        ]);
    }

    /**
     * Cambiar estado de la cita.
     */
    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:confirmed,cancelled,completed'
        ]);

        $appointment->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Estado de la cita actualizado.');
    }

    // --- GESTIÓN DE MÉDICOS (MÉTODOS AGREGADOS) ---

    /**
     * Muestra el formulario para registrar un nuevo médico.
     */
    public function createDoctor()
    {
        return Inertia::render('Admin/RegisterDoctor');
    }

    /**
     * Guarda el nuevo médico en la base de datos.
     */
    public function storeDoctor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'doctor', // Asignamos el rol automáticamente
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Médico registrado exitosamente.');
    }
}