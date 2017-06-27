<?php

namespace App\Http\Controllers\Auth\Login;

use Auth;
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
        $uid      = $user->id;
        $platform = $provider;
        $user     = User::firstOrCreate(compact('uid', 'platform'))
            ->update(compact('name', 'email'));

        Auth::login($user);

        return redirect()->action('Panel\DashboardController@index');
    }
}
