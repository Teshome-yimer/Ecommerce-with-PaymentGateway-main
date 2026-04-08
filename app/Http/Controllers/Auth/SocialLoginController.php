<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::updateOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name'        => $socialUser->getName() ?? $socialUser->getNickname(),
                    'provider_id' => $socialUser->getId(),
                    'provider'    => $provider,
                    'avatar'      => $socialUser->getAvatar(),
                    'password'    => encrypt(Str::random(24)),
                ]
            );

            Auth::login($user);
            return redirect()->intended('home');

        } catch (\Exception $e) {
            return redirect('login')->with('error', 'Login with ' . ucfirst($provider) . ' failed. Please try again.');
        }
    }
}
