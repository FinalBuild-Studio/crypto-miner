<?php


Route::resource('transfer', TransferController::class, ['only' => ['index', 'update']]);
Route::resource('investment', InvestmentController::class, ['only' => ['index', 'update']]);
Route::resource('ntd', NTDController::class, ['only' => ['index', 'store']]);
Route::resource('operation', OperationController::class, ['only' => ['index']]);
