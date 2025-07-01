<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anecdote extends Model
{
    protected $fillable = ['title'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
