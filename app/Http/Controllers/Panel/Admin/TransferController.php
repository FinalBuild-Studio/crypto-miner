<?php

namespace App\Http\Controllers\Panel\Admin;

use App\Transfer;
use App\Http\Controllers\Controller;

class TransferController extends Controller
{

    public function index()
    {
        $transfers = Transfer::wating()->latest()->paginate(10);

        view()->share('transfers', $transfers);

        return view('panel.admin.transfer');
    }
}
