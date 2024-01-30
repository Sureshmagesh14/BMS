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

    Route::controller(SettingsController::class)->group(function(){
        /*Content starts*/
        Route::get('contents','contents')->name('contents');
        Route::any('get_all_contents', 'get_all_contents')->name('get_all_contents');
        Route::get('create_contents','create_contents')->name('create_contents');
        Route::post('save_contents','save_contents')->name('save_contents');
        Route::get('edit_contents/{id}','edit_contents')->name('edit_contents');
        Route::put('update_contents/{id}','update_contents')->name('update_contents');
        Route::any('view_contents/{id}', 'view_contents')->name('view_contents');
        Route::delete('delete_contents/{id}', 'delete_contents')->name('delete_contents');
        /*Content ends*/
        
        Route::get('banks','banks')->name('banks');
        Route::any('get_all_banks', 'get_all_banks')->name('get_all_banks');
        Route::any('create_bank', 'create_bank')->name('create_bank');
        
    
        Route::get('networks','networks')->name('networks');
        Route::any('get_all_networks', 'get_all_networks')->name('get_all_networks');
        Route::get('create_networks','create_networks')->name('create_networks');
        Route::post('save_network','save_network')->name('save_network');
        
        Route::get('charities','charities')->name('charities');
        Route::any('get_all_charities', 'get_all_charities')->name('get_all_charities');
       
        Route::get('groups','groups')->name('groups');
        Route::any('get_all_groups', 'get_all_groups')->name('get_all_groups');

       
        Route::get('getrecentcontentid', 'getrecentcontentid')->name('getrecentcontentid');


    });

    Route::controller(RewardsController::class)->group(function(){
        Route::get('rewards','rewards')->name('rewards');
        Route::any('get_all_rewards', 'get_all_rewards')->name('get_all_rewards');
        Route::any('view_rewards/{id}', 'view_rewards')->name('view_rewards');
    
    });

    Route::controller(TagsController::class)->group(function(){
        Route::get('tags','tags')->name('tags');
        Route::any('get_all_tags', 'get_all_tags')->name('get_all_tags');
    });

    Route::controller(RespondentsController::class)->group(function(){
        Route::get('respondents','respondents')->name('respondents');
        Route::any('get_all_respondents', 'get_all_respondents')->name('get_all_respondents');
    });

    Route::controller(ProjectsController::class)->group(function(){
        Route::get('projects','projects')->name('projects');
        Route::any('get_all_projects', 'get_all_projects')->name('get_all_projects');

    });

   Route::controller(ActionController::class)->group(function(){
        Route::get('actions','actions')->name('actions');
        Route::any('get_all_actions', 'get_all_actions')->name('get_all_actions');
    });
   
    Route::controller(CashoutsController::class)->group(function(){
        Route::get('cashouts','cashouts')->name('cashouts');
        Route::any('get_all_cashouts', 'get_all_cashouts')->name('get_all_cashouts');
        
    });
  
    Route::controller(UsersController::class)->group(function(){
        Route::get('users','users')->name('users');
        Route::any('get_all_users', 'get_all_users')->name('get_all_users');
    });

});


