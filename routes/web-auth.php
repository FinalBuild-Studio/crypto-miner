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

Route::resource('login', LoginController::class, ['only' => ['index', 'store']]);
Route::resource('logout', LogoutController::class, ['only' => 'store']);
Route::get('login/{provider}', 'Login\AuthController@login');
Route::get('login/{provider}/callback', 'Login\AuthController@callback');
