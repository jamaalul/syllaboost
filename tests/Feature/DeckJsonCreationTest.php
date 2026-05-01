<?php

namespace Tests\Feature;

use App\Models\Deck;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeckJsonCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_json_creation_page_is_accessible(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('decks.create.json'));

        $response->assertStatus(200);
        $response->assertSee('Create Deck with JSON');
    }

    public function test_user_can_create_deck_with_valid_json(): void
    {
        $user = User::factory()->create();

        $jsonData = json_encode([
            'name' => 'JSON Deck',
            'description' => 'Created via JSON',
            'is_public' => true,
            'cards' => [
                ['front' => 'Front 1', 'back' => 'Back 1'],
                ['front' => 'Front 2', 'back' => 'Back 2'],
            ],
        ]);

        $response = $this->actingAs($user)->post(route('decks.store.json'), [
            'json_data' => $jsonData,
        ]);

        $response->assertRedirect(route('decks.index'));
        $this->assertDatabaseHas('decks', [
            'name' => 'JSON Deck',
            'description' => 'Created via JSON',
            'is_public' => true,
        ]);

        $deck = Deck::where('name', 'JSON Deck')->first();
        $this->assertCount(2, $deck->cards);
        $this->assertDatabaseHas('cards', ['front_content' => 'Front 1', 'deck_id' => $deck->id]);
    }

    public function test_user_cannot_create_deck_with_invalid_json(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('decks.store.json'), [
            'json_data' => '{ invalid json }',
        ]);

        $response->assertSessionHasErrors('json_data');
        $response->assertSessionHas('error', 'The JSON structure is incorrect. Please check your syntax.');
        $this->assertEquals('{ invalid json }', old('json_data'));
        $this->assertDatabaseCount('decks', 0);
    }

    public function test_user_cannot_create_deck_with_missing_required_fields_in_json(): void
    {
        $user = User::factory()->create();

        $jsonData = json_encode([
            'description' => 'Missing name',
            'cards' => [],
        ]);

        $response = $this->actingAs($user)->post(route('decks.store.json'), [
            'json_data' => $jsonData,
        ]);

        $response->assertSessionHasErrors();
        $this->assertDatabaseCount('decks', 0);
    }
}
