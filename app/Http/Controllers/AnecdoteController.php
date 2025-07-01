<?php

namespace App\Http\Controllers;

use App\Models\Anecdote;
use Illuminate\Http\Request;

class AnecdoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => "required",
            'category' => "required",
            "user_id" => "numeric",
            "content" => 'required'
        ]);

        $anecdote = new Anecdote();
        $anecdote->title = $request->title;
        $anecdote->category = $request->category;
        $anecdote->user_id = $request->user()->id;
        $anecdote->content = $request->content;
        $anecdote->save();
        return response()->json([
            'anecdote' => $anecdote
        ]);
    }
}
