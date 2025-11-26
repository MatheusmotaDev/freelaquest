<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    
    public function index()
    {
        $clients = Auth::user()->clients()->latest()->get();
        return view('clients.index', compact('clients'));
    }

    
    public function create()
    {
        return view('clients.create');
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'document' => 'nullable|string|max:20',
        ]);

        $request->user()->clients()->create($validated);

        return redirect()->route('clients.index')->with('success', 'Cliente cadastrado com sucesso!');
    }
}