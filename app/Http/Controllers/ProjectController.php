<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // 1. Mostrar o formulário
    public function create()
    {
        // Busca apenas os clientes do usuário logado para o dropdown
        $clients = Client::where('user_id', Auth::id())->orderBy('name')->get();
        
        return view('projects.create', compact('clients'));
    }

    // 2. Salvar no Banco
    public function store(Request $request)
    {
        // Validação (Segurança)
        $validated = $request->validate([
            'title' => 'required|max:255',
            'client_id' => 'required|exists:clients,id',
            'total_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date',
            'description' => 'nullable|string',
        ]);

        // Criar o projeto vinculado ao usuário
        $request->user()->projects()->create([
            'client_id' => $validated['client_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'total_amount' => $validated['total_amount'],
            'deadline' => $validated['deadline'],
            'status' => 'pending', // Começa sempre pendente
        ]);

        // Redirecionar para o Dashboard com aviso de sucesso
        return redirect()->route('dashboard')->with('success', 'Projeto criado com sucesso! Vamos trabalhar!');
    }
}