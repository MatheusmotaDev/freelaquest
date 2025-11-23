<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * 1. Mostrar o formulário de criação
     */
    public function create()
    {
        $clients = Client::where('user_id', Auth::id())->orderBy('name')->get();
        return view('projects.create', compact('clients'));
    }

    /**
     * 2. Salvar o novo projeto no Banco
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'client_id' => 'required|exists:clients,id',
            'total_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $request->user()->projects()->create([
            'client_id' => $validated['client_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'total_amount' => $validated['total_amount'],
            'deadline' => $validated['deadline'],
            'status' => 'pending',
        ]);

        // --- GAMIFICAÇÃO (Única adição) ---
        // Verifica se desbloqueou alguma medalha (Ex: Primeiro Projeto)
        $newBadges = $request->user()->checkBadges();

        $msg = 'Projeto criado com sucesso!';
        if (count($newBadges) > 0) {
            $msg .= " 🏅 Conquista Desbloqueada: " . $newBadges[0]->name;
        }

        return redirect()->route('dashboard')->with('success', $msg);
    }

    /**
     * 3. Exibir Detalhes do Projeto
     */
    public function show(Project $project)
    {
        // Segurança: Só deixa ver se o projeto for do usuário logado
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        // Carrega dados extras (cliente, faturas, despesas)
        $project->load(['client', 'invoices', 'expenses']);

        return view('projects.show', compact('project'));
    }
}