<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class CommonAdminController extends Controller
{
    public function inner_module(Request $request){
        $module = $request->module;
        $id     = $request->id;

        if($module == "user_to_project"){
            Session::put('user_to_project', '1');
            Session::put('user_to_project_id', $id);

            return redirect()->route('projects.index');
        }
    }
}
