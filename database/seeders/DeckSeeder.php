<?php

namespace Database\Seeders;

use App\Models\Deck;
use App\Models\User;
use Illuminate\Database\Seeder;

class DeckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var User $user */
        $user = User::first();

        if (! $user) {
            $this->command->warn('No users found. Run UserSeeder or register a user first.');

            return;
        }

        $decks = [
            [
                'name' => 'JLPT N5 Essentials',
                'description' => 'Master the 800 most essential vocabulary words and kanji for the JLPT N5 exam. Perfect for absolute beginners starting their Japanese journey.',
                'price' => 49000,
            ],
            [
                'name' => 'JLPT N4 Vocabulary Pack',
                'description' => 'Expand your Japanese vocabulary with 1,500 carefully curated words for the N4 level. Includes example sentences and mnemonics.',
                'price' => 79000,
            ],
            [
                'name' => 'SAT Math Mastery',
                'description' => 'Comprehensive flashcard set covering all SAT math topics: algebra, geometry, statistics, and advanced math. Achieve 800 with confidence.',
                'price' => 89000,
            ],
            [
                'name' => 'Medical Terminology Pro',
                'description' => 'Over 2,000 medical terms, prefixes, suffixes, and root words. Essential for pre-med students and healthcare professionals.',
                'price' => 129000,
            ],
            [
                'name' => 'Spanish Conversational Phrases',
                'description' => 'Learn 500+ high-frequency conversational phrases for everyday Spanish. From greetings to complex discussions, speak naturally.',
                'price' => 59000,
            ],
            [
                'name' => 'AP World History Timeline',
                'description' => 'Chronological flashcards covering every major AP World History event, person, and concept. Boost your score with visual timelines.',
                'price' => 69000,
            ],
            [
                'name' => 'Python Programming Fundamentals',
                'description' => 'Core Python concepts, syntax, built-in functions, and data structures. Ideal for beginners and developers brushing up their skills.',
                'price' => 99000,
            ],
            [
                'name' => 'GRE Verbal 500+',
                'description' => '500+ high-frequency GRE vocabulary words with definitions, synonyms, antonyms, and usage in context. Score in the 90th percentile.',
                'price' => 109000,
            ],
        ];

        foreach ($decks as $deckData) {
            Deck::create([
                'user_id' => $user->id,
                'name' => $deckData['name'],
                'description' => $deckData['description'],
                'price' => $deckData['price'],
                'is_public' => true,
            ]);
        }

        $this->command->info('Created '.count($decks).' premium decks.');
    }
}
