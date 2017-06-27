<?php

namespace App\Http\Controllers\Panel\Admin;

use Carbon\Carbon;
use App\{Investment, Currency};
use App\Http\Controllers\Controller;

class InvestmentController extends Controller
{

    public function index()
    {
        $investments = Investment::unconfirmed()
            ->latest()
            ->paginate(10);

        view()->share('investments', $investments);

        return view('panel.admin.investment');
    }

    public function update($id)
    {
        $status = request()->input('status');

        $expiredAt  = null;
        $investment = Investment::whereId($id)->firstOrFail();

        if ($status == Investment::ENABLED) {
            $years = Currency::whereId($investment->currency_id)
                ->firstOrFail()
                ->years;

            $expiredAt = Carbon::createFromTimestamp(strtotime('+'.$years.'years'));
        }

        $investment->update([
            'status'     => $status,
            'expired_at' => $expiredAt,
        ]);

        return back()->with('success', '資料審核完畢');
    }
}
