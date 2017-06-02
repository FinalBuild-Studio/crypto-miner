<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    public const ETH = 1;
    public const BTC = 2;
    public const USD = 3;
    public const TWD = 4;

    protected $casts = [
        'is_crypto' => 'boolean',
    ];

    public function scopeName($query, $name)
    {
        return $query->where('name', '=', $name)->firstOrFail();
    }
}
