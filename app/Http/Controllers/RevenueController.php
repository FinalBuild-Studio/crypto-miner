<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RevenueController extends Controller
{

    public function index()
    {
        return view('revenue');
    }

    public function store()
    {
        $type  = request()->input('type');
        $price = request()->input('price');
    }
}
