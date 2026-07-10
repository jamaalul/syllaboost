<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['transaction_id', 'deck_id', 'deck_name', 'price', 'quantity'])]
class TransactionItem extends Model
{
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }
}
