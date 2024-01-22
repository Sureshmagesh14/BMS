<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/','CustomAuthController@index')->name('login');

Route::get('dashboard','CustomAuthController@dashboard')->name('dashboard');
Route::any('custom-login','CustomAuthController@customLogin')->name('login.custom');
Route::get('register','CustomAuthController@registration')->name('register');
Route::post('custom-registration','CustomAuthController@customRegistration')->name('register.custom');
Route::get('signout','CustomAuthController@signOut')->name('signout');

Route::get('banks','SettingsController@banks')->name('banks');

Route::get('add_banks','SettingsController@add_banks')->name('add_banks');
Route::any('get_all_banks', 'SettingsController@get_all_banks')->name('get_all_banks');