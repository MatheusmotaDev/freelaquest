<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function create()
    {
        // Busca projetos do usuário para popular o Select (apenas os não cancelados)
        $projects = Project::where('user_id', Auth::id())
            ->where('status', '!=', 'cancelled')
            ->orderBy('title')
            ->get();
            
        return view('expenses.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'incurred_date' => 'required|date',
        ]);

        // Cria a despesa
        Expense::create([
            'project_id' => $validated['project_id'],
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'incurred_date' => $validated['incurred_date'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Despesa registrada. Menos lucro, mas mais controle!');
    }
}