<?php

namespace App\Http\Controllers\Panel;

use App\Exceptions\GeneralException;
use App\{Currency, Investment};
use App\Http\Controllers\Controller;

class InvestmentController extends Controller
{

    public function index()
    {
        $user        = request()->user();
        $investments = Investment::who($user->id)->latest()->paginate(10);

        view()->share('investments', $investments);

        return view('panel.investment');
    }

    public function store()
    {
        $user     = request()->user();
        $amount   = request()->input('amount');
        $currency = request()->input('currency');
        $code     = request()->input('code');
        $currency = Currency::name($currency)->firstOrFail();

        if (!$currency->is_crypto) {
            throw new GeneralException(100);
        }

        $unit = fmod($amount, $currency->unit_price);

        if (($unit != 0 || $unit != $currency->unit_price) && $amount > 0) {
            throw new GeneralException(103);
        }

        Investment::create([
            'amount'      => $amount,
            'currency_id' => $currency->id,
            'user_id'     => $user->id,
            'code'        => $code,
        ]);

        return back()->with('success', '已經申請完成，相關聯絡以及匯款程序請參考聲明頁面');
    }
}
