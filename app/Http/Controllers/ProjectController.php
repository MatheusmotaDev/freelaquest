<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Quote; // <--- Importante
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // 1. Formulário de Criação (Agora inteligente)
    public function create(Request $request)
    {
        $clients = Client::where('user_id', Auth::id())->orderBy('name')->get();
        $tags = Tag::all(); 
        
        // Se vier um ID de orçamento na URL (?quote_id=1), buscamos ele
        $quote = null;
        if ($request->has('quote_id')) {
            $quote = Quote::where('user_id', Auth::id())->find($request->quote_id);
        }

        return view('projects.create', compact('clients', 'tags', 'quote'));
    }

    // 2. Salvar Projeto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'client_id' => 'required|exists:clients,id',
            'total_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date',
            'description' => 'nullable|string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'quote_id' => 'nullable|exists:quotes,id', // Valida o ID do orçamento se vier
        ]);

        $project = $request->user()->projects()->create([
            'client_id' => $validated['client_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'total_amount' => $validated['total_amount'],
            'deadline' => $validated['deadline'],
            'status' => 'pending', // Sempre nasce pendente para você iniciar quando quiser
        ]);

        // Salva as Tags
        if ($request->has('tags')) {
            $project->tags()->attach($request->tags);
        }

        // --- INTEGRAÇÃO COM ORÇAMENTO ---
        // Se veio de um orçamento, atualiza ele para "Aceito" e vincula
        if ($request->filled('quote_id')) {
            $quote = Quote::find($request->quote_id);
            if ($quote && $quote->user_id === Auth::id()) {
                $quote->update([
                    'status' => 'accepted',
                    'converted_to_project_id' => $project->id
                ]);
            }
        }

        // Gamificação
        $newBadges = $request->user()->checkBadges();
        $msg = 'Projeto criado com sucesso!';
        if (count($newBadges) > 0) $msg .= " 🏅 Conquista: " . $newBadges[0]->name;

        return redirect()->route('dashboard')->with('success', $msg);
    }

    // 3. Exibir Detalhes
    public function show(Project $project)
    {
        if ($project->user_id !== Auth::id()) abort(403);
        $project->load(['client', 'invoices', 'expenses', 'tags']);
        return view('projects.show', compact('project'));
    }

    // 4. Atualizar Status
    public function updateStatus(Request $request, Project $project)
    {
        if ($project->user_id !== Auth::id()) abort(403);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled'
        ]);

        $project->update(['status' => $validated['status']]);

        if ($validated['status'] === 'completed') {
            $request->user()->checkBadges();
        }

        return back()->with('success', 'Status atualizado!');
    }
    
    // 5. Listagem
    public function index()
    {
        $projects = Auth::user()->projects()->with('client')->latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }
}