<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Deck;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->carts()->with('items.deck')->first();

        return view('cart.index', compact('cart'));
    }

    public function store(Request $request, Deck $deck)
    {
        $cart = auth()->user()->carts()->firstOrCreate(['user_id' => auth()->id()]);

        $item = $cart->items()->where('deck_id', $deck->id)->first();
        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'deck_id' => $deck->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Added to cart.');
    }

    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }
        $cartItem->delete();

        return redirect()->back()->with('success', 'Removed from cart.');
    }
}
