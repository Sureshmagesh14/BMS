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

// Survey Routings

Route::get('/survey','SurveyController@survey')->name('survey');
Route::get('/survey/create', ['as' => 'survey.create','uses' => 'SurveyController@createSurvey',])->middleware(['auth']);
Route::post('/survey/survey', ['as' => 'survery.survey','uses' => 'SurveyController@getSurveyList',])->middleware(['auth']);
Route::post('/survey/store', ['as' => 'survey.store','uses' => 'SurveyController@storeSurvey',])->middleware(['auth']);
Route::get('/survey/edit/{id}', ['as' => 'survey.edit','uses' => 'SurveyController@editSurvey',])->middleware(['auth']);
Route::post('/survey/update/{id}', ['as' => 'survey.update','uses' => 'SurveyController@updateSurvey',])->middleware(['auth']);
Route::get('/survey/delete/{id}', ['as' => 'survey.delete','uses' => 'SurveyController@deleteSurvey',])->middleware(['auth']);

// Survey Template Routings
Route::get('/survey/template/{id}', ['as' => 'survey.template','uses' => 'SurveyController@templateList',])->middleware(['auth']);
Route::get('/survey/builder/{id}', ['as' => 'survey.builder','uses' => 'SurveyController@builder',])->middleware(['auth']);
Route::get('/survey/questiontype/{id}', ['as' => 'survey.questiontype','uses' => 'SurveyController@questiontype',])->middleware(['auth']);
Route::get('/survey/qustype/{survey}/{qustype}', ['as' => 'survey.qustype','uses' => 'SurveyController@questiontypesurvey',])->middleware(['auth']);
Route::get('/survey/deletequs/{id}', ['as' => 'survey.deletequs','uses' => 'SurveyController@deletequs',])->middleware(['auth']);

// Survey Questions Routings
Route::get('/survey/questions/{id}', ['as' => 'survey.quesbuilder','uses' => 'SurveyController@questionList',])->middleware(['auth']);


// Clone Survey 

Route::get('/survey/surveyduplication/{id}', ['as' => 'survey.surveyduplication','uses' => 'SurveyController@surveyduplication',])->middleware(['auth']);
