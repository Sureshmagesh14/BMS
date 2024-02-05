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


    Route::resource('respondents','RespondentsController');
    Route::any('get_all_respondents', 'RespondentsController@get_all_respondents')->name('get_all_respondents');
    Route::get('respondent_export/{id}','RespondentsController@respondent_export')->name('respondent_export');    
    

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

    Route::controller(ProjectsController::class)->group(function(){
        Route::get('projects','projects')->name('projects');
        Route::any('get_all_projects', 'get_all_projects')->name('get_all_projects');
        Route::get('projects_export/{id}','projects_export')->name('projects_export');      
    });

   Route::controller(ActionController::class)->group(function(){
        Route::get('actions','actions')->name('actions');
        Route::any('get_all_actions', 'get_all_actions')->name('get_all_actions');
    });
   
    Route::controller(CashoutsController::class)->group(function(){
        Route::get('cashouts','cashouts')->name('cashouts');
        Route::any('get_all_cashouts', 'get_all_cashouts')->name('get_all_cashouts');
        Route::get('cash_export/{id}','cash_export')->name('cash_export');        
    });
  
    Route::controller(UsersController::class)->group(function(){
        Route::get('users','users')->name('users');
        Route::any('get_all_users', 'get_all_users')->name('get_all_users');
    });

});


