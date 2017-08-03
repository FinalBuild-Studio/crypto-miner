<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{

    public const REVENUE     = 1;
    public const TRANSFER    = 2;
    public const MAINTENANCE = 3;
    public const SEND        = 4;
    public const RECEIVE     = 5;
}
