<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Cria o comentário
        $announcement->comments()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content']
        ]);

        return back()->with('success', 'Comentário postado!');
    }
    
    // Opcional: Deletar comentário (se for dono ou admin)
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }
        
        $comment->delete();
        return back()->with('success', 'Comentário removido.');
    }
}