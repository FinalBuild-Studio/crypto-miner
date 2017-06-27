<?php


Route::resource('withdraw', WithdrawController::class, ['only' => 'store']);
Route::resource('revenue', RevenueController::class, ['only' => 'store']);
