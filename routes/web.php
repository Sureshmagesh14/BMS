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
Route::any('get_all_banks', 'SettingsController@get_all_banks')->name('get_all_banks');
Route::any('create_bank', 'SettingsController@create_bank')->name('create_bank');

Route::get('contents','SettingsController@contents')->name('contents');
Route::any('get_all_contents', 'SettingsController@get_all_contents')->name('get_all_contents');

Route::get('networks','SettingsController@networks')->name('networks');
Route::any('get_all_networks', 'SettingsController@get_all_networks')->name('get_all_networks');

Route::get('charities','SettingsController@charities')->name('charities');
Route::any('get_all_charities', 'SettingsController@get_all_charities')->name('get_all_charities');

Route::get('groups','SettingsController@groups')->name('groups');
Route::any('get_all_groups', 'SettingsController@get_all_groups')->name('get_all_groups');

Route::get('rewards','RewardsController@rewards')->name('rewards');
Route::any('get_all_rewards', 'RewardsController@get_all_rewards')->name('get_all_rewards');

Route::get('tags','TagsController@tags')->name('tags');
Route::any('get_all_tags', 'TagsController@get_all_tags')->name('get_all_tags');

Route::get('respondents','RespondentsController@respondents')->name('respondents');
Route::any('get_all_respondents', 'RespondentsController@get_all_respondents')->name('get_all_respondents');

Route::get('projects','ProjectsController@projects')->name('projects');
Route::any('get_all_projects', 'ProjectsController@get_all_projects')->name('get_all_projects');

Route::get('actions','ActionController@actions')->name('actions');
Route::any('get_all_actions', 'ActionController@get_all_actions')->name('get_all_actions');

Route::get('cashouts','CashoutsController@cashouts')->name('cashouts');
Route::any('get_all_cashouts', 'CashoutsController@get_all_cashouts')->name('get_all_cashouts');

Route::get('users','UsersController@users')->name('users');
Route::any('get_all_users', 'UsersController@get_all_users')->name('get_all_users');