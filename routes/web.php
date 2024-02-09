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

    Route::resource('contents', 'ContentsController');
    Route::get('contents_datatable', 'ContentsController@contents_datatable')->name('contents_datatable');
    Route::any('contents_multi_delete', 'ContentsController@contents_multi_delete')->name('contents_multi_delete');

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

Route::post('/survey/questions/{id}', ['as' => 'survey.qus.update','uses' => 'SurveyController@updateQus',])->middleware(['auth']);
    Route::resource('networks', 'NetworkController');
    Route::get('get_all_networks', 'NetworkController@get_all_networks')->name('get_all_networks');

    Route::resource('charities','CharitiesController');
    Route::any('get_all_charities', 'CharitiesController@get_all_charities')->name('get_all_charities');

    Route::resource('banks','BankController');
    Route::any('get_all_banks', 'BankController@get_all_banks')->name('get_all_banks');

    Route::resource('groups','ProfileGroupController');
    Route::any('get_groups_banks', 'ProfileGroupController@get_groups_banks')->name('get_groups_banks');

    Route::resource('tags','TagsController');
    Route::any('get_all_tags', 'TagsController@get_all_tags')->name('get_all_tags');
    Route::get('tags_export/{id}','TagsController@tags_export')->name('tags_export'); 

    Route::resource('respondents','RespondentsController');
    Route::any('get_all_respondents', 'RespondentsController@get_all_respondents')->name('get_all_respondents');
    Route::get('respondent_export/{id}','RespondentsController@respondent_export')->name('respondent_export');   
    Route::get('gen_respondent_res_export','RespondentsController@gen_respondent_res_export')->name('gen_respondent_res_export');   
    Route::get('gen_respondent_mon_export','RespondentsController@gen_respondent_mon_export')->name('gen_respondent_mon_export');    

    Route::resource('projects','ProjectsController');
    Route::any('get_all_projects', 'ProjectsController@get_all_projects')->name('get_all_projects');
    Route::get('projects_export/{id}','ProjectsController@projects_export')->name('projects_export');  
    
    Route::resource('users','UsersController');
    Route::any('get_all_users', 'UsersController@get_all_users')->name('get_all_users');
    Route::get('export_user_activity','UsersController@export_user_activity')->name('export_user_activity');
    Route::get('export_referrals','UsersController@export_referrals')->name('export_referrals');  
    

    Route::controller(SettingsController::class)->group(function(){
        /* Content */
     

        /* Bank */
  
   

        
    
      
      
      

  
    

       
        Route::get('getrecentcontentid', 'getrecentcontentid')->name('getrecentcontentid');


    });

    Route::controller(RewardsController::class)->group(function(){
        Route::get('rewards','rewards')->name('rewards');
        Route::any('get_all_rewards', 'get_all_rewards')->name('get_all_rewards');
        Route::any('view_rewards/{id}', 'view_rewards')->name('view_rewards');
    
    });

    // Route::controller(TagsController::class)->group(function(){
    //     Route::get('tags','tags')->name('tags');
    //     Route::any('get_all_tags', 'get_all_tags')->name('get_all_tags');
        
    //     Route::get('create_tags','create_tags')->name('create_tags');
    //     Route::post('save_tags','save_tags')->name('save_tags');
    //     Route::get('edit_tags/{id}','edit_tags')->name('edit_tags');
    //     Route::put('update_tags/{id}','update_tags')->name('update_tags');
    //     Route::any('view_tags/{id}', 'view_tags')->name('view_tags');
    //     Route::delete('delete_tags/{id}', 'delete_tags')->name('delete_tags');
    // });

    // Route::controller(RespondentsController::class)->group(function(){
    //     Route::get('respondents','respondents')->name('respondents');
    //     Route::any('get_all_respondents', 'get_all_respondents')->name('get_all_respondents');
    //     Route::get('respondent_export/{id}','respondent_export')->name('respondent_export');    
    // });

 

   Route::controller(ActionController::class)->group(function(){
        Route::get('actions','actions')->name('actions');
        Route::any('get_all_actions', 'get_all_actions')->name('get_all_actions');
    });
   
    Route::controller(CashoutsController::class)->group(function(){
        Route::get('cashouts','cashouts')->name('cashouts');
        Route::any('get_all_cashouts', 'get_all_cashouts')->name('get_all_cashouts');
        Route::get('cash_export/{id}','cash_export')->name('cash_export');        
    });
  
   

});


// Clone Survey 

Route::get('/survey/surveyduplication/{id}', ['as' => 'survey.surveyduplication','uses' => 'SurveyController@surveyduplication',])->middleware(['auth']);
Route::get('/survey/sharesurvey/{id}', ['as' => 'survey.sharesurvey','uses' => 'SurveyController@sharesurvey',])->middleware(['auth']);
Route::get('/survey/view/{id}', ['as' => 'survey.view','uses' => 'SurveyController@sharesurvey',])->middleware(['auth']);
