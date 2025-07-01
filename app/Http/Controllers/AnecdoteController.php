<?php

namespace App\Http\Controllers;

use App\Models\Anecdote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnecdoteController extends Controller
{

    public function index(Request $request)
    {
        
        $offset = $request->query('offset', 0);
        $limit = $request->query('limit', 10);

        
        $offset = max(0, (int)$offset);
        $limit = max(1, min(100, (int)$limit)); 

        $anecdotes = Anecdote::select(
                'anecdotes.id',
                'anecdotes.title',
                'anecdotes.content',
                'anecdotes.category',
                'anecdotes.created_at',
                'users.name as auteur',
                DB::raw('(SELECT COUNT(*) FROM votes WHERE votes.anecdote_id = anecdotes.id) as votes_count')
            )
            ->join('users', 'users.id', '=', 'anecdotes.user_id') 
            ->offset($offset)
            ->limit($limit)
            ->orderBy('anecdotes.created_at', 'desc')
            ->get();

        return response()->json($anecdotes);
    }

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

    public function destroy(Request $request, $id)
    {
        $anecdote = Anecdote::find($id);
        if ($request->user()->role == "admin") {
            $anecdote->delete();
            return response()->json(['message' => "anecdote deleted successufly :)", "anecdote" => $anecdote]);
        }
    }
}
