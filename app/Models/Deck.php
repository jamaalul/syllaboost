<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['user_id', 'name', 'slug', 'description', 'is_public', 'fork_count'])]
class Deck extends Model
{
    protected static function booted(): void
    {
        static::creating(function (Deck $deck) {
            $deck->slug = Str::slug($deck->name);

            // Ensure uniqueness
            $originalSlug = $deck->slug;
            $counter = 1;

            while (static::where('slug', $deck->slug)->exists()) {
                $deck->slug = $originalSlug.'-'.$counter++;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class)->orderBy('order');
    }

    public function folders()
    {
        return $this->belongsToMany(Folder::class)->withPivot('tag_id')->withTimestamps();
    }
}
