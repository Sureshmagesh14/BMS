<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;

class CommonAdminController extends Controller
{
    public function inner_module(Request $request)
    {
        $module = $request->module;
        $id = $request->id;

        if ($module == "user_to_project") {
            Session::put('user_to_project', '1');
            Session::put('user_to_project_id', $id);

            return redirect()->route('projects.index');
        }
    }

    public function check_email_name(Request $request)
    {
        $form_name = $request->form_name;
        $getcheckval = DB::table('respondents')->where('email', $request->email)->get()->count();

        if ($getcheckval > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }
}
