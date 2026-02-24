<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pokemon;

class Deck extends Model
{
    protected $fillable = ['name', 'description', 'user_id'];
    
    public function pokemons()
        {
            return $this->belongsToMany(Pokemon::class, 'deck_pokemon')
                ->withPivot('quantity')
                ->withTimestamps();
        }

}
