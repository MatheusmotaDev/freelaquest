<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * 1. Mostrar formulário de Nova Fatura
     * Recebemos o Projeto na URL para já vincular automático
     */
    public function create(Project $project)
    {
        // Segurança: Só pode criar fatura se o projeto for seu
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        return view('invoices.create', compact('project'));
    }

    /**
     * 2. Salvar a Fatura
     */
    public function store(Request $request, Project $project)
    {
        // Segurança
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'required|date',
        ]);

        // Cria a fatura vinculada ao projeto
        $project->invoices()->create([
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'due_date' => $validated['due_date'],
            'status' => 'pending', // Nasce pendente
        ]);

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Fatura criada! Agora é só cobrar.');
    }

    /**
     * 3. Pagar a Fatura (Já existia)
     */
    public function markAsPaid(Invoice $invoice)
    {
        if ($invoice->project->user_id !== auth()->id()) {
            abort(403);
        }

        if ($invoice->status === 'paid') {
            return back()->with('error', 'Essa fatura já foi paga.');
        }

        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        // Gamificação
        $xpEarned = (int) $invoice->amount;
        $leveledUp = auth()->user()->addXp($xpEarned);

        $message = "Pagamento confirmado! Você ganhou +{$xpEarned} XP.";
        
        if ($leveledUp) {
            $message .= " PARABÉNS! VOCÊ SUBIU DE NÍVEL!";
        }

        return back()->with('success', $message);
    }
}