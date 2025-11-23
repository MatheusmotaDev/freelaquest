<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'client_id', 'title', 'description', 
        'deadline', 'total_amount', 'status'
    ];

    protected $casts = [
        'deadline' => 'date',
        'total_amount' => 'decimal:2'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    
    // Helper para calcular lucro (Receita - Despesa)
    public function getProfitAttribute()
    {
        return $this->total_amount - $this->expenses->sum('amount');
    }
}