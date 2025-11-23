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

    // Relações
    public function clients() { return $this->hasMany(Client::class); }
    public function projects() { return $this->hasMany(Project::class); }
    public function quotes() { return $this->hasMany(Quote::class); }
    public function badges() { return $this->belongsToMany(Badge::class)->withPivot('unlocked_at'); }

    // --- NOVA LÓGICA DE GAMIFICAÇÃO ---

    // Função para ganhar XP e subir de nível
    public function addXp(int $amount)
    {
        $this->current_xp += $amount;
        
        // Regra: Para subir de nível, precisa de (Nível Atual * 1000) XP
        $xpNeeded = $this->current_level * 1000;

        $leveledUp = false;

        while ($this->current_xp >= $xpNeeded) {
            $this->current_xp -= $xpNeeded; // Consome o XP usado
            $this->current_level++;         // Sobe o nível
            $xpNeeded = $this->current_level * 1000; // Define nova meta
            $leveledUp = true;
        }

        $this->save();

        return $leveledUp; // Retorna true se subiu de nível
    }

    // Calcula a % da barra de progresso roxa
    public function getXpProgressAttribute()
    {
        $xpNeeded = $this->current_level * 1000;
        if ($xpNeeded == 0) return 0;
        
        return ($this->current_xp / $xpNeeded) * 100;
    }
}