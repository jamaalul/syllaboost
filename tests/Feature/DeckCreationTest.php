<?php

namespace Tests\Feature;

use App\Models\Deck;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeckCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_deck_creation_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('decks.create'));

        $response->assertStatus(200);
        $response->assertViewIs('decks.create');
    }

    public function test_user_can_create_deck_with_cards(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('decks.store'), [
            'name' => 'Spanish Vocabulary',
            'description' => 'Basic Spanish words',
            'is_public' => true,
            'cards' => [
                ['front_content' => 'Hola', 'back_content' => 'Hello'],
                ['front_content' => 'Adios', 'back_content' => 'Goodbye'],
            ],
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('decks', [
            'user_id' => $user->id,
            'name' => 'Spanish Vocabulary',
        ]);

        $deck = Deck::first();
        $this->assertCount(2, $deck->cards);
        $this->assertEquals('Hola', $deck->cards[0]->front_content);
    }

    public function test_deck_requires_a_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('decks.store'), [
            'name' => '',
            'cards' => [
                ['front_content' => 'Front', 'back_content' => 'Back'],
            ],
        ]);

        $response->assertSessionHasErrors('name');
    }
}
