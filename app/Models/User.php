<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',  // (admin, doctor, patient)
        'phone', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    /* -----------------------------------------------------------------
       RELACIONES
    ----------------------------------------------------------------- */

    // Relación: Un Paciente tiene muchas citas solicitadas
    // Relación: Un Paciente tiene muchas citas solicitadas
    public function appointmentsAsPatient(): HasMany
    {
        // CORRECCIÓN: Usamos 'user_id' porque así se llama en tu base de datos
        return $this->hasMany(Appointment::class, 'user_id');
    }
    // Relación: Un Médico tiene muchas citas asignadas
    public function appointmentsAsDoctor(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    // Relación: Un Médico tiene horarios configurados
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'doctor_id');
    }
    
    // Helper para verificar rol fácilmente en el código
    public function isDoctor(): bool { return $this->role === 'doctor'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isPatient(): bool { return $this->role === 'patient'; }
}