<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment; // <--- A LINHA QUE FALTAVA
use App\Models\User;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relação com Comentários
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
    
    // Cores das etiquetas
    public function getColorAttribute()
    {
        return match($this->type) {
            'update' => 'bg-green-100 text-green-800 border-green-200',
            'alert' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-blue-100 text-blue-800 border-blue-200',
        };
    }
    
    // Ícones
    public function getIconAttribute()
    {
        return match($this->type) {
            'update' => '🚀',
            'alert' => '⚠️',
            default => '📢',
        };
    }
}