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
        // Création de la table 'pokemon'
        Schema::create('pokemon', function (Blueprint $table) {
            $table->id();

            // Identification
            $table->string('name')->unique();
            $table->unsignedInteger('pokedex_number')->unique();

            // Types (filtrage)
            $table->string('type1');
            $table->string('type2')->nullable();

            // Stats principales (fiche Pokémon)
            $table->unsignedSmallInteger('hp');
            $table->unsignedSmallInteger('attack');
            $table->unsignedSmallInteger('defense');
            $table->unsignedSmallInteger('sp_attack');
            $table->unsignedSmallInteger('sp_defense');
            $table->unsignedSmallInteger('speed');

            // Infos générales
            $table->unsignedTinyInteger('generation');
            $table->boolean('is_legendary')->default(false);

            // Affichage
            $table->string('image_path')->nullable(); // Chemin vers l'image du Pokémon qui sera inséré depuis notre seeder

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon');
    }
};
