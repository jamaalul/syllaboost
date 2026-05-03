<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'folder_id'])]
class Tag extends Model
{
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function decks()
    {
        return $this->belongsToMany(Deck::class);
    }
}
