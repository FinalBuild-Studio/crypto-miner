<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{

    public const WAITING    = 0;
    public const PROCESSING = 1;

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $fillable = [
        'amount',
        'currency_id',
        'user_id',
        'price_at',
    ];
}
