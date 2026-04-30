<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'name', 'description', 'is_public'])]
class Deck extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cards() {
        return $this->hasMany(Card::class)->orderBy('order');
    }
}
