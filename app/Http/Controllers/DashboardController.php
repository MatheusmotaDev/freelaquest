<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Calcular "A Receber" (Soma de faturas pendentes)
        // Buscamos faturas onde o projeto pertence ao usuário logado
        $totalReceivables = Invoice::whereHas('project', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'pending')->sum('amount');

        // 2. Calcular "Lucro Real" (Faturas Pagas - Despesas)
        // Simplificado para este passo: apenas soma das pagas
        $totalRevenue = Invoice::whereHas('project', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'paid')->sum('amount');
        
        // (Futuramente descontaremos as despesas aqui)
        $realProfit = $totalRevenue;

        // 3. Projetos Ativos (Últimos 5)
        $activeProjects = Project::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->latest()
            ->take(5)
            ->with('client') // Traz o cliente junto para não pesar o banco
            ->get();

        // 4. Dados da Meta
        $goalAmount = $user->financial_goal_amount ?? 1; // Evita divisão por zero
        $goalProgress = ($realProfit / $goalAmount) * 100;
        // Trava em 100% se passar
        $goalProgress = $goalProgress > 100 ? 100 : $goalProgress;

        return view('dashboard', compact(
            'totalReceivables',
            'realProfit',
            'activeProjects',
            'goalProgress',
            'user'
        ));
    }
}