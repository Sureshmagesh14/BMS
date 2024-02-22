<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use DB;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class WelcomeController extends Controller
{   
    public function home()
    {   
        try {
            return view('front.home');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function userlogin()
    {   
        try {
            return view('front.user-login');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function userregister()
    {   
        try {
            return view('front.user-register');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public function userdashboard()
    {   
        try {
            return view('front.user-dashboard');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}