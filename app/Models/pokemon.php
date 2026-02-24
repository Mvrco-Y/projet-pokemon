<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Deck;

class Pokemon extends Model
{
    
    protected $table = 'pokemon';
    public $timestamps = false;
    
    public function decks()
    {
        return $this->belongsToMany(Deck::class, 'deck_pokemon')
            ->withPivot('quantity')
            ->withTimestamps();
    }


}
