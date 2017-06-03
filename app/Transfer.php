<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{

    public const WAITING    = 0;
    public const PROCESSING = 1;
    public const DONE       = 2;

    protected $fillable = [
        'amount',
        'currency_id',
        'user_id',
        'price_at',
    ];
}
