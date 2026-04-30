<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['deck_id', 'front_content', 'back_content', 'order'])]
class Card extends Model
{
    public function deck() {
        return $this->belongsTo(Deck::class);
    }
}
