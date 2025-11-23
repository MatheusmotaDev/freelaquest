<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    // 1. Mostrar formulário de criar fatura
    public function create(Project $project)
    {
        // Só o dono do projeto pode criar fatura
        if ($project->user_id !== Auth::id()) abort(403);
        return view('invoices.create', compact('project'));
    }

    // 2. Salvar nova fatura no banco
    public function store(Request $request, Project $project)
    {
        if ($project->user_id !== Auth::id()) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'required|date',
        ]);

        $project->invoices()->create([
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'due_date' => $validated['due_date'],
            'status' => 'pending',
        ]);

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Fatura criada com sucesso!');
    }

    // 3. AÇÃO DE PAGAR E GANHAR XP
    public function markAsPaid(Invoice $invoice)
    {
        // Verifica se o projeto da fatura pertence ao usuário logado
        if ($invoice->project->user_id !== auth()->id()) abort(403);

        if ($invoice->status === 'paid') {
            return back()->with('error', 'Essa fatura já foi paga.');
        }

        // Marca como pago
        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        // --- LÓGICA DE GAMIFICAÇÃO ---
        // Ganha XP igual ao valor (R$ 1 = 1 XP)
        $xpEarned = (int) $invoice->amount;
        $leveledUp = auth()->user()->addXp($xpEarned);

        // Verifica se desbloqueou alguma Badge (ex: Primeira Venda)
        $newBadges = auth()->user()->checkBadges();

        // Monta a mensagem de sucesso
        $message = "Pagamento confirmado! +{$xpEarned} XP.";
        
        if ($leveledUp) {
            $message .= " SUBIU DE NÍVEL!";
        }

        if (count($newBadges) > 0) {
            // Pega os nomes das medalhas ganhas para mostrar na tela
            $names = collect($newBadges)->pluck('name')->join(', ');
            $message .= " 🏅 CONQUISTA: {$names}!";
        }

        return back()->with('success', $message);
    }
}