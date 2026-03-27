<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('provider_id', $user->id)->first();

            if($finduser){
                Auth::login($finduser);
                return redirect()->intended('home');
            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                    'name' => $user->name,
                    'provider_id'=> $user->id,
                    'provider' => 'google',
                    'avatar' => $user->avatar,
                    'password' => encrypt(Str::random(24))
                ]);

                Auth::login($newUser);
                return redirect()->intended('home');
            }
        } catch (\Exception $e) {
            return redirect('login')->with('error', 'Something went wrong!');
        }
    }
}