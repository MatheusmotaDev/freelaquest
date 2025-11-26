<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Auth::user()->quotes()->with('client')->latest()->get();
        return view('quotes.index', compact('quotes'));
    }

    public function create()
    {
        $clients = Auth::user()->clients;
        return view('quotes.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string',
            'valid_until' => 'nullable|date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $quote = $request->user()->quotes()->create([
                'client_id' => $validated['client_id'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                // AQUI ESTÁ A CORREÇÃO (?? null):
                'valid_until' => $validated['valid_until'] ?? null,
                'amount' => 0, 
                'status' => 'draft'
            ]);

            $grandTotal = 0;

            foreach ($request->items as $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];
                $grandTotal += $lineTotal;

                $quote->items()->create([
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $lineTotal
                ]);
            }

            $quote->update(['amount' => $grandTotal]);
        });

        return redirect()->route('quotes.index')->with('success', 'Orçamento detalhado criado com sucesso!');
    }

    public function show(Quote $quote)
    {
        if ($quote->user_id !== Auth::id()) abort(403);
        $quote->load(['client', 'items']);
        return view('quotes.show', compact('quote'));
    }

    public function convert(Quote $quote)
    {
        if ($quote->user_id !== Auth::id()) abort(403);
        if ($quote->status === 'accepted') return back()->with('error', 'Este orçamento já foi aprovado!');

        DB::transaction(function () use ($quote) {
            $project = Project::create([
                'user_id' => $quote->user_id,
                'client_id' => $quote->client_id,
                'title' => $quote->title,
                'description' => $quote->description,
                'total_amount' => $quote->amount,
                'status' => 'pending',
                'deadline' => now()->addDays(30),
            ]);

            $quote->update([
                'status' => 'accepted',
                'converted_to_project_id' => $project->id
            ]);
        });

        return redirect()->route('projects.index')->with('success', 'Orçamento aprovado! Projeto criado.');
    }

    public function reject(Quote $quote)
    {
        if ($quote->user_id !== Auth::id()) abort(403);
        
        if ($quote->status === 'accepted') {
            return back()->with('error', 'Não pode rejeitar um orçamento que já virou projeto!');
        }

        $quote->update(['status' => 'rejected']);

        return back()->with('info', 'Orçamento marcado como recusado.');
    }
}