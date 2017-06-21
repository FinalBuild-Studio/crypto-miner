<?php

namespace App\Http\Controllers\Panel;

use App\Transfer;
use App\Http\Controllers\Controller;

class TransferController extends Controller
{

    public function index()
    {
        $user      = request()->user();
        $transfers = Transfer::user($user->id)->latest()->paginate(10);

        view()->share('transfers', $transfers);

        return view('panel.transfer');
    }
}
