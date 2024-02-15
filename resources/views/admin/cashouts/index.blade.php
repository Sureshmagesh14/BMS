@include('admin.layout.header')

@yield('adminside-favicon')
@yield('adminside-css')

@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<style>
.datepicker{
z-index: 1100 !important;
}
#ui-datepicker-div {
width: 30% !important;
}
</style>

      <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Cashouts</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Cashouts</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">

                           

                                <div class="card">
                                    <div class="card-body">

                                   
<div class="text-right">



<a href="#!" data-url="{{ route('export_cash') }}" data-size="xl" data-ajax-popup="true"
                                        class="btn btn-primary" data-bs-original-title="{{ __('Cashout Summary') }}" class="btn btn-primary" data-size="xl"
                                         data-ajax-popup="true" data-bs-toggle="tooltip"
                                        id="export">
                                        Export
                                    </a>
                                    <a class="btn btn-danger" class="btn btn-primary" id="delete_all" style="display: none;">
                                        Delete Selected All
                                    </a>
                                    </div>

                                        <h4 class="card-title"> </h4>
                                        <p class="card-title-desc"></p>
        
                                        <table id="myTable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                
                                                <th>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input select_all" id="inlineForm-customCheck">
                                                        <label class="custom-control-label" for="inlineForm-customCheck" style="font-weight: bold;">Select All</label>
                                                    </div>
                                                </th>
                                                <th>#</th>      
                                                <th>Type</th>          
                                                <th>Status</th>          
                                                <th>Amount</th>          
                                                <th>Respondent</th>                                           
                                                <th>Action</th>
                                            </tr>
                                            </thead>
        
        
                                            <tbody>
                                            
                                           
                                            </tbody>
                                        </table>
        
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
        
                       
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


   <!-- Modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cash Outs Summary by Month & Year</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <form action="{{url('export_cashout_year')}}">
        @csrf
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Select Year:</label>
            <select id="user" name="user" class="w-full form-control form-select" required="">
                <option value="" selected="selected" disabled="disabled">
                    Please select
                </option>

                {{ $last= date('Y')-15 }}
                {{ $now = date('Y') }}

                @for ($i = $now; $i >= $last; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
          </div>
        

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Select Month:</label>
            <select id="user" name="user" class="w-full form-control form-select" required="">
                <option value="" selected="selected" disabled="disabled">
                    Please select
                </option>
         

                @for ($i = 1; $i <= 12; $i++)

                @php 
                $lval= date('F', strtotime( "$i/12/10" ));
                @endphp 
                <option value="{{ $i }}">{{ $lval }}</option>
                @endfor
            </select>
          </div>
        
        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Export</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- modal -->

                @include('admin.layout.footer')
        
                @stack('adminside-js')
                @stack('adminside-validataion')
                @stack('adminside-confirm')
                @stack('adminside-datatable')

<script>
    var tempcsrf = '{!! csrf_token() !!}';
function table_checkbox(get_this){
            count_checkbox = $(".tabel_checkbox").filter(':checked').length;
            if(count_checkbox > 1){
                $("#delete_all").show();
            }
            else{
                $("#delete_all").hide();
            }
        }

        $(document).on('click', '#delete_all', function(e) {
            e.preventDefault();
            var all_id = [];

            var values = $("#myTable tbody tr").map(function() {
                var $this = $(this);
                if($this.find("[type=checkbox]").is(':checked')){
                    all_id.push($this.find("[type=checkbox]").attr('id')); 
                    // return {
                    //     id: $this.find("[type=checkbox]").attr('id'),
                    // };
                }
                
            }).get();
          
            $.confirm({
                title: "{{Config::get('constants.delete')}}",
                content:  "{{Config::get('constants.delete_confirmation')}}",
                autoClose: 'cancelAction|8000',
                buttons: {
                    delete: {
                        text: 'delete',
                        action: function() {
                            $.ajax({
                                type: "POST",
                                data: {
                                    _token: tempcsrf,
                                    all_id: all_id
                                },
                                url: "{{ route('cash_multi_delete') }}",
                                dataType: "json",
                                success: function(response) {
                                    if (response.status == 404) {
                                        $('.delete_student').text('');
                                    } else {
                                        datatable();
                                        $.alert('Groups Deleted!');
                                        $("#delete_all").hide();
                                    }
                                }
                            });
                        }
                    },
                    cancel: function() {
                        
                    }
                }
            });
        });
$(document).ready(function() {

    datatable();
    
});
function datatable(){
$('#myTable').dataTable().fnDestroy();

    $('#myTable').DataTable({
      
        searching: true,
        ordering: true,
        dom : 'lfrtip',
        info: true,
        iDisplayLength: 10,
        lengthMenu: [
            [ 10, 50, 100, -1],
            [10, 50, 100, "All"]
        ],
        ajax: {
            url: "{{ route('get_all_cashouts') }}",
            data: {
                _token: tempcsrf,
            },
            error: function(xhr, error, thrown) {
               alert("undefind error")
            }
        },
       
        columns: [
           
        { data: 'select_all', name: 'select_all', orderable: false, searchable: false },
            {
                data: 'id',
                name: '#',
                orderable: true,
                searchable: true
            },
            {
                data: 'type_id',
                name: 'type_id',
                orderable: true,
                searchable: true
            },
            {
                data: 'status_id',
                name: 'status_id',
                orderable: true,
                searchable: true
            },
            {
                data: 'amount',
                name: 'amount',
                orderable: true,
                searchable: true
            },
            {
                data: 'respondent_id',
                name: 'respondent_id',
                orderable: true,
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            }
        ],
        columnDefs: [
            {
                targets: 0,

            },
            {
                targets: 1
            },
            {
                targets: 2
            },
            {
                targets: 3
            },
            {
                targets: 4
            },
            {
                targets: 5,
            },
            { targets: 6,width: 115,className: "text-center" }
           
          
        ],
    });
}
</script>
