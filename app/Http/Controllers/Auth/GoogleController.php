<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }

            $otp = (string) random_int(100000, 999999);
            Cache::put('otp_'.$user->email, $otp, now()->addMinutes(10));

            Mail::to($user->email)->send(new SendOtpMail($otp));

            session()->put('email', $user->email);

            return redirect()->route('otp.show');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Failed to log in with Google. Please try again.']);
        }
    }
}
