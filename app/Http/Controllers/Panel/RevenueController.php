<?php

namespace App\Http\Controllers\Panel;

use App\Revenue;
use App\Http\Controllers\Controller;

class RevenueController extends Controller
{

    public function index()
    {
        $user     = request()->user();
        $revenues = Revenue::user($user->id)->latest()->paginate(10);

        view()->share('revenues', $revenues);

        return view('panel.revenue');
    }
}
