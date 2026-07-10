<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['cart_id', 'deck_id', 'quantity'])]
class CartItem extends Model
{
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }
}
