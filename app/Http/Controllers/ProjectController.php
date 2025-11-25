<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Tag; // <--- IMPORTANTE: Importar o Model Tag
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
        
        // --- CORREÇÃO DO ERRO ---
        // Busca as tags para enviar para a View (os checkboxes)
        $tags = Tag::all(); 
        
        // Adicionamos 'tags' no compact
        return view('projects.create', compact('clients', 'tags'));
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
            'tags' => 'array', // Valida lista de tags
            'tags.*' => 'exists:tags,id',
        ]);

        $project = $request->user()->projects()->create([
            'client_id' => $validated['client_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'total_amount' => $validated['total_amount'],
            'deadline' => $validated['deadline'],
            'status' => 'pending',
        ]);

        // --- SALVAR TAGS ---
        if ($request->has('tags')) {
            $project->tags()->attach($request->tags);
        }

        // --- GAMIFICAÇÃO ---
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
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        // Carrega tags também
        $project->load(['client', 'invoices', 'expenses', 'tags']);

        return view('projects.show', compact('project'));
    }
}