<?php

namespace App\Http\Controllers\Panel\Admin;

use App\Transfer;
use App\Http\Controllers\Controller;

class TransferController extends Controller
{

    public function index()
    {
        $transfers = Transfer::waiting()->latest()->paginate(10);

        view()->share('transfers', $transfers);

        return view('panel.admin.transfer');
    }

    public function update($id)
    {
        $status = request()->input('status');

        Transfer::whereId($id)
            ->firstOrFail()
            ->update(compact('status'));

        return back()->with('success', '待轉帳資料已經處理完畢');
    }
}
