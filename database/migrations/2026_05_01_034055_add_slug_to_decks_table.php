<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        // Fill slugs for existing decks
        DB::table('decks')->get()->each(function ($deck) {
            DB::table('decks')
                ->where('id', $deck->id)
                ->update(['slug' => Str::slug($deck->name).'-'.$deck->id]);
        });

        Schema::table('decks', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
