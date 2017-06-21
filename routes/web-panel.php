<?php


Route::resource('disclaim', DisclaimController::class, ['only' => 'index']);
Route::resource('dashboard', DashboardController::class);
Route::resource('revenue', RevenueController::class);
Route::resource('investment', InvestmentController::class);
Route::resource('wallet', WalletController::class);
Route::resource('transfer', TransferController::class);
