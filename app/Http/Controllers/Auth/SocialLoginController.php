<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialLoginController extends Controller
{
    private array $providers = ['google', 'github'];

    public function redirect($provider)
    {
        if (! in_array($provider, $this->providers, true)) {
            abort(404);
        }

        if (! config("services.{$provider}.client_id") || ! config("services.{$provider}.client_secret")) {
            return redirect('login')->with(
                'error',
                ucfirst($provider) . ' login is not configured. Please contact the admin.'
            );
        }

        return Socialite::driver($provider)
            ->redirectUrl($this->callbackUrl($provider))
            ->redirect();
    }

    public function callback($provider)
    {
        if (! in_array($provider, $this->providers, true)) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)
                ->redirectUrl($this->callbackUrl($provider))
                ->user();

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

            return redirect()->intended('/');
        } catch (\Exception $e) {
            report($e);

            return redirect('login')->with(
                'error',
                'Login with ' . ucfirst($provider) . ' failed. Please try again.'
            );
        }
    }

    private function callbackUrl(string $provider): string
    {
        return rtrim(config('app.url'), '/') . "/auth/{$provider}/callback";
    }
}
