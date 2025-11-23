<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Ação de Marcar como Paga
    public function markAsPaid(Invoice $invoice)
    {
        // Segurança: Só pode pagar se for dono do projeto
        if ($invoice->project->user_id !== auth()->id()) {
            abort(403);
        }

        // Se já pagou, não faz nada
        if ($invoice->status === 'paid') {
            return back()->with('error', 'Essa fatura já foi paga.');
        }

        // 1. Atualiza status da fatura no banco
        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        // 2. GAMIFICAÇÃO: O valor da fatura vira XP
        $xpEarned = (int) $invoice->amount;
        
        // Chama a função que criamos no Passo 1
        $leveledUp = auth()->user()->addXp($xpEarned);

        // 3. Prepara a mensagem de vitória
        $message = "Pagamento confirmado! Você ganhou +{$xpEarned} XP.";
        
        if ($leveledUp) {
            $message .= " PARABÉNS! VOCÊ SUBIU DE NÍVEL!";
        }

        return back()->with('success', $message);
    }
}