<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    
    public function index()
    {
        $goals = Auth::user()->goals()->get();
        return view('goals.index', compact('goals'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        
        $currentGoal = $user->activeGoal;

        if ($currentGoal) {
           
            $currentGoal->update([
                'title' => $validated['title'],
                'amount' => $validated['amount'],
                'description' => $validated['description'] ?? null,
            ]);
            $msg = 'Meta atualizada com sucesso!';
        } else {
            
            $user->goals()->create([
                'title' => $validated['title'],
                'amount' => $validated['amount'],
                'description' => $validated['description'] ?? null,
                'status' => 'active'
            ]);
            $msg = 'Nova meta definida! Foco total.';
        }

        return back()->with('success', $msg);
    }

   
    public function complete(Goal $goal)
    {
        if ($goal->user_id !== Auth::id()) abort(403);

        $goal->update([
            'status' => 'completed',
            'achieved_at' => now()
        ]);

        
        Auth::user()->addXp(100); 

        return back()->with('success', 'PARABÉNS! Meta conquistada! (+100 XP)');
    }
    
   
    public function archive(Goal $goal)
    {
        if ($goal->user_id !== Auth::id()) abort(403);
        
        $goal->update(['status' => 'cancelled']);
        
        return back()->with('info', 'Meta arquivada. Hora de definir uma nova.');
    }
}