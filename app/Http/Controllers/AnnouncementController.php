<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
   
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('announcements.index', compact('announcements'));
    }

    
    public function create()
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Acesso restrito a administradores.');
        }
        return view('announcements.create');
    }

    
    public function store(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:info,update,alert',
            'content' => 'required|string',
        ]);

        $request->user()->announcements()->create($validated);

        return redirect()->route('announcements.index')->with('success', 'Comunicado publicado!');
    }
}