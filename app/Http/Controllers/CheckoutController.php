<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\CoreApi;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->carts()->with('items.deck')->first();
        if (! $cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $cart = auth()->user()->carts()->with('items.deck')->first();
        if (! $cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $totalAmount = $cart->items->sum(function ($item) {
            return $item->quantity * $item->deck->price;
        });

        $orderId = 'TRX-'.time().'-'.auth()->id();

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'order_id' => $orderId,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        foreach ($cart->items as $item) {
            $transaction->items()->create([
                'deck_id' => $item->deck_id,
                'deck_name' => $item->deck->name,
                'price' => $item->deck->price,
                'quantity' => $item->quantity,
            ]);
        }

        // Configure Midtrans Core API
        Config::$serverKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-xxxxxxxxxxxx');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'payment_type' => 'gopay',
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $totalAmount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'gopay' => [
                'enable_callback' => true,
                'callback_url' => route('checkout.finish'),
            ],
        ];

        try {
            $chargeResult = CoreApi::charge($params);

            $actions = collect($chargeResult->actions ?? []);
            $qrCodeUrl = optional($actions->first(fn ($a) => $a->name === 'generate-qr-code'))->url;
            $deeplinkUrl = optional($actions->first(fn ($a) => $a->name === 'deeplink-redirect'))->url;

            // Clear cart
            $cart->items()->delete();

            return view('checkout.payment', compact('transaction', 'qrCodeUrl', 'deeplinkUrl'));
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Checkout failed: '.$e->getMessage());
        }
    }

    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status;

        $transaction = Transaction::where('order_id', $orderId)->firstOrFail();

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $transaction->update(['status' => 'success']);
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $transaction->update(['status' => 'failed']);
        } elseif ($transactionStatus == 'pending') {
            $transaction->update(['status' => 'pending']);
        }

        return redirect()->route('transactions.index')->with('success', 'Payment status updated.');
    }
}
