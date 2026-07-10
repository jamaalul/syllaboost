@extends('layouts.dashboard')
@section('title', 'Complete Payment \ Syllaboost')
@section('main')
<div class="flex flex-col gap-6">

    {{-- Page Header --}}
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-zinc-900">Complete Payment</h1>
        <a href="{{ route('transactions.index') }}" class="text-sm text-zinc-500 hover:text-zinc-800 transition-colors font-medium flex items-center gap-1.5">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            My Transactions
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- QR Code Panel --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <div class="bg-zinc-50 border-b border-zinc-200 px-6 py-3">
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400">Scan to Pay &middot; GoPay / QRIS</p>
            </div>
            <div class="flex flex-col items-center gap-6 px-6 py-10">

                @if($qrCodeUrl)
                    {{-- QR Code Image --}}
                    <div class="relative">
                        <div id="qr-wrapper" class="bg-white border-2 border-zinc-200 rounded-2xl p-4 shadow-sm transition-all duration-300">
                            <img id="qr-image" src="{{ $qrCodeUrl }}" alt="GoPay / QRIS QR Code"
                                class="w-56 h-56 rounded-xl object-contain" />
                        </div>
                        {{-- Expired overlay --}}
                        <div id="qr-expired" class="hidden absolute inset-0 flex flex-col items-center justify-center bg-white/90 rounded-2xl gap-3">
                            <svg class="size-10 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <p class="text-sm font-semibold text-zinc-600">QR Code Expired</p>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-1 text-center">
                        <p class="text-sm font-semibold text-zinc-700">Open your GoPay, Gojek, or any QRIS app</p>
                        <p class="text-xs text-zinc-400">Use "Scan to Pay" and scan the QR code above</p>
                    </div>

                    {{-- Timer --}}
                    <div class="flex items-center gap-2 bg-amber-50 border border-amber-200 rounded-xl px-4 py-2.5">
                        <svg class="size-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-xs font-semibold text-amber-700">Expires in <span id="countdown">15:00</span></span>
                    </div>

                @else
                    {{-- No QR fallback --}}
                    <div class="flex flex-col items-center gap-3 py-8 text-center">
                        <svg class="size-12 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <p class="text-zinc-500 font-medium">QR code unavailable</p>
                        <p class="text-xs text-zinc-400">Please use the deeplink button below or contact support.</p>
                    </div>
                @endif

                {{-- Deeplink (mobile) --}}
                @if($deeplinkUrl)
                    <a href="{{ $deeplinkUrl }}" id="deeplink-btn"
                        class="flex items-center gap-2.5 bg-zinc-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-zinc-800 hover:scale-[1.02] active:scale-100 transition-all duration-150 text-sm">
                        <svg class="size-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.7 9.05 7.42c1.55.07 2.63.82 3.54.86 1.36-.27 2.66-1.04 4.1-.9 1.7.18 2.97.9 3.8 2.28-3.44 2.1-2.88 6.56.56 7.93-.5 1.29-1.09 2.55-2 3.69M13 3.5c.16 1.96-1.42 3.53-3.35 3.5C9.4 5.1 11.12 3.34 13 3.5z" />
                        </svg>
                        Open GoPay / Gojek App
                    </a>
                @endif

                {{-- Status badge --}}
                <div id="status-badge" class="hidden items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold border">
                    <span id="status-icon"></span>
                    <span id="status-text"></span>
                </div>

            </div>
        </div>

        {{-- Order Details Panel --}}
        <div class="bg-white rounded-2xl border border-zinc-200 overflow-hidden">
            <div class="bg-zinc-50 border-b border-zinc-200 px-6 py-3">
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400">Order Details</p>
            </div>
            <div class="p-6 flex flex-col gap-4">

                <div class="flex justify-between items-center text-sm text-zinc-500">
                    <span>Order ID</span>
                    <span class="font-mono font-medium text-zinc-700 text-xs">{{ $transaction->order_id }}</span>
                </div>

                <div class="flex justify-between items-center text-sm text-zinc-500">
                    <span>Payment Method</span>
                    <span class="font-medium text-zinc-700">GoPay / QRIS</span>
                </div>

                <div class="border-t border-zinc-200 pt-4 flex justify-between items-center">
                    <span class="font-bold text-zinc-900">Total</span>
                    <span class="font-bold text-2xl text-emerald-600">
                        Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                    </span>
                </div>

                {{-- How to pay steps --}}
                <div class="bg-zinc-50 rounded-xl p-4 flex flex-col gap-3 mt-2">
                    <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400">How to pay</p>
                    @foreach([
                        ['icon' => '1', 'text' => 'Open GoPay, Gojek, or any QRIS-compatible app'],
                        ['icon' => '2', 'text' => 'Tap "Scan" and scan the QR code'],
                        ['icon' => '3', 'text' => 'Confirm payment and enter your PIN'],
                        ['icon' => '4', 'text' => "Payment confirmed — you're all set!"],
                    ] as $step)
                    <div class="flex items-start gap-3">
                        <span class="flex items-center justify-center size-5 rounded-full bg-zinc-200 text-zinc-600 text-xs font-bold shrink-0 mt-0.5">{{ $step['icon'] }}</span>
                        <p class="text-xs text-zinc-500 leading-relaxed">{{ $step['text'] }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-center gap-2 text-zinc-400 text-xs mt-1">
                    <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Secure payment &middot; Powered by Midtrans</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // ── Countdown Timer (15 minutes) ────────────────────────────────────────
    (function () {
        let seconds = 15 * 60;
        const el = document.getElementById('countdown');
        const expiredOverlay = document.getElementById('qr-expired');
        const qrWrapper = document.getElementById('qr-wrapper');

        const tick = setInterval(() => {
            seconds--;
            if (seconds <= 0) {
                clearInterval(tick);
                if (el) el.textContent = '00:00';
                if (expiredOverlay) expiredOverlay.classList.remove('hidden');
                if (qrWrapper) qrWrapper.classList.add('opacity-40');
                return;
            }
            const m = String(Math.floor(seconds / 60)).padStart(2, '0');
            const s = String(seconds % 60).padStart(2, '0');
            if (el) el.textContent = `${m}:${s}`;
        }, 1000);
    })();

    // ── Payment Status Polling ───────────────────────────────────────────────
    (function () {
        const orderId = @json($transaction->order_id);
        const finishUrl = @json(route('checkout.finish'));
        const statusBadge = document.getElementById('status-badge');
        const statusIcon = document.getElementById('status-icon');
        const statusText = document.getElementById('status-text');

        function showStatus(type, message) {
            if (!statusBadge) return;
            statusBadge.classList.remove('hidden');
            statusBadge.classList.add('flex');

            const styles = {
                pending: { badge: 'bg-amber-50 border-amber-200 text-amber-700', icon: '⏳' },
                success: { badge: 'bg-emerald-50 border-emerald-200 text-emerald-700', icon: '✅' },
                failed:  { badge: 'bg-red-50 border-red-200 text-red-700', icon: '❌' },
            };
            const s = styles[type] || styles.pending;
            statusBadge.className = `flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold border ${s.badge}`;
            statusIcon.textContent = s.icon;
            statusText.textContent = message;
        }

        let pollCount = 0;
        const maxPolls = 90; // 15 minutes at 10s interval

        const poll = setInterval(async () => {
            pollCount++;
            if (pollCount >= maxPolls) {
                clearInterval(poll);
                showStatus('failed', 'Payment window expired. Please try again.');
                return;
            }

            try {
                const res = await fetch(`/checkout/status/${encodeURIComponent(orderId)}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!res.ok) return;
                const data = await res.json();

                if (data.status === 'success' || data.transaction_status === 'settlement' || data.transaction_status === 'capture') {
                    clearInterval(poll);
                    showStatus('success', 'Payment successful! Redirecting…');
                    setTimeout(() => {
                        window.location.href = finishUrl + `?order_id=${encodeURIComponent(orderId)}&transaction_status=settlement`;
                    }, 1500);
                } else if (data.status === 'failed' || data.transaction_status === 'cancel' || data.transaction_status === 'expire' || data.transaction_status === 'deny') {
                    clearInterval(poll);
                    showStatus('failed', 'Payment failed or cancelled.');
                } else {
                    showStatus('pending', 'Waiting for payment…');
                }
            } catch (_) {
                // silent — network hiccups are expected
            }
        }, 10000); // poll every 10 seconds
    })();
</script>
@endsection
