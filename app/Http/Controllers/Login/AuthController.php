<?php

namespace App\Http\Controllers\Login;

use Socialite;
use App\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function login($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $user     = Socialite::driver($provider)->user();
        $name     = $user->name;
        $email    = $user->email;
        $platform = $provider;
        $user     = User::firstOrCreate(compact('name', 'email', 'platform'));

        Auth::login($user);

        return redirect()->action('DashboardController@index');
    }
}
