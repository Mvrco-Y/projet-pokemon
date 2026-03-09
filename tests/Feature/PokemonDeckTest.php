<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pokemon;
use App\Models\Deck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PokemonDeckTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_see_pokemon_list(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_user_can_create_deck(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/decks', [
            'name'        => 'Mon deck test',
            'description' => 'Un deck de test',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('decks', [
            'name'    => 'Mon deck test',
            'user_id' => $user->id,
        ]);
    }
}
