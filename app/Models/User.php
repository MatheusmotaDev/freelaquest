<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        // Gamificação e Metas
        'current_xp',
        'current_level',
        'financial_goal_name',
        'financial_goal_amount',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --- RELACIONAMENTOS QUE FALTAVAM ---

    // 1. Usuário tem muitos Clientes
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    // 2. Usuário tem muitos Projetos (O que causou o erro)
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // 3. Usuário tem muitos Orçamentos
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    // 4. Badges (Conquistas) - Relação Many-to-Many
    public function badges()
    {
        return $this->belongsToMany(Badge::class)->withPivot('unlocked_at');
    }
}