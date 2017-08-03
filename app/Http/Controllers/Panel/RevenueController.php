<?php

namespace App\Http\Controllers\Panel;

use DB;
use App\{Revenue, User, Reason};
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;

class RevenueController extends Controller
{

    public function index()
    {
        $user     = request()->user();
        $revenues = Revenue::user($user->id)->latest()->paginate(10);

        view()->share('revenues', $revenues);

        return view('panel.revenue');
    }

    public function store()
    {
        $user      = request()->user();
        $recipient = request()->input('recipient');
        $amount    = request()->input('amount');
        $type      = request()->input('type');

        $total = Revenue::user($user->id)->currencyType($type)->sum('amount');

        if ($amount > $total || $amount < 0) {
            throw new GeneralException(101);
        }

        $recipient = User::whereId($recipient)->firstOrFail();

        DB::transaction(function() use ($user, $recipient, $type, $amount) {
            Revenue::create([
                'user_id'     => $user->id,
                'amount'      => - $amount,
                'currency_id' => $type,
                'reason_id'   => Reason::SEND,
            ]);

            Reason::create([
                'user_id'     => $recipient->id,
                'amount'      => $amount,
                'currency_id' => $type,
                'reason_id'   => Reason::RECEIVE,
            ]);
        });

        return back();
    }
}
