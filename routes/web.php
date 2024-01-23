<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/','CustomAuthController@index')->name('login');
Route::any('custom-login','CustomAuthController@customLogin')->name('login.custom');
Route::get('register','CustomAuthController@registration')->name('register');
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard','CustomAuthController@dashboard')->name('dashboard');
   
    Route::post('custom-registration','CustomAuthController@customRegistration')->name('register.custom');
    Route::get('signout','CustomAuthController@signOut')->name('signout');
    
    Route::get('banks','SettingsController@banks')->name('banks');
    Route::any('get_all_banks', 'SettingsController@get_all_banks')->name('get_all_banks');
    Route::any('create_bank', 'SettingsController@create_bank')->name('create_bank');
    
  
 
    
    Route::get('networks','SettingsController@networks')->name('networks');
    Route::any('get_all_networks', 'SettingsController@get_all_networks')->name('get_all_networks');
    
    Route::get('charities','SettingsController@charities')->name('charities');
    Route::any('get_all_charities', 'SettingsController@get_all_charities')->name('get_all_charities');
   
    Route::get('groups','SettingsController@groups')->name('groups');
    Route::any('get_all_groups', 'SettingsController@get_all_groups')->name('get_all_groups');
    
    Route::get('rewards','RewardsController@rewards')->name('rewards');
    Route::any('get_all_rewards', 'RewardsController@get_all_rewards')->name('get_all_rewards');

    Route::get('contents','SettingsController@contents')->name('contents');
    Route::any('get_all_contents', 'SettingsController@get_all_contents')->name('get_all_contents');
    Route::get('create_contents','SettingsController@create_contents')->name('create_contents');
    Route::post('save_contents','SettingsController@save_contents')->name('save_contents');
    
});


