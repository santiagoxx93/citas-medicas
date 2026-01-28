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
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();
        
        // Médico al que pertenece este horario
        $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
        
        // Día de la semana (0=Domingo, 1=Lunes... o usar nombres 'monday')
        $table->string('day_of_week'); 
        
        $table->time('start_time'); // Hora inicio turno (ej: 08:00)
        $table->time('end_time');   // Hora fin turno (ej: 12:00)
        
        // Pausa activa (true = horario disponible, false = día libre/bloqueado)
        $table->boolean('is_active')->default(true);
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
