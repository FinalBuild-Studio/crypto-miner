<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvestmentController extends Controller
{

    public function index()
    {

    }

    public function store()
    {
        $usd = request()->input('usd');
    }
}
