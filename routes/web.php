<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('login', LoginController::class);
Route::resource('logout', LogoutController::class);
Route::get('login/auth/{provider}', 'Login\AuthController@login');
Route::get('login/auth/{provider}/callback', 'Login\AuthController@callback');


// need auth
Route::resource('disclaim', DisclaimController::class, ['only' => 'index']);
Route::resource('dashboard', DashboardController::class);
Route::resource('revenue', RevenueController::class);
Route::resource('investment', InvestmentController::class);
Route::resource('wallet', WalletController::class);
