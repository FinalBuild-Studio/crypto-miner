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
        $investments = Investment::user($user->id)->latest()->paginate(10);

        view()->share('investments', $investments);

        return view('panel.investment');
    }

    public function store()
    {
        $user     = request()->user();
        $amount   = request()->input('amount');
        $currency = request()->input('currency');
        $currency = Currency::name($currency)->firstOrFail();

        if (!$currency->is_crypto) {
            throw new GeneralException(100);
        }

        if (($amount / $currency->unit_price) !== 0) {
            throw new GeneralException(103);
        }

        Investment::createOrFail([
            'amount'      => $amount,
            'currency_id' => $currency->id,
            'user_id'     => $user->id,
        ]);

        return back();
    }
}
