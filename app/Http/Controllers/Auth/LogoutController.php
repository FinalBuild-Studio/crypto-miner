<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Exception;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{

    public function store()
    {
        try {
            Auth::logout();
        } catch (Exception $e) {
            // do nothing
        }

        return redirect()
            ->action('Auth\LoginController@index');
    }
}
