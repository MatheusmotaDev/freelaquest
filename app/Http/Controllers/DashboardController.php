<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Invoice;
use App\Models\Expense; // <--- Importante: Importar o Model de Despesas

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Calcular "A Receber" (Soma de faturas pendentes)
        $totalReceivables = Invoice::whereHas('project', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'pending')->sum('amount');

        // 2. Calcular Receita Bruta (Tudo que já foi pago)
        $totalRevenue = Invoice::whereHas('project', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'paid')->sum('amount');
        
        // 3. Calcular Despesas Totais (NOVO)
        $totalExpenses = Expense::whereHas('project', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('amount');

        // 4. Lucro Real = Receita - Despesas
        $realProfit = $totalRevenue - $totalExpenses;

        // 5. Projetos Ativos (Últimos 5)
        $activeProjects = Project::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->latest()
            ->take(5)
            ->with('client')
            ->get();

        // 6. Dados da Meta
        $goalAmount = $user->financial_goal_amount ?? 1; 
        $goalProgress = ($realProfit / $goalAmount) * 100;
        
        // Ajustes visuais da meta
        if ($goalProgress < 0) $goalProgress = 0; // Se tiver prejuízo, meta fica em 0
        if ($goalProgress > 100) $goalProgress = 100;

        return view('dashboard', compact(
            'totalReceivables',
            'realProfit',
            'activeProjects',
            'goalProgress',
            'user'
        ));
    }
}