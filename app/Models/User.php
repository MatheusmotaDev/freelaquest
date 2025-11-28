<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Importante: Importar os Models
use App\Models\Invoice;
use App\Models\Expense; 
use App\Models\Badge;
use App\Models\Announcement; // <--- Importante

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
        'hourly_rate',
        'is_admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    // --- RELACIONAMENTOS ---
    public function clients() { return $this->hasMany(Client::class); }
    public function projects() { return $this->hasMany(Project::class); }
    public function quotes() { return $this->hasMany(Quote::class); }
    public function goals() { return $this->hasMany(Goal::class)->latest(); }
    public function activeGoal() { return $this->hasOne(Goal::class)->where('status', 'active')->latest(); }
    
    // A RELAÇÃO QUE FALTAVA (Comunicados)
    public function announcements() { 
        return $this->hasMany(Announcement::class); 
    }
    
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

    // --- VERIFICAÇÃO DE BADGES ---
    public function checkBadges()
    {
        $unlockedNow = [];
        $potentialBadges = Badge::whereDoesntHave('users', fn($q) => $q->where('user_id', $this->id))->get();

        foreach ($potentialBadges as $badge) {
            $awarded = false;

            switch ($badge->rule_identifier) {
                case 'FIRST_PROJECT':
                    if ($this->projects()->count() >= 1) $awarded = true; break;
                case 'FIRST_INVOICE':
                    if (Invoice::whereHas('project', fn($q) => $q->where('user_id', $this->id))->where('status', 'paid')->exists()) $awarded = true; break;
                case 'HIGH_TICKET_2K':
                    if (Invoice::whereHas('project', fn($q) => $q->where('user_id', $this->id))->where('status', 'paid')->where('amount', '>=', 2000)->exists()) $awarded = true; break;
                case '3_CLIENTS':
                    if ($this->clients()->count() >= 3) $awarded = true; break;
                case 'LEVEL_5':
                    if ($this->current_level >= 5) $awarded = true; break;
                case 'EARN_10K':
                    $totalEarned = Invoice::whereHas('project', fn($q) => $q->where('user_id', $this->id))->where('status', 'paid')->sum('amount');
                    if ($totalEarned >= 10000) $awarded = true; break;
                case '3_ACTIVE_PROJECTS':
                    if ($this->projects()->where('status', 'in_progress')->count() >= 3) $awarded = true; break;
                case 'FIRST_EXPENSE':
                    if (Expense::whereHas('project', fn($q) => $q->where('user_id', $this->id))->exists()) $awarded = true; break;
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