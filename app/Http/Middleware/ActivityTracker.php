<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
class ActivityTracker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if(Session::has('ses_current_clientId')){
            $current_id_old=Session::get('ses_current_clientId');
            $client_name_old=Session::get('ses_current_clientName');
        }else{
            $current_id_old=Session::get('ses_user_id');
            $client_name_old='Admin';
        }

        $route_url_old=url()->current();
       

        $form_data_old=json_encode($request->all());
            
        $action = null;
        $activity_old = 'Visiting the page'; // Default activity
        
        if ($request->isMethod('post') || Str::endsWith($route_url_old, 'store')) {
            $action = 'Creating new data';
            $activity_old = Str::endsWith($route_url_old, 'create') ? 'Visiting create page' : 'Data changed in the form';
        } elseif ($request->isMethod('put') || $request->isMethod('patch') || Str::endsWith($route_url_old, 'update')) {
            $action = 'Updating data';
            $activity_old = Str::endsWith($route_url_old, 'edit') ? 'Editing existing data' : 'Data changed in the form';
        } elseif ($request->isMethod('delete') || Str::endsWith($route_url_old, 'delete')) {
            $action = 'Deleting data';
            $activity_old = 'Data deleted';
        } elseif (Str::endsWith($route_url_old, 'edit')) {
            $activity_old = 'Visiting edit page';
        } elseif (Str::endsWith($route_url_old, 'create')) {
            $activity_old = 'Visiting create page';
        }
        
        
        

        // Get 'project_id' from session or set to 0
        $project_id = Session::get("project_id", 0);
       
        $insertdata=array(
            'user_id'   => \Auth::user()->id,
           
            'log_type'         => $activity_old,
            'url'         => $route_url_old,
         
           'created_at' => Carbon::now(), // Store as a Carbon instance
            'updated_at' => Carbon::now(), // Store as a Carbon instance
        );
        
    
            ActivityLog::insert($insertdata);
          
         
        
        
       
        
        return $next($request);
    }
}
