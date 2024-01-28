@include('admin.layout.header')
    @yield('adminside-favicon')
    @yield('adminside-css')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')

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
                        <h4 class="mb-0">Survey</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Survey</a></li>
                                <li class="breadcrumb-item active">Survey</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}" />
            <div class="createBtn">
            <a href="#" class="mx-3 btn btn-sm align-items-center" data-url="{{route('survey.create')}}" data-ajax-popup="true" data-bs-toggle="tooltip" title="Create Survey" data-title="Create Survey"><button type="button" class="btn btn-primary waves-effect waves-light">Create Survey <i class="far fa-sticky-note"></i></i></button></a>
                

            </div>
            <!-- end page title -->
            <table class="table table-vcenter card-table" id="survey-table">
                <thead>
                    <tr>
                        <th>Survey ID</th>
                        <th>Folder Name</th>
                        <th>Survey Name</th>
                        <th>Add Questions</th>
                        <th>Created On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                
            </table>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <script src="{{ asset('/assets/js/jquery.min.js') }}"></script>

<style>
div#survey-table_wrapper .row {
    width: 100%;
}

</style>
<script>
 $(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
    var data = {};
    var title1 = $(this).data("title");
    var title2 = $(this).data("bs-original-title");
    var title = (title1 != undefined) ? title1 : title2;
    var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
    var url = $(this).data('url');
    let color = $(this).data("color");

    $("#colortype").val(color);
    $("#commonModal .modal-title").html(title);
    $("#commonModal .modal-dialog").addClass('modal-' + size);

    $.ajax({
        url: url,
        data: data,
        success: function (data) {
            $('#commonModal .body').html(data);
            $("#commonModal").modal('show');
            // daterange_set();
            common_bind("#commonModal");

        },
        error: function (data) {
            data = data.responseJSON;
            console.log( data.error)
        }
    });

});

function common_bind() {
    select2();
}

function surveydelete(url,id){
    Swal.fire({ 
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning", showCancelButton: !0, 
        confirmButtonColor: "#34c38f", 
        cancelButtonColor: "#f46a6a", 
        confirmButtonText: "Yes, delete it!" 
    }).then(function (t) { 
        if(t.isConfirmed){
            $.ajax({url: url, success: function(result){
                result = JSON.parse(result);
                if(result.error!=''){
                    t.value && Swal.fire("Warning!", result.error, "warning") ;
                }else{
                    t.value && Swal.fire("Deleted!", result.success, "success") ;
                }
                survey_datatable();
            }});
        }
        
    })
    console.log(id)
}
   
function select2() {
    if ($(".select2").length > 0) {
        if($('#user_ids').val()!=undefined && $('#user_ids').val()!=''){
            $('#privateusers').val($('#user_ids').val().split(","));
        }
       
        $('.select2').select2();
    }
    
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    survey_datatable();
});

function survey_datatable(){
    $('#survey-table').dataTable().fnDestroy();
    $('#survey-table').DataTable({
        processing: true,
        serverSide: true,
        pagingType: 'full_numbers',
        aaSorting: [],
        "language": {
            "sLengthMenu": "Show _MENU_ Records",
            "sZeroRecords": "No data available in table",
            "sEmptyTable": "No data available in table",
            "sInfo": "Showing records _START_ to _END_ of a total of _TOTAL_ records",
            "sInfoFiltered": "filtering of a total of _MAX_ records",
            "sSearch": "Search:",
            "oPaginate": {
                "sFirst": "First",
                "sLast": "Last",
                "sNext": "Next",
                "sPrevious": "Previous"
            },
        },
        ajax: {
            url: "{{ route('survery.survey') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
                data: function (data) {
            }
        },
        order: [],
        columnDefs: [ { orderable: true, targets: [0,1,3,4]}],
        pageLength: 10,
        searching: true,
        aoColumns: [
            {data: 'id'},
            {data: 'folder_id'},
            {data: 'survey_name'},
            {data: 'add_template'},
            {data: 'created_at'},
            {data: 'actions'}
        ]
    });
}
</script>
    @yield('adminside-script')
@include('admin.layout.footer')
