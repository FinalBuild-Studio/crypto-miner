<?php

namespace App\Http\Controllers\Panel\Admin;

use App\Http\Controllers\Controller;

class OperationController extends Controller
{

    public function index()
    {
        return view('panel.admin.operation');
    }
}
