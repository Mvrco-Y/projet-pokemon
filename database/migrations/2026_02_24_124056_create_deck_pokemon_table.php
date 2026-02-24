<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deck_pokemon', function (Blueprint $table) {
            $table->id();

            // FK vers decks
            $table->foreignId('deck_id')
                ->constrained('decks')
                ->cascadeOnDelete();

            // Ta table pokémon s'appelle 'pokemon' (singulier)
            $table->foreignId('pokemon_id')
                ->constrained('pokemon')
                ->cascadeOnDelete();

            // Quantité d'exemplaires dans le deck (1..255)
            $table->unsignedTinyInteger('quantity')->default(1);

            $table->timestamps();

            // Empêche d'avoir deux fois le même pokémon dans un même deck
            $table->unique(['deck_id', 'pokemon_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deck_pokemon');
    }
};
