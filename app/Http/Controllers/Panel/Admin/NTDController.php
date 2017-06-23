<?php

namespace App\Http\Controllers\Panel\Admin;

use App\{User, Wallet, Currency};
use App\Http\Controllers\Controller;

class NTDController extends Controller
{

    public function index()
    {
        $email = request()->query('email');

        $users = User::email($email)->get();

        view()->share('users', $users);

        return view('panel.admin.ntd');
    }

    public function store()
    {
        $userId = request()->input('user_id');

        $amount = Wallet::who($userId)
            ->currencyType(Currency::TWD)
            ->sum('amount');

        if ($amount) {
            Wallet::create([
                'amount'      => - $amount,
                'user_id'     => $userId,
                'currency_id' => Currency::TWD,
            ]);
        }

        return back()->with('success', '處理完成，請確認！');
    }
}
