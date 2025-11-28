<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Cores baseadas no tipo de aviso
    public function getColorAttribute()
    {
        return match($this->type) {
            'update' => 'bg-green-100 text-green-800 border-green-200',
            'alert' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-blue-100 text-blue-800 border-blue-200', // info
        };
    }
    
    public function getIconAttribute()
    {
        return match($this->type) {
            'update' => '🚀',
            'alert' => '⚠️',
            default => '📢',
        };
    }
}