<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'client_id', 
        'converted_to_project_id', // Importante para o fluxo de conversão
        'title', 
        'description', 
        'amount', 
        'valid_until', 
        'status'
    ];

    protected $casts = [
        'valid_until' => 'date',
        'amount' => 'decimal:2'
    ];

    // Dono do orçamento
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cliente que recebe o orçamento
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Se este orçamento virou projeto, aqui está a ligação
    public function project()
    {
        return $this->belongsTo(Project::class, 'converted_to_project_id');
    }
    
    // Helper visual para status (Badge colorida na tela depois)
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'draft' => 'gray',
            'sent' => 'blue',
            'accepted' => 'green',
            'rejected' => 'red',
        };
    }

   

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

}