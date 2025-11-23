<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Importante: Importar os Models para as checagens funcionarem
use App\Models\Invoice;
use App\Models\Expense; 
use App\Models\Badge;

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

    // --- RELACIONAMENTOS ---
    public function clients() { return $this->hasMany(Client::class); }
    public function projects() { return $this->hasMany(Project::class); }
    public function quotes() { return $this->hasMany(Quote::class); }
    
    public function badges() { 
        return $this->belongsToMany(Badge::class)->withPivot('unlocked_at'); 
    }

    // --- XP E NÍVEL ---
    public function addXp(int $amount)
    {
        $this->current_xp += $amount;
        
        $xpNeeded = $this->current_level * 1000;
        $leveledUp = false;

        while ($this->current_xp >= $xpNeeded) {
            $this->current_xp -= $xpNeeded;
            $this->current_level++;
            $xpNeeded = $this->current_level * 1000;
            $leveledUp = true;
        }

        $this->save();
        return $leveledUp;
    }

    public function getXpProgressAttribute()
    {
        $xpNeeded = $this->current_level * 1000;
        return $xpNeeded == 0 ? 0 : ($this->current_xp / $xpNeeded) * 100;
    }

    // --- VERIFICAÇÃO DE BADGES (ATUALIZADA) ---
    public function checkBadges()
    {
        $unlockedNow = [];
        
        // Busca badges que o usuário ainda NÃO tem
        $potentialBadges = Badge::whereDoesntHave('users', function($q) {
            $q->where('user_id', $this->id);
        })->get();

        foreach ($potentialBadges as $badge) {
            $awarded = false;

            switch ($badge->rule_identifier) {
                // Regras Básicas
                case 'FIRST_PROJECT':
                    if ($this->projects()->count() >= 1) $awarded = true;
                    break;
                
                case 'FIRST_INVOICE':
                    $hasPaid = Invoice::whereHas('project', fn($q) => $q->where('user_id', $this->id))
                        ->where('status', 'paid')->exists();
                    if ($hasPaid) $awarded = true;
                    break;

                case 'HIGH_TICKET_2K':
                    $highTicket = Invoice::whereHas('project', fn($q) => $q->where('user_id', $this->id))
                        ->where('status', 'paid')
                        ->where('amount', '>=', 2000)->exists();
                    if ($highTicket) $awarded = true;
                    break;
                
                case '3_CLIENTS':
                    if ($this->clients()->count() >= 3) $awarded = true;
                    break;

                // Regras Avançadas (Novas)
                case 'LEVEL_5':
                    if ($this->current_level >= 5) $awarded = true;
                    break;

                case 'EARN_10K':
                    $totalEarned = Invoice::whereHas('project', fn($q) => $q->where('user_id', $this->id))
                        ->where('status', 'paid')->sum('amount');
                    if ($totalEarned >= 10000) $awarded = true;
                    break;

                case '3_ACTIVE_PROJECTS':
                    $activeCount = $this->projects()->where('status', 'in_progress')->count();
                    if ($activeCount >= 3) $awarded = true;
                    break;

                case 'FIRST_EXPENSE':
                    $hasExpense = Expense::whereHas('project', fn($q) => $q->where('user_id', $this->id))->exists();
                    if ($hasExpense) $awarded = true;
                    break;
            }

            if ($awarded) {
                $this->badges()->attach($badge->id, ['unlocked_at' => now()]);
                $this->addXp($badge->xp_bonus);
                $unlockedNow[] = $badge;
            }
        }

        return $unlockedNow;
    }
}