<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'date',
        'time',
        'status',
        'observation'
    ];

    // Una cita pertenece a un Paciente
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Una cita pertenece a un Médico
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}