<?php


Route::resource('/', IndexController::class, ['only' => 'index']);
Route::resource('privacy', PrivacyController::class, ['only' => 'index']);
