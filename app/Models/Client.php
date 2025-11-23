<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'company_name', 'email', 'phone', 'document'
    ];

    // Relação: Cliente pertence a um Usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relação: Cliente tem muitos Projetos
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Relação: Cliente tem muitos Orçamentos
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}