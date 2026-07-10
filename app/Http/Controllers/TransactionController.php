<?php

namespace App\Http\Controllers;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = auth()->user()->transactions()->with('items')->latest()->paginate(10);

        return view('transactions.index', compact('transactions'));
    }
}
