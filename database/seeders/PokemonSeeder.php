<?php

namespace Database\Seeders;

use App\Models\pokemon; // N'oubliez pas d'importer le modèle Pokemon
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void{

        $lien = __DIR__ . "/data/pokemon.json";
        $jsonString = file_get_contents($lien);
        $datas = json_decode($jsonString, true);

        foreach ($datas as $key => $data) {

            // Génération du nom d'image
            $imgName = strtolower($data['name']);
            $imgName = str_replace([' ', '.', '\'', '’'], '-', $imgName);
            $imgName .= '.png';

            Pokemon::firstOrCreate(
                [   'pokedex_number' => $data['pokedex_number'],
                    'name' => $data['name'],
                    'type1' => $data['type1'],
                    'type2' => $data['type2'] !== "" ? $data['type2'] : null,
                    'hp' => $data['hp'],
                    'attack' => $data['attack'],
                    'defense' => $data['defense'],
                    'sp_attack' => $data['sp_attack'],
                    'sp_defense' => $data['sp_defense'],
                    'speed' => $data['speed'],
                    'generation' => $data['generation'],
                    'is_legendary' => $data['is_legendary'] == 1,
                    'image_path' => 'assets/images/pokemon/' . $imgName
                ]
            );
        }
    }

}
