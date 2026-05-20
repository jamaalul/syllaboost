<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'card_id' => ['required', 'integer', 'exists:cards,id'],
            'deck_id' => ['required', 'integer', 'exists:decks,id'],
            'rating' => ['required', 'string', Rule::in(['learned', 'still_learning'])],
            'is_srs' => ['sometimes', 'boolean'],
        ];
    }
}
