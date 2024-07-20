<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::any('/', 'WelcomeController@home')->name('home');
Route::any('update_activitation/{id}', 'WelcomeController@update_activitation')->name('update_activitation');
Route::any('activation_status/{id}/{active_id}', 'WelcomeController@activation_status')->name('activation_status');
// View Survey
Route::get('/survey/view/{id}', ['as' => 'survey.view', 'uses' => 'SurveyController@viewsurvey']);
// Start Survey
Route::any('/survey/view/{id}/{qus}', ['as' => 'survey.startsurvey', 'uses' => 'SurveyController@startsurvey']);
// Thank you page Survey
Route::get('/survey/view/{id}/{qus}', ['as' => 'survey.endsurvey', 'uses' => 'SurveyController@endsurvey']);
// Respondent Flow
Route::post('/survey/submitans', ['as' => 'survey.submitans', 'uses' => 'SurveyController@submitans']);

// Report 
Route::get('/survey-report-respondent/{id}', ['as' => 'survey.reportrespondent', 'uses' => 'SurveyController@generateReportbyRespondent']);

Route::any('terms', 'WelcomeController@terms')->name('terms');
Route::any('about_the_brand', 'WelcomeController@about_the_brand')->name('about_the_brand');
Route::any('admin', 'Auth\AdminLoginController@showLoginForm')->name('admin.showlogin'); //.....Admin Login
Route::any('admin/login', 'Auth\AdminLoginController@adminLogin')->name('admin.login'); //.....Admin Login
Route::any('admin/forgot_password', 'Auth\AdminLoginController@forgot_password')->name('admin.forgot_password');
Route::any('email', 'WelcomeController@email')->name('email');

Route::any('dashboard', 'WelcomeController@user_dashboard')->middleware(['auth', 'verified'])->name('user.dashboard');
Route::any('view_client_survey_list', 'WelcomeController@view_client_survey_list')->middleware(['auth', 'verified'])->name('client.survey');
Route::any('profile-edit', 'WelcomeController@user_profile')->middleware(['auth', 'verified'])->name('user.profile');
Route::any('share', 'WelcomeController@user_share')->middleware(['auth', 'verified'])->name('user.share');
Route::any('share_project/{id}', 'WelcomeController@share_project')->middleware(['auth', 'verified'])->name('share_project');
Route::any('rewards', 'WelcomeController@user_rewards')->middleware(['auth', 'verified'])->name('user.rewards');
Route::any('surveys', 'WelcomeController@user_surveys')->middleware(['auth', 'verified'])->name('user.surveys');
Route::any('viewprofile', 'WelcomeController@user_viewprofile')->middleware(['auth', 'verified'])->name('user.viewprofile');
Route::any('change_password', 'WelcomeController@change_password')->middleware(['auth', 'verified'])->name('user.change_password');
Route::any('update_password', 'WelcomeController@update_password')->middleware(['auth', 'verified'])->name('user.update_password');
Route::any('updateprofile', 'WelcomeController@user_editprofile')->middleware(['auth', 'verified'])->name('updateprofile');
Route::any('updaterofile', 'WelcomeController@user_editprofile')->middleware(['auth', 'verified'])->name('updaterofile');
Route::post('user_update', 'WelcomeController@user_update')->middleware(['auth', 'verified'])->name('user_update');
Route::any('opt_out', 'WelcomeController@opt_out')->middleware(['auth', 'verified'])->name('opt_out');
Route::any('cashout_sent', 'WelcomeController@cashout_sent')->middleware(['auth', 'verified'])->name('cashout_sent');
Route::any('cashout_form', 'WelcomeController@cashout_form')->middleware(['auth', 'verified'])->name('cashout_form');
Route::any('cashouts', 'WelcomeController@user_cashout')->middleware(['auth', 'verified'])->name('user.cashouts');
Route::any('change_profile', 'WelcomeController@change_profile')->middleware(['auth', 'verified'])->name('user.change_profile');
Route::post('image_update', 'WelcomeController@image_update')->middleware(['auth', 'verified'])->name('user.image_update');

Route::any('updateprofile_wizard', 'ProfileController@updateprofile_wizard')->middleware(['auth', 'verified'])->name('updateprofile_wizard');
Route::any('get_suburb', 'ProfileController@get_suburb')->middleware(['auth', 'verified'])->name('get_suburb');
Route::any('get_area', 'ProfileController@get_area')->middleware(['auth', 'verified'])->name('get_area');
Route::any('profile_save', 'ProfileController@profile_save')->middleware(['auth', 'verified'])->name('profile_save');

Route::any('process_cashout', 'WelcomeController@process_cashout')->name('process_cashout');
Route::any('complete_cashout', 'WelcomeController@complete_cashout')->name('complete_cashout');

/* USERS */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ADMIN */
Route::group([
    'prefix' => 'admin',
    'middleware' => 'admin',
], function () {
    Route::any('dashboard', 'Auth\AdminLoginController@admin_dashboard')->name('admin.dashboard');
    Route::any('get_activity_data', 'Auth\AdminLoginController@get_activity_data')->name('get_activity_data');
    Route::get('signout', 'Auth\AdminLoginController@signOut')->name('signout');
    Route::any('export_index', 'ExportController@export_index')->name('admin.export');
    Route::post('export_all', 'ExportController@export_all')->name('export_all');
    
    /* Users MENU*/
    Route::resource('users', 'UsersController')
        ->name('index', 'users.index')->name('destroy', 'users.destroy')
        ->name('create', 'users.create')->name('show', 'users.show')->name('update', 'users.update');
    Route::any('get_all_users', 'UsersController@get_all_users')->name('get_all_users');
    Route::get('export_user_activity', 'UsersController@export_user_activity')->name('export_user_activity');
    Route::get('export_referrals', 'UsersController@export_referrals')->name('export_referrals');
    Route::any('users_multi_delete', 'UsersController@users_multi_delete')->name('users_multi_delete');
    Route::any('users_action', 'UsersController@users_action')->name('users_action');
    Route::any('user_email_id_check', 'UsersController@user_email_id_check')->name('user_email_id_check');

    /* Internal Reports MENU*/
    Route::controller(InternalReportController::class)->group(function () {
        Route::get('user-events', 'index')->name('user-events');
        Route::any('user-events-show', 'show')->name('user-events-show');
        Route::get('user-events-view/{id}', 'view')->name('user-events-view');
    });

    /* Cash Outs MENU*/
    Route::controller(CashoutsController::class)->group(function () {
        Route::get('cashouts', 'cashouts')->name('cashouts');
        Route::any('get_all_cashouts', 'get_all_cashouts')->name('get_all_cashouts');
        Route::get('cashouts-view/{id}', 'view')->name('cashouts-view');
        Route::post('cash_export', 'cash_export')->name('cash_export');
        Route::get('export_cash', 'export_cash')->name('export_cash');
        Route::any('cash_multi_delete', 'CashoutsController@cash_multi_delete')->name('cash_multi_delete');
        Route::any('cash_multi_update', 'CashoutsController@cash_multi_update')->name('cash_multi_update');
        Route::any('cashout_export', 'cashout_export')->name('cashout_export'); /* Cashout_export Export */
        Route::any('cashout_action', 'cashout_action')->name('cashout_action');
    });

    /* Action Events MENU*/
    Route::controller(ActionController::class)->group(function () {
        Route::get('actions', 'actions')->name('actions');
        Route::get('view-actions/{id}', 'view')->name('view-actions');
        Route::any('get_all_actions', 'get_all_actions')->name('get_all_actions');
    });

    /* Projects MENU*/
    Route::resource('projects', 'ProjectsController')->name('index', 'projects.index')->name('destroy', 'projects.destroy')
        ->name('create', 'projects.create')->name('show', 'projects.show')->name('update', 'projects.update');
    Route::any('get_all_projects', 'ProjectsController@get_all_projects')->name('get_all_projects');
    Route::any('projects_export', 'ProjectsController@projects_export')->name('projects_export');
    Route::any('projects_copy/{id}', 'ProjectsController@copy')->name('projects_copy');
    Route::any('export_projects', 'ProjectsController@export_projects')->name('export_projects');
    Route::any('projects_multi_delete', 'ProjectsController@projects_multi_delete')->name('projects_multi_delete');
    Route::any('attach_projects/{respondent_id}', 'ProjectsController@attach_projects')->name('attach_projects');
    Route::any('project_seach_result', 'ProjectsController@project_seach_result')->name('project_seach_result');
    Route::any('project_attach_store', 'ProjectsController@project_attach_store')->name('project_attach_store');
    Route::any('deattach_project/{respondent_id}/{project_id}', 'ProjectsController@deattach_project')->name('deattach_project');
    Route::any('project_action', 'ProjectsController@project_action')->name('project_action');
    Route::any('project_unassign', 'ProjectsController@project_unassign')->name('project_unassign');    
    Route::any('notify_respondent', 'ProjectsController@notify_respondent')->name('notify_respondent');  
    Route::any('get_project_status', 'ProjectsController@get_project_status')->name('get_project_status'); 
      
    
    Route::any('get_survey_link', 'ProjectsController@get_survey_link')->name('get_survey_link');

 

    /* Respondents MENU*/
    Route::resource('respondents', 'RespondentsController')->name('index', 'respondents.index')->name('destroy', 'respondents.destroy')
        ->name('create', 'respondents.create')->name('show', 'respondents.show')->name('update', 'respondents.update');
    Route::any('get_all_respondents', 'RespondentsController@get_all_respondents')->name('get_all_respondents');
    Route::any('get_all_respond', 'RespondentsController@indexDataTable')->name('get_all_respond');
    Route::any('respondent_export', 'RespondentsController@respondent_export')->name('respondent_export');
    Route::get('gen_respondent_res_export', 'RespondentsController@gen_respondent_res_export')->name('gen_respondent_res_export');
    Route::get('gen_respondent_mon_export', 'RespondentsController@gen_respondent_mon_export')->name('gen_respondent_mon_export');
    Route::get('export_resp', 'RespondentsController@export_resp')->name('export_resp');
    Route::any('respondents_export', 'RespondentsController@respondents_export')->name('respondents_export'); /* Respondents Export */
    Route::any('attach_respondents/{project_id}', 'RespondentsController@attach_respondents')->name('attach_respondents');
    Route::any('respondent_seach_result', 'RespondentsController@respondent_seach_result')->name('respondent_seach_result');
    Route::any('respondent_attach_store', 'RespondentsController@respondent_attach_store')->name('respondent_attach_store');
    Route::any('deattach_respondent/{respondent_id}/{project_id}', 'RespondentsController@deattach_respondent')->name('deattach_respondent');
    Route::any('user_respondent_id_check', 'RespondentsController@user_respondent_id_check')->name('user_respondent_id_check');
    Route::any('get_user_survey', 'RespondentsController@get_user_survey')->name('get_user_survey');
    Route::any('respondents_multi_delete', 'RespondentsController@respondents_multi_delete')->name('respondents_multi_delete');
    Route::any('get_branch_code', 'RespondentsController@get_branch_code')->name('get_branch_code');
    Route::any('import_respondents/{project_id}', 'RespondentsController@import_respondents')->name('import_respondents');
    Route::any('upload_respondent', 'RespondentsController@upload_respondent')->name('upload_respondent');
    

    /* Tags (or) Pannels MENU*/
    Route::resource('tags', 'TagsController')->name('index', 'tags.index')->name('destroy', 'tags.destroy')
        ->name('create', 'tags.create')->name('show', 'tags.show')->name('update', 'tags.update');
    Route::any('get_all_tags', 'TagsController@get_all_tags')->name('get_all_tags');
    Route::any('tags_export', 'TagsController@tags_export')->name('tags_export');
    Route::any('tags_multi_delete', 'TagsController@tags_multi_delete')->name('tags_multi_delete');
    Route::any('attach_tags/{respondent_id}', 'TagsController@attach_tags')->name('attach_tags');
    Route::any('tags_seach_result', 'TagsController@tags_seach_result')->name('tags_seach_result');
    Route::any('tags_attach_store', 'TagsController@tags_attach_store')->name('tags_attach_store');
    Route::any('attach_resp_tags/{tags_id}', 'TagsController@attach_resp_tags')->name('attach_resp_tags');
    Route::any('respondent_to_panel_attach_import', 'ProjectsController@respondent_to_panel_attach_import')->name('respondent_to_panel_attach_import');
    Route::any('import_tags/{respondent_id}', 'TagsController@import_tags')->name('import_tags');
    Route::any('import_resp_tags/{panel_id}', 'TagsController@import_resp_tags')->name('import_resp_tags');
    Route::any('respondent_attach_import/{project_id}', 'ProjectsController@respondent_attach_import')->name('respondent_attach_import');
    Route::any('tags_attach_import/{respondent_id}', 'TagsController@tags_attach_import')->name('tags_attach_import');
    Route::any('tags_search_result', 'TagsController@tags_search_result')->name('tags_search_result');
    Route::any('tags_resp_attach_import/{panel_id}', 'TagsController@tags_resp_attach_import')->name('tags_resp_attach_import');
    Route::any('deattach_tags/{tags_id}', 'TagsController@deattach_tags')->name('deattach_tags');

    /* Rewards MENU*/
    Route::resource('rewards', 'RewardsController')->name('index', 'rewards.index')->name('destroy', 'rewards.destroy')
        ->name('create', 'rewards.create')->name('show', 'rewards.show')->name('update', 'rewards.update');
    Route::controller(RewardsController::class)->group(function () {
        Route::get('rewards_export', 'rewards_export')->name('rewards_export');
        Route::get('export_rewards', 'export_rewards')->name('export_rewards');
        Route::get('get_all_rewards', 'get_all_rewards')->name('get_all_rewards');
        Route::get('view_rewards/{id}', 'view_rewards')->name('view_rewards');
        Route::any('change_rewards_status', 'change_rewards_status')->name('change_rewards_status');
        Route::any('rewards_multi_delete', 'rewards_multi_delete')->name('rewards_multi_delete');
    });

    /* Profile Groups MENU*/
    Route::resource('groups', 'ProfileGroupController')->name('index', 'groups.index')->name('destroy', 'groups.destroy')
        ->name('create', 'groups.create')->name('show', 'groups.show')->name('update', 'groups.update');
    Route::any('get_groups_banks', 'ProfileGroupController@get_groups_banks')->name('get_groups_banks');
    Route::any('groups_multi_delete', 'ProfileGroupController@groups_multi_delete')->name('groups_multi_delete');

    /* Banks MENU*/
    Route::resource('banks', 'BankController')->name('index', 'banks.index')->name('destroy', 'banks.destroy')
        ->name('create', 'banks.create')->name('show', 'banks.show')->name('update', 'banks.update');
    Route::any('get_all_banks', 'BankController@get_all_banks')->name('get_all_banks');
    Route::any('banks_multi_delete', 'BankController@banks_multi_delete')->name('banks_multi_delete');

    /* Charities MENU*/
    Route::resource('charities', 'CharitiesController')->name('index', 'charities.index')->name('destroy', 'charities.destroy')
        ->name('create', 'charities.create')->name('show', 'charities.show')->name('update', 'charities.update');
    Route::any('get_all_charities', 'CharitiesController@get_all_charities')->name('get_all_charities');
    Route::any('charities_multi_delete', 'CharitiesController@charities_multi_delete')->name('charities_multi_delete');

    /* Celluar Networks MENU*/
    Route::resource('networks', 'NetworkController')->name('index', 'networks.index')->name('destroy', 'networks.destroy')
        ->name('create', 'networks.create')->name('show', 'networks.show')->name('update', 'networks.update');
    Route::get('get_all_networks', 'NetworkController@get_all_networks')->name('get_all_networks');
    Route::any('networks_multi_delete', 'NetworkController@networks_multi_delete')->name('networks_multi_delete');

    

    /* Contents MENU*/
    Route::resource('contents', 'ContentsController')->name('index', 'contents.index')->name('destroy', 'contents.destroy')
        ->name('create', 'contents.create')->name('show', 'contents.show')->name('update', 'contents.update');
    Route::get('contents_datatable', 'ContentsController@contents_datatable')->name('contents_datatable');
    Route::any('contents_multi_delete', 'ContentsController@contents_multi_delete')->name('contents_multi_delete');
    Route::any('check_content_duplicate', 'ContentsController@check_content_duplicate')->name('check_content_duplicate');

    Route::get('inner_module', 'CommonAdminController@inner_module')->name('inner_module');

    /* Survey Folder Routings*/
    Route::get('/survey/folders', 'SurveyController@folder')->name('folder');
    Route::post('/survey/folders', ['as' => 'survery.folders', 'uses' => 'SurveyController@getFolderList']);
    Route::get('/survey/folders/create', ['as' => 'folder.create', 'uses' => 'SurveyController@createFolder']);
    Route::post('/survey/folders/store', ['as' => 'folder.store', 'uses' => 'SurveyController@storeFolder']);
    Route::get('/survey/folders/edit/{id}', ['as' => 'folder.edit', 'uses' => 'SurveyController@editFolder']);
    Route::post('/survey/folders/update/{id}', ['as' => 'folder.update', 'uses' => 'SurveyController@updateFolder']);
    Route::get('/survey/folders/delete/{id}', ['as' => 'folder.delete', 'uses' => 'SurveyController@deleteFolder']);

    /* Survey Routings*/
    Route::get('/survey', 'SurveyController@survey')->name('survey');
    Route::get('/survey/create', ['as' => 'survey.create', 'uses' => 'SurveyController@createSurvey']);
    Route::post('/survey/survey', ['as' => 'survery.survey', 'uses' => 'SurveyController@getSurveyList']);
    Route::post('/survey/store', ['as' => 'survey.store', 'uses' => 'SurveyController@storeSurvey']);
    Route::get('/survey/edit/{id}', ['as' => 'survey.edit', 'uses' => 'SurveyController@editSurvey']);
    Route::post('/survey/update/{id}', ['as' => 'survey.update', 'uses' => 'SurveyController@updateSurvey']);
    Route::get('/survey/delete/{id}', ['as' => 'survey.delete', 'uses' => 'SurveyController@deleteSurvey']);
    Route::get('/survey/restore/{id}', ['as' => 'survey.restore', 'uses' => 'SurveyController@restoreSurvey']);

    /* Survey Template Routings*/
    Route::get('/survey/template/{id}', ['as' => 'survey.template', 'uses' => 'SurveyController@templateList']);
    Route::get('/survey/builder/{id}/{qus_id}', ['as' => 'survey.builder', 'uses' => 'SurveyController@builder']);
    Route::get('/survey/questiontype/{id}', ['as' => 'survey.questiontype', 'uses' => 'SurveyController@questiontype']);
    Route::get('/survey/qustype/{survey}/{qustype}', ['as' => 'survey.qustype', 'uses' => 'SurveyController@questiontypesurvey']);
    Route::get('/survey/deletequs/{id}', ['as' => 'survey.deletequs', 'uses' => 'SurveyController@deletequs']);
    Route::get('/survey/copyqus/{id}', ['as' => 'survey.copyqus', 'uses' => 'SurveyController@copyqus']);

    /* Survey Questions Routings*/
    Route::get('/survey/questions/{id}', ['as' => 'survey.quesbuilder', 'uses' => 'SurveyController@questionList']);
    Route::post('/survey/questions/{id}', ['as' => 'survey.qus.update', 'uses' => 'SurveyController@updateQus']);
    Route::post('/survey/questions-move', ['as' => 'survey.qus.move', 'uses' => 'SurveyController@moveQus']);

    /* Survey Clone Routings*/
    Route::get('/survey/surveyduplication/{id}', ['as' => 'survey.surveyduplication', 'uses' => 'SurveyController@surveyduplication']);
    Route::get('/survey/sharesurvey/{id}', ['as' => 'survey.sharesurvey', 'uses' => 'SurveyController@sharesurvey']);
    Route::get('/survey/movesurvey/{id}', ['as' => 'survey.movesurvey', 'uses' => 'SurveyController@movesurvey']);
    Route::post('/survey/movesurveyupdate/{id}', ['as' => 'survey.movesurveyupdate', 'uses' => 'SurveyController@movesurveyupdate']);

    /* Survey Upload Image*/
    Route::post('/survey/upload-image', ['as' => 'survey.uploadimage', 'uses' => 'SurveyController@uploadimage']); // Upload Image
    Route::get('/survey/background/{id}', ['as' => 'survey.background', 'uses' => 'SurveyController@background']); // Survey Background
    Route::post('/survey/background/{id}', ['as' => 'survey.background', 'uses' => 'SurveyController@setbackground']); // Survey Background

    // Survey Get Qus
    Route::get('/survey/getqus', ['as' => 'survey.getqus', 'uses' => 'SurveyController@getqus']); // Get Qus

    // Survey Settings
    Route::get('/survey/surveysettings/{id}', ['as' => 'survey.surveysettings', 'uses' => 'SurveyController@surveysettings']);
    Route::post('/survey/updatesettings/{id}', ['as' => 'survey.updatesettings', 'uses' => 'SurveyController@updatesettings']);

    // Survey Quota
    Route::get('/survey/set-quota/{id}', ['as' => 'survey.setquota', 'uses' => 'SurveyController@setquota']);
    Route::get('/survey/quota/create/{id}', ['as' => 'survey.createquota', 'uses' => 'SurveyController@createquota']);
    Route::post('/survey/quota/store', ['as' => 'survey.storequota', 'uses' => 'SurveyController@storequota']);
    Route::get('/survey/quota/edit/{id}', ['as' => 'survey.editquota', 'uses' => 'SurveyController@editquota']);
    Route::post('/survey/quota/update/{id}', ['as' => 'survey.updatequota', 'uses' => 'SurveyController@updatequota']);
    Route::get('/survey/quota/delete/{id}', ['as' => 'survey.deletequota', 'uses' => 'SurveyController@deletequota']);

    // Survey Response

    Route::get('/survey/responses/{id}', ['as' => 'survey.responses', 'uses' => 'SurveyController@responses']);
    Route::any('get_all_response/{id}', 'SurveyController@get_all_response')->name('get_all_response');

    // Survey Report Routings 
    Route::get('/survey/report/{id}/{type}', ['as' => 'survey.report', 'uses' => 'SurveyController@generateReport']);


    // Survey Template
    Route::get('/survey/default-template/{id}/{type}', ['as' => 'survey.surveytemplate', 'uses' => 'SurveyController@surveytemplate']);
    Route::any('get_all_templates/{id}/{type}', 'SurveyController@get_all_templates')->name('get_all_templates');

    Route::get('/survey/createtemplate/{type}', ['as' => 'survey.createtemplate', 'uses' => 'SurveyController@createSurveyTemplate']);
    Route::post('/survey/storetemplate', ['as' => 'survey.storetemplate', 'uses' => 'SurveyController@storeSurveyTemplate']);
    Route::get('/survey/edittemplate/{id}', ['as' => 'survey.edittemplate', 'uses' => 'SurveyController@editSurveyTemplate']);
    Route::post('/survey/updatetemplate/{id}', ['as' => 'survey.updatetemplate', 'uses' => 'SurveyController@updateSurveyTemplate']);
    Route::get('/survey/deletetemplate/{id}', ['as' => 'survey.deletetemplate', 'uses' => 'SurveyController@deleteSurveyTemplate']);
    Route::get('/survey/templatedetails', ['as' => 'survey.templatedetails', 'uses' => 'SurveyController@templatedetails']);

});

// NEW
Route::post('custom-registration', 'CustomAuthController@customRegistration')->name('register.custom');

Route::controller(SettingsController::class)->group(function () {
    Route::get('getrecentcontentid', 'getrecentcontentid')->name('getrecentcontentid');
});
Route::any('check_email_name', 'CommonAdminController@check_email_name')->name('check_email_name');

require __DIR__ . '/auth.php';

// Reports
Route::get('/generate-ppt-report', ['as' => 'survey.pptreport', 'uses' => 'SurveyController@generatePPTReport']);
Route::get('/generate-wordcloud-report', ['as' => 'survey.wordcloudreport', 'uses' => 'SurveyController@generateWordCloud']);
Route::get('/generate-pdf', ['as' => 'survey.pdfreport', 'uses' => 'SurveyController@generatePDF']);
Route::get('/generate-barchart', ['as' => 'survey.barchart', 'uses' => 'SurveyController@generateBarChart']);
Route::get('/wordcloud', 'WordCloudController@generateAndDownload');
Route::get('/checkquota/{id}', 'SurveyController@checkquota');

Route::post('templogin', 'SurveyController@templogin')->name('templogin');;
