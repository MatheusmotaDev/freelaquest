<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaderboardController extends Controller
{
    public function index()
    {
        // 1. RANKING GLOBAL (Top 10 por XP Total)
        // Ordena quem tem mais XP acumulado na vida
        $globalRanking = User::orderByDesc('current_xp')
            ->take(10)
            ->get();

        // 2. COMPETIÇÃO MENSAL (Freelancer do Mês)
        // Precisamos somar as faturas pagas DESTE MÊS para cada usuário
        // (Lembrando: R$ 1,00 = 1 XP)
        $monthlyRanking = User::with(['projects.invoices' => function ($query) {
            $query->where('status', 'paid')
                  ->whereMonth('paid_at', now()->month)
                  ->whereYear('paid_at', now()->year);
        }])->get()->map(function ($user) {
            // Soma o valor das faturas pagas deste mês
            $user->monthly_xp = $user->projects->flatMap->invoices->sum('amount');
            return $user;
        })->sortByDesc('monthly_xp')->take(5)->values(); // Pega os top 5

        // 3. HISTÓRICO DO USUÁRIO (Últimos 6 meses)
        // Vamos montar os dados para o gráfico de linha
        $historyLabels = [];
        $historyData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            
            // Soma XP ganho naquele mês específico
            $xpInMonth = Invoice::whereHas('project', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->where('status', 'paid')
            ->whereMonth('paid_at', $date->month)
            ->whereYear('paid_at', $date->year)
            ->sum('amount');

            $historyLabels[] = $date->format('M/Y'); // Ex: "Nov/2025"
            $historyData[] = $xpInMonth;
        }

        // Posição do usuário atual no Ranking Global
        // Contamos quantos usuários têm mais XP que eu + 1
        $myRank = User::where('current_xp', '>', Auth::user()->current_xp)->count() + 1;

        return view('leaderboard.index', compact(
            'globalRanking', 
            'monthlyRanking', 
            'historyLabels', 
            'historyData',
            'myRank'
        ));
    }
}