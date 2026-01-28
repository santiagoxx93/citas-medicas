<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear ADMIN
        User::create([
            'name' => 'Administrador Principal',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // 2. Crear DOCTOR
        $doctor = User::create([
            'name' => 'Dr. Gregorio Casas',
            'email' => 'doctor@clinica.com',
            'password' => Hash::make('12345678'),
            'role' => 'doctor',
        ]);

        // 3. Crear HORARIOS del Doctor (Lunes a Viernes, 8am a 12pm)
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        foreach ($days as $day) {
            Schedule::create([
                'doctor_id' => $doctor->id,
                'day' => $day,
                'start_time' => '08:00:00',
                'end_time' => '12:00:00',
                'is_active' => true,
            ]);
        }

        // 4. Crear 10 PACIENTES Falsos
        $nombres = ['Ana Pérez', 'Luis Gomez', 'Carlos Ruiz', 'Maria Diaz', 'Sofia Lora', 'Pedro Paz', 'Laura Bozzo', 'Juan Soto', 'Elena Nito', 'Kevin Mar'];
        
        $pacientesIds = [];
        foreach ($nombres as $index => $nombre) {
            $p = User::create([
                'name' => $nombre,
                'email' => 'paciente'.($index+1).'@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'patient',
            ]);
            $pacientesIds[] = $p->id;
        }

        // 5. Generar 30 CITAS (Pasadas, Hoy y Futuras) para llenar el Gráfico
        $estados = ['pending', 'confirmed', 'cancelled', 'completed'];
        
        for ($i = 0; $i < 30; $i++) {
            // Fecha aleatoria entre hace 10 días y dentro de 10 días
            $fecha = Carbon::today()->subDays(rand(-10, 10));
            
            // Si la fecha es pasada, probablemente ya está completada o cancelada
            $status = $estados[array_rand($estados)];
            if ($fecha->isPast() && $status == 'pending') {
                $status = 'completed'; 
            }

            Appointment::create([
                'user_id' => $pacientesIds[array_rand($pacientesIds)], // El paciente que pide la cita
                'patient_id' => $pacientesIds[array_rand($pacientesIds)], // El paciente atendido (usualmente el mismo)
                'doctor_id' => $doctor->id,
                'date' => $fecha->format('Y-m-d'),
                'time' => rand(8, 11) . ':00:00', // Horas random entre 8 y 11
                'status' => $status,
                'observation' => 'Chequeo general generado por sistema.',
            ]);
        }
    }
}