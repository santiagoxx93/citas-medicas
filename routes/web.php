<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- PÁGINA DE INICIO (Pública) ---
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

// --- GRUPO 1: PACIENTES ---
// Solo entran usuarios con rol 'patient'
Route::middleware(['auth', 'verified', 'role:patient'])->group(function () {

    // 1. Dashboard del Paciente (Con lista de sus citas)
    Route::get('/dashboard', function () {
        $appointments = auth()->user()
            ->appointmentsAsPatient()
            ->with('doctor')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        return Inertia::render('Dashboard', [
            'appointments' => $appointments
        ]);
    })->name('dashboard');

    // 2. Formulario para agendar cita
    Route::get('/appointments/create', [App\Http\Controllers\AppointmentController::class, 'create'])
        ->name('appointments.create');

    // 3. Guardar la cita (POST)
    Route::post('/appointments', [App\Http\Controllers\AppointmentController::class, 'store'])
        ->name('appointments.store');

    // 4. Cancelar cita propia
    Route::patch('/appointments/{id}/cancel', [App\Http\Controllers\AppointmentController::class, 'cancel'])
        ->name('appointments.cancel');
});

// --- GRUPO 2: ADMINISTRADORES Y MÉDICOS ---
// Solo entran usuarios con rol 'admin' O 'doctor'
Route::middleware(['auth', 'verified', 'role:admin,doctor'])->group(function () {
    
    // 1. Dashboard Visual (Gráficos y Estadísticas)
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])
        ->name('admin.dashboard');

    // 2. Agenda Médica (Tabla de Gestión)
    Route::get('/admin/appointments', [App\Http\Controllers\AdminController::class, 'appointmentsIndex'])
        ->name('admin.appointments.index');

    // 3. Cambiar estado (Confirmar/Cancelar)
    Route::patch('/admin/appointments/{id}/status', [App\Http\Controllers\AdminController::class, 'updateStatus'])
        ->name('admin.appointments.status');

    // 4. Gestión de Horarios
    Route::get('/admin/schedules', [App\Http\Controllers\ScheduleController::class, 'edit'])
        ->name('admin.schedules.edit');
        
    Route::post('/admin/schedules', [App\Http\Controllers\ScheduleController::class, 'update'])
        ->name('admin.schedules.update');

    // 5. GESTIÓN DE MÉDICOS (NUEVO)
    Route::get('/admin/register-doctor', [App\Http\Controllers\AdminController::class, 'createDoctor'])
        ->name('admin.doctors.create');
        
    Route::post('/admin/register-doctor', [App\Http\Controllers\AdminController::class, 'storeDoctor'])
        ->name('admin.doctors.store');
});

// --- RUTAS DE PERFIL (Breeze Default) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';