<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['deck_id', 'front_content', 'back_content', 'order'])]
class Card extends Model
{
    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }
}
