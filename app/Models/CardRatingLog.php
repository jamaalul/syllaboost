<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'card_id', 'deck_id', 'rating', 'rated_at'])]
class CardRatingLog extends Model
{
    /** @var bool Disable auto-managed created_at / updated_at. */
    public $timestamps = false;

    /** @var array<string, string> */
    protected $casts = [
        'rated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }
}
