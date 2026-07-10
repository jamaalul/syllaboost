<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Deck;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'decks' => Deck::count(),
            'articles' => Article::count(),
            'transactions' => Transaction::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
