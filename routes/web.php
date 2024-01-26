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
Route::get('/survey','SurveyController@folder')->name('survey');
Route::post('/survey/folders', ['as' => 'survery.folders','uses' => 'SurveyController@getFolderList',])->middleware(['auth']);
Route::get('/survey/folders/create', ['as' => 'folder.create','uses' => 'SurveyController@createFolder',])->middleware(['auth']);
Route::get('/survey/folders/edit/{id}', ['as' => 'folder.edit','uses' => 'SurveyController@editFolder',])->middleware(['auth']);
Route::post('/survey/folders/delete/{id}', ['as' => 'folder.delete','uses' => 'SurveyController@getFolderList',])->middleware(['auth']);