<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon_path', 'description', 'rule_identifier', 'xp_bonus'];

    // Relação: Badge pertence a muitos usuários
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('unlocked_at');
    }
}