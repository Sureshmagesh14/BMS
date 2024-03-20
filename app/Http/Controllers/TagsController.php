<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Tags;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class TagsController extends Controller
{   
    public function index()
    {
        try {
            return view('admin.tags.index');
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
           
            $returnHTML = view('admin.tags.create')->render();

            return response()->json(
                [
                    'success' => true,
                    'html_page' => $returnHTML,
                ]
            );
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
               'name'=> 'required',
            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
                $tags = new Tags;
                $tags->name = $request->input('name');
                $tags->colour = $request->input('colour');
                $tags->save();
                $tags->id;
                return response()->json([
                    'status'=>200,
                    'last_insert_id' => $tags->id,
                    'message'=>'Tags Added Successfully.'
                ]);
            }

        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        try {
            $data = Tags::find($id);
            return view('admin.tags.view',compact('data'));

          
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
           
            $tags = Tags::find($id);
            if($tags)
            {
                $returnHTML = view('admin.tags.edit',compact('tags'))->render();
                return response()->json(
                    [
                        'success' => true,
                        'html_page' => $returnHTML,
                    ]
                );
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Tags Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'=> 'required',
            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
            }
            else
            {
               
                $tags = Tags::find($request->id);
                if($tags)
                {
                    $tags->name = $request->input('name');
                    $tags->colour = $request->input('colour');
                    $tags->update();
                    $tags->id;
                    return response()->json([
                        'status'=>200,
                        'last_insert_id' => $tags->id,
                        'message' => 'Tags Updated.',
                    ]);
                }
                else
                {
                    return response()->json([
                        'status'=>404,
                        'error'=>'No Tags Found.'
                    ]);
                }
    
            }
           
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tags = Tags::find($id);
            if($tags)
            {
                $tags->delete();
                return response()->json([
                    'status'=>200,
                    'success' => true,
                    'message'=>'Tags Deleted Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 404,
                    'success' => false,
                    'message'=>'No Tags Found.'
                ]);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
      
    }

   
    public function get_all_tags(Request $request) {
		
        try {
            if ($request->ajax()) {
                $token = csrf_token();
                $all_datas =Tags::latest()->get();
                
                return Datatables::of($all_datas)
                    ->addColumn('select_all', function ($all_data) {
                        return '<input class="tabel_checkbox" name="rewards[]" type="checkbox" onchange="table_checkbox(this,\'tags_table\')" id="'.$all_data->id.'">';
                    })
                    ->addColumn('colour', function ($all_data) {
                        return '<div class=""><button type="button" class="btn waves-effect waves-light" style="background-color:'.$all_data->colour.'"><i class="uil uil-user"></i></button></div>';
                    })
                    ->addColumn('action', function ($all_data) {
                        $edit_route = route("tags.edit",$all_data->id);
                        $view_route = route("tags.show",$all_data->id);

                        $design = '<div class="col-md-2">
                                <button class="btn btn-primary dropdown-toggle tooltip-toggle" data-toggle="dropdown" data-placement="bottom"
                                    title="Action" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-tasks" aria-hidden="true"></i>
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-center">
                                    <li class="list-group-item">
                                        <a href="'.$view_route.'" data-bs-original-title="View Panel" class="rounded waves-light waves-effect">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#!" data-url="'.$edit_route.'" data-size="xl" data-ajax-popup="true" data-ajax-popup="true"
                                            data-bs-original-title="Edit Panel" class="rounded waves-light waves-effect">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </li>';
                                    if(Auth::guard('admin')->user()->role_id == 1){
                                        $design .= '<li class="list-group-item">
                                            <a href="#!" id="delete_tags" data-id="'.$all_data->id.'" class="rounded waves-light waves-effect">
                                                <i class="far fa-trash-alt"></i> Delete
                                            </a>
                                        </li>';
                                    }
                                $design .='</ul>
                            </div>';

                        return $design;
                    })
                    ->rawColumns(['select_all','action','name','colour'])      
                    ->make(true);
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
        
    public function tags_export($arg) {
        
        $type='xlsx';

       
        $all_datas = DB::table('tags')
            ->orderby("id","desc")
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Description');
        $sheet->setCellValue('D1', 'Colour');
        $sheet->setCellValue('E1', 'Settings');
        $sheet->setCellValue('F1', 'Size');
  
        $rows = 2;
        $i=1;
        foreach($all_datas as $all_data){
            
            $sheet->setCellValue('A' . $rows, $i);
            $sheet->setCellValue('B' . $rows, $all_data->name);
            $sheet->setCellValue('C' . $rows, '');
            $sheet->setCellValue('D' . $rows, $all_data->colour);
            //$sheet->getActiveSheet()->getStyle('D' . $rows)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0f609b');
            $sheet->setCellValue('E' . $rows, '');
            $sheet->setCellValue('F' . $rows, '');

            
            $rows++;
            $i++;
        }

        $fileName = "panel_details_".date('ymd').".".$type;
        if($type == 'xlsx') {
            $writer = new Xlsx($spreadsheet);
        } else if($type == 'xls') {
            $writer = new Xls($spreadsheet);
        }
            $writer->save("export/".$fileName);
            
        header("Content-Type: application/vnd.ms-excel");
        return redirect(url('/')."/export/".$fileName);
    }

    public function tags_multi_delete(Request $request){
        try {
            $all_id = $request->all_id;
            foreach($all_id as $id){
                $tags = Tags::find($id);
                $tags->delete();
            }
            
            return response()->json([
                'status'=>200,
                'success' => true,
                'message'=>'Tags Deleted'
            ]);
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}