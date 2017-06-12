<?php

namespace App\Http\Controllers;

use Auth;
use Exception;

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
            ->action('LoginController@index');
    }
}
