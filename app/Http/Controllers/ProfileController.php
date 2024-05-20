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
            $data      = Respondents::find($resp_id);
            $profil    = DB::table('groups as gr')
                        ->leftjoin('survey as sr','gr.survey_id','=','sr.id') 
                        ->leftjoin('survey_response as resp','gr.survey_id','=','resp.survey_id') 
                        ->select('gr.name', 'sr.builderID','gr.type_id','resp.updated_at',DB::raw('(SELECT COUNT(*) FROM questions WHERE gr.survey_id = questions.survey_id) AS totq'),DB::raw('(SELECT COUNT(*) FROM survey_response WHERE survey_response.response_user_id='.$resp_id.' AND gr.survey_id = survey_response.survey_id AND survey_response.skip IS NULL) AS tota'))
                        ->where('gr.deleted_at', NULL)
                        ->orderBy('gr.sort_order', 'ASC')
                        ->groupBy('gr.id')
                        ->get();
                        
            $prof_response  = DB::table('survey_response')->where('response_user_id', $resp_id)->get();

            $state = DB::table('state')->whereNull('deleted_at')->get();
            $suburb = DB::table('district')->whereNull('deleted_at')->get();
            $metropolitan_area = DB::table('metropolitan_area')->whereNull('deleted_at')->get();
          
            return view('user.profile_wizard', compact('data','profil','prof_response','state','suburb','metropolitan_area'));
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
}
