<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = ['nombre', 'correo', 'contrasena', 'rol', 'estado'];
    protected $hidden = ['contrasena', 'remember_token'];

    protected function casts(): array
    {
        return [
            'correo_verificado_en' => 'datetime',
            'contrasena' => 'hashed',
        ];
    }

    /**
     * El campo de correo que usa el sistema de autenticación de Laravel.
     */
    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    public function getAuthPasswordName(): string
    {
        return 'contrasena';
    }

    public function trabajador()
    {
        return $this->hasOne(Trabajador::class, 'usuario_id');
    }

    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }
}
