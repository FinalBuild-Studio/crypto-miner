<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

class DisclaimController extends Controller
{

    public function index()
    {
        return view('panel.disclaim');
    }
}
