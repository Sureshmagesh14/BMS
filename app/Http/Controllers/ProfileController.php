<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Session;
use DB;
use Yajra\DataTables\DataTables;
use App\Models\Respondents;
use App\Models\Contents;
use App\Models\Groups;
use App\Models\Projects;
use App\Models\Banks;
use App\Models\Rewards;
use App\Models\RespondentProfile;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Illuminate\Support\Facades\Hash;
use Exception;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateprofile_wizard(Request $request){
        try {
            
            $resp_id   = Session::get('resp_id');
            $resp_name = Session::get('resp_name');
            $resp_details = Respondents::select('id','name','surname','date_of_birth','email','mobile','whatsapp')->find($resp_id);
           
            $state = DB::table('state')->whereNull('deleted_at')->get();
            $industry_company = DB::table('industry_company')->whereNull('deleted_at')->get();
            $income_per_month = DB::table('income_per_month')->whereNull('deleted_at')->get();
            $banks = Banks::whereNull('deleted_at')->where('active',1)->get();
            $profile = RespondentProfile::where('respondent_id',$resp_id)->first();

            if($profile != null){
                $pid = $profile->pid;
            }
            else{
                $get_pid = RespondentProfile::orderBy('pid','DESC')->first();
                $pid = ($get_pid != null) ? $get_pid->pid+1 : 1;
            }
          
            return view('user.profile_wizard', compact('pid','resp_details','state','industry_company','income_per_month','banks'));
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function get_suburb(Request $request){
        $province = $request->province;
        $suburb = DB::table('district')->where('type',$province)->whereNull('deleted_at')->orderBy('district','ASC')->get();
        $options = "";

        $options .= "<option value=''>Select</option>";
        foreach($suburb as $sub){
            $options .= "<option value='".$sub->id."'> ".$sub->district." </option>";
        }

        return array(
            'type' => true,
            'data' => $options
        );
    }

    public function get_area(Request $request){
        $suburb = $request->suburb;
        $areas  = DB::table('metropolitan_area')->where('district_id',$suburb)->whereNull('deleted_at')->orderBy('area','ASC')->get();
        $options = "";

        $options .= "<option value=''>Select</option>";
        foreach($areas as $area){
            $options .= "<option value='".$area->id."'> ".$area->area." </option>";
        }

        return array(
            'type' => true,
            'data' => $options
        );
    }

    public function profile_save(Request $request){
        dd($request->all());
    }
}
