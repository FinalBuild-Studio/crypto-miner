<?php

return [
    App\Exceptions\GeneralException::class => [
        100 => '無法對一般貨幣操作',
        101 => '剩餘金額不足',
        102 => '必須大於最低提領金額, ETH: 0.1 / BTC: 0.001',
        103 => '投注金額請以最低單位的備註為單位',
    ]
];
