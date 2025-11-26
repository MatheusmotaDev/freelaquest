<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'amount', 'status', 'description', 'achieved_at'];

    protected $casts = [
        'amount' => 'decimal:2',
        'achieved_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}