<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatingRequest;
use App\Models\Card;
use App\Models\CardRatingLog;
use App\Models\CardStudyProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(StoreRatingRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Verify card belongs to the given deck
        $cardExists = Card::where('id', $validated['card_id'])
            ->where('deck_id', $validated['deck_id'])
            ->exists();

        if (! $cardExists) {
            return response()->json([
                'success' => false,
                'message' => 'Card does not belong to the specified deck.',
            ], 404);
        }

        $log = CardRatingLog::create([
            'user_id' => Auth::id(),
            'card_id' => $validated['card_id'],
            'deck_id' => $validated['deck_id'],
            'rating' => $validated['rating'],
        ]);

        if (isset($validated['is_srs']) && $validated['is_srs']) {
            $progress = CardStudyProgress::firstOrNew([
                'user_id' => Auth::id(),
                'card_id' => $validated['card_id'],
            ], [
                'deck_id' => $validated['deck_id'],
                'box' => 1,
            ]);

            if ($validated['rating'] === 'learned') {
                $progress->box = min(5, $progress->box + 1);
            } else {
                $progress->box = 1;
            }

            $intervals = [
                1 => 1,
                2 => 3,
                3 => 7,
                4 => 14,
                5 => 30,
            ];

            $days = $intervals[$progress->box] ?? 1;

            if ($validated['rating'] === 'learned') {
                $progress->next_review_at = now()->addDays($days);
            } else {
                $progress->next_review_at = now();
            }

            $progress->save();
        }

        return response()->json([
            'success' => true,
            'rating_id' => $log->id,
            'rated_at' => $log->rated_at->toIso8601String(),
        ], 201);
    }
}
