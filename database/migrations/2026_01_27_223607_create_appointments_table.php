<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        
        // Relación con el Paciente (quién pide la cita)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Relación con el Médico (opcional si solo hay uno, pero bueno para escalabilidad RNF-05)
        // Usamos la misma tabla 'users' pero lógica de negocio validará que sea doctor
        $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');

        $table->date('date'); // Fecha de la cita
        $table->time('time'); // Hora de la cita
        
        // Estado de la cita (RF-05: Pendiente, Confirmada, Cancelada)
        $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])
              ->default('pending');
              
        $table->text('observation')->nullable(); // Para notas del médico o motivo
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
