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
// Survey Folder Routings
Route::get('/survey/folders','SurveyController@folder')->name('folder');
Route::post('/survey/folders', ['as' => 'survery.folders','uses' => 'SurveyController@getFolderList',])->middleware(['auth']);
Route::get('/survey/folders/create', ['as' => 'folder.create','uses' => 'SurveyController@createFolder',])->middleware(['auth']);
Route::post('/survey/folders/store', ['as' => 'folder.store','uses' => 'SurveyController@storeFolder',])->middleware(['auth']);
Route::get('/survey/folders/edit/{id}', ['as' => 'folder.edit','uses' => 'SurveyController@editFolder',])->middleware(['auth']);
Route::post('/survey/folders/update/{id}', ['as' => 'folder.update','uses' => 'SurveyController@updateFolder',])->middleware(['auth']);
Route::get('/survey/folders/delete/{id}', ['as' => 'folder.delete','uses' => 'SurveyController@deleteFolder',])->middleware(['auth']);
