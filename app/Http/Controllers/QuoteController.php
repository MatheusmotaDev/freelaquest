<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Quote;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    // Listar Orçamentos
    public function index()
    {
        $quotes = Auth::user()->quotes()->with('client')->latest()->get();
        return view('quotes.index', compact('quotes'));
    }

    // Mostrar Formulário
    public function create()
    {
        $clients = Auth::user()->clients;
        return view('quotes.create', compact('clients'));
    }

    // Salvar Orçamento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'valid_until' => 'nullable|date',
        ]);

        $request->user()->quotes()->create($validated);

        return redirect()->route('quotes.index')->with('success', 'Orçamento criado com sucesso!');
    }

    // Ver Detalhes do Orçamento
    public function show(Quote $quote)
    {
        if ($quote->user_id !== Auth::id()) abort(403);
        return view('quotes.show', compact('quote'));
    }

    // A MÁGICA: Converte Orçamento -> Projeto
    public function convert(Quote $quote)
    {
        if ($quote->user_id !== Auth::id()) abort(403);
        
        if ($quote->status === 'accepted') {
            return back()->with('error', 'Este orçamento já foi aprovado!');
        }

        DB::transaction(function () use ($quote) {
            // 1. Cria o Projeto baseado no orçamento
            $project = Project::create([
                'user_id' => $quote->user_id,
                'client_id' => $quote->client_id,
                'title' => $quote->title,
                'description' => $quote->description,
                'total_amount' => $quote->amount,
                'status' => 'pending',
                'deadline' => now()->addDays(30), // Define prazo padrão de 30 dias
            ]);

            // 2. Atualiza o status do orçamento
            $quote->update([
                'status' => 'accepted',
                'converted_to_project_id' => $project->id
            ]);
        });

        return redirect()->route('projects.index')->with('success', 'Orçamento aprovado! Projeto criado.');
    }

    public function reject(Quote $quote)
    {
        if ($quote->user_id !== Auth::id()) abort(403);
        
        if ($quote->status === 'accepted') {
            return back()->with('error', 'Não pode rejeitar um orçamento que já virou projeto!');
        }

        $quote->update(['status' => 'rejected']);

        return back()->with('info', 'Orçamento marcado como recusado/cancelado.');
    }
}