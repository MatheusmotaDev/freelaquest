<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    
    public function create(Project $project)
    {
      
        if ($project->user_id !== Auth::id()) abort(403);
        return view('invoices.create', compact('project'));
    }

    
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


    public function markAsPaid(Invoice $invoice)
    {
      

        if ($invoice->project->user_id !== auth()->id()) abort(403);

        if ($invoice->status === 'paid') {
            return back()->with('error', 'Essa fatura já foi paga.');
        }

        
        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

       

        $xpEarned = (int) $invoice->amount;
        $leveledUp = auth()->user()->addXp($xpEarned);

        
        $newBadges = auth()->user()->checkBadges();

       
        $message = "Pagamento confirmado! +{$xpEarned} XP.";
        
        if ($leveledUp) {
            $message .= " SUBIU DE NÍVEL!";
        }

        if (count($newBadges) > 0) {
            
            $names = collect($newBadges)->pluck('name')->join(', ');
            $message .= " 🏅 CONQUISTA: {$names}!";
        }

        return back()->with('success', $message);
    }
}