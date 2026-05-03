<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['user_id', 'name', 'slug', 'description', 'is_public'])]
class Folder extends Model
{
    protected static function booted(): void
    {
        static::creating(function (Folder $folder) {
            $folder->slug = Str::slug($folder->name);

            // Ensure uniqueness
            $originalSlug = $folder->slug;
            $counter = 1;

            while (static::where('slug', $folder->slug)->exists()) {
                $folder->slug = $originalSlug.'-'.$counter++;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function decks()
    {
        return $this->belongsToMany(Deck::class)->withPivot('tag_id')->withTimestamps();
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
