<?php


Route::resource('disclaim', DisclaimController::class, ['only' => 'index']);
Route::resource('dashboard', DashboardController::class, ['only' => 'index']);
Route::resource('revenue', RevenueController::class, ['only' => 'index']);
Route::resource('investment', InvestmentController::class, ['only' => ['index', 'store']]);
Route::resource('wallet', WalletController::class, ['only' => 'index']);
Route::resource('transfer', TransferController::class, ['only' => 'index']);
Route::resource('config', ConfigController::class, ['only' => ['store', 'index']]);
