<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    /**
     * Atualiza a Meta Financeira do Usuário
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'financial_goal_name' => 'required|string|max:50',
            'financial_goal_amount' => 'required|numeric|min:1',
        ]);

        // Atualiza o usuário logado
        $user = Auth::user();
        $user->update([
            'financial_goal_name' => $validated['financial_goal_name'],
            'financial_goal_amount' => $validated['financial_goal_amount'],
        ]);

        return back()->with('success', 'Meta atualizada! Agora é só correr atrás.');
    }
}