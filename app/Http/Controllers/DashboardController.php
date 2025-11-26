<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Invoice;
use App\Models\Expense; 

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

       
        $totalReceivables = Invoice::whereHas('project', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'pending')->sum('amount');

       
        $totalRevenue = Invoice::whereHas('project', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'paid')->sum('amount');
        
        
        $totalExpenses = Expense::whereHas('project', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('amount');

       
        $realProfit = $totalRevenue - $totalExpenses;

       
        $activeProjects = Project::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->latest()
            ->take(5)
            ->with('client')
            ->get();

       
        $goalAmount = $user->financial_goal_amount ?? 1; 
        $goalProgress = ($realProfit / $goalAmount) * 100;
        
        
        if ($goalProgress < 0) $goalProgress = 0; 
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