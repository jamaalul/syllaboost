<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['title', 'slug', 'content', 'image_path', 'is_published', 'published_at'])]
class Article extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Article $article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
                $originalSlug = $article->slug;
                $counter = 1;
                while (static::where('slug', $article->slug)->exists()) {
                    $article->slug = $originalSlug.'-'.$counter++;
                }
            }
        });
    }
}
