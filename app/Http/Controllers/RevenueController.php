<?php

namespace App\Http\Controllers;

use App\Revenue;

class RevenueController extends Controller
{

    public function index()
    {
        $user     = request()->user();
        $revenues = Revenue::user($user->id)->paginate(10);

        view()->share('revenues', $revenues);

        return view('revenue');
    }
}
