<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PendingController extends Controller
{

    public function index()
    {
        return view('pending');
    }
}
