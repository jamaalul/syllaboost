<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::factory(10)->create([
            'image_path' => 'https://dummyimage.com/600x400/000/fff',
        ]);
    }
}
