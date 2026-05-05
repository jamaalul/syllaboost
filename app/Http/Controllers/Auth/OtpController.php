<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class OtpController extends Controller
{
    public function show(Request $request)
    {
        if (! $request->session()->has('email')) {
            return redirect()->route('login');
        }

        return view('auth.otp', ['email' => $request->session()->get('email')]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $email = $request->session()->get('email');

        if (! $email) {
            return redirect()->route('login');
        }
        $cachedOtp = Cache::get('otp_'.$email);

        if (! $cachedOtp || $cachedOtp !== $request->otp) {
            throw ValidationException::withMessages([
                'otp' => 'The provided OTP is incorrect or has expired.',
            ]);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->route('register');
        }

        if (is_null($user->email_verified_at)) {
            $user->markEmailAsVerified();
        }

        Auth::login($user, $request->boolean('remember'));
        Cache::forget('otp_'.$email);
        $request->session()->forget('email');
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function resend(Request $request)
    {
        if (! $request->session()->has('email')) {
            return redirect()->route('login');
        }

        $email = $request->session()->get('email');
        $otp = (string) random_int(100000, 999999);
        Cache::put('otp_'.$email, $otp, now()->addMinutes(10));

        Mail::to($email)->send(new SendOtpMail($otp));

        return back()->with('status', 'A new code has been sent to your email.');
    }
}
