<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRatingRequest;
use App\Models\Card;
use App\Models\CardRatingLog;
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

        return response()->json([
            'success' => true,
            'rating_id' => $log->id,
            'rated_at' => $log->rated_at->toIso8601String(),
        ], 201);
    }
}
