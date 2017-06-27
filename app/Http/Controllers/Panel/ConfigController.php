<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

class ConfigController extends Controller
{

    public function index()
    {
        $user = request()->user();

        form([
            'name'         => $user->name,
            'bank_code'    => $user->bank_code,
            'bank_account' => $user->bank_account,
        ]);

        return view('panel.config');
    }

    public function store()
    {
        $name        = request()->input('name');
        $bankCode    = request()->input('bank_code');
        $bankAccount = request()->input('bank_account');

        $user = request()->user();

        $user->name         = $name;
        $user->bank_code    = $bankCode;
        $user->bank_account = $bankAccount;

        $user->save();

        return back()->with('success', '使用者資訊更新完畢');
    }
}
