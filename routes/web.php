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

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/two-factor/enable', 'twoFactorController@enableTwoFactor');
Route::get('/two-factor/disable', 'twoFactorController@disableTwoFactor');
Route::get('/two-factor/validate', 'Auth\AuthController@getValidateToken');
Route::post('/two-factor/validate', ['middleware' => 'throttle:5', 'uses' => 'Auth\AuthController@postValidateToken']);*/

Route::get('/complete-registration', 'Auth\RegisterController@completeRegistration');
Route::post('/2fa', function () {
    return redirect(URL()->previous());
})->name('2fa')->middleware('2fa');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
