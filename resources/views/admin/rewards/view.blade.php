@include('admin.layout.header')
    @yield('adminside-favicon')
    @yield('adminside-css')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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
                                    <h4 class="mb-0">Reward Details: {{$data->id}}</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Rewards</li>
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
                                        <div class="d-flex justify-content-end">
                                            <button onclick="window.location='{{ route('rewards') }}';"
                                                class="btn btn-secondary waves-effect" type="button">
                                                <i class="fa fa-arrow-circle-o-left"></i>
                                            </button>&nbsp;&nbsp;
                                            
                                        </div>
                                        <div class="table-responsive mb-0" >
                                            <table class="table">
                                                <thead>
                                              
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <th>ID</th>
                                                    <td>{{$data->id}}</td>
                                                </tr>

                                                <tr>
                                                    <th>Reward Amount (R)</th>
                                                    <td>{{$data->points}}</td>
                                                </tr>

                                                <tr>
                                                    <th>Status</th>
                                                    <td>
                                                    @if($data->status_id==1)
                                                        {{'Pending'}}

                                                    @elseif($data->status_id==2)

                                                        {{'Approved'}}

                                                    @elseif($data->status_id==3)

                                                        {{'-'}}

                                                    @elseif($data->status_id==4)

                                                        {{'Processed'}}

                                                    @else
                                                        {{'-'}}

                                                    @endif
                                                        
                                                   
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>Respondent</th>
                                                    <td>
                                                        
                                                        {{$data->rname}} - {{$data->remail}} - {{$data->rmobile}}         
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>User</th>
                                                    <td>{{$data->uname}}
                                                        
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>Project</th>
                                                    <td>{{$data->pname}}</td>
                                                </tr>
                                              
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

@yield('adminside-script')
@include('admin.layout.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
     var tempcsrf = '{!! csrf_token() !!}';
      $(document).on('click', '#delete_content', function(e) {
            e.preventDefault();

            // $(this).text('Deleting..');
            var id = $(this).data("id");

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            var url = "{{ route('delete_contents', ':id') }}";
	            url = url.replace(':id', id);
              
            $.confirm({
                title: 'Delete user?',
                content: 'This dialog will automatically trigger \'cancel\' in 6 seconds if you don\'t respond.',
                autoClose: 'cancelAction|8000',
                buttons: {
                    deleteUser: {
                        text: 'delete user',
                        action: function() {
                            $.ajax({
                                
                                type: "DELETE",
                                data: {
                                    _token: tempcsrf,
                                },
                                url: url,
                                dataType: "json",
                                success: function(response) {
                                    // console.log(response);
                                    if (response.status == 404) {

                                        $('.delete_student').text('');
                                    } else {

                                       window.location.href="{{ route('contents') }}";

                                    }
                                }
                            });

                        }
                    },
                    cancelAction: function() {
                        $.alert('action is canceled');
                    }
                }
            });



        });
           


       
</script>
<script src="{{ asset('public/assets/js/jquery.validate.js') }}"></script>