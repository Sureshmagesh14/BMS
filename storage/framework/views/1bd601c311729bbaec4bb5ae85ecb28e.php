<?php echo $__env->make('admin.layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('adminside-favicon'); ?>
<?php echo $__env->yieldContent('adminside-css'); ?>

<?php echo $__env->make('admin.layout.horizontal_left_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.layout.horizontal_right_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.layout.vertical_side_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>            
<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/js/bootstrap-datetimepicker.min.js"></script>
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
                                    <h4 class="mb-0">Respondents</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Respondents</li>
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
                             
                                    
                                    <div class="form-group">
    <label>Date Range</label>
    <div>
        <div class="input-daterange input-group" data-provide="datepicker" data-date-format="dd M, yyyy" data-date-autoclose="true">
            <input type="text" class="form-control" name="start" />
            <input type="text" class="form-control" name="end" />
        </div>
    </div>
</div>




<div class="btn-group" role="group">
<button id="btnGroupVerticalDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
Export <i class="mdi mdi-chevron-down"></i>
</button>
<div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">

<a class="dropdown-item" href="<?php echo e(url('respondent_export/act')); ?>">Respondent Details</a>
<a class="dropdown-item" href="<?php echo e(url('gen_respondent_res_export')); ?>">General Respondent Activity by Respondent</a>
<a class="dropdown-item" href="<?php echo e(url('gen_respondent_mon_export')); ?>">General Respondent Activity by Month & Year</a>
</div>
</div>



<a data-toggle="modal" data-target="#exampleModal" data-backdrop="static" data-keyboard="false" class="btn btn-primary waves-effect waves-light">
    <i class="fa fa-file-excel"></i> Export </a>



                                        <a href="#!" data-url="<?php echo e(route('respondents.create')); ?>" data-size="xl" data-ajax-popup="true"
                                        class="btn btn-primary" data-bs-original-title="<?php echo e(__('Create Respondents')); ?>" class="btn btn-primary" data-size="xl"
                                         data-ajax-popup="true" data-bs-toggle="tooltip"
                                        id="create">
                                        Create Respondents
                                    </a>
                                        


                                    </div> 
                                 
                                    
                                 

                                        <h4 class="card-title"> </h4>
                                        <p class="card-title-desc"></p>
        
                                        <table id="myTable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Surname</th>
                                                <th>Mobile</th>
                                                <th>Whatsapp</th>
                                                <th>Email</th>
                                                <th>Age</th>
                                                <th>Gender</th>
                                                <th>Race</th>
                                                <th>Status</th>
                                                <th>Profile Completion</th>
                                                <th>Inactive Until</th>
                                                <th>Opted In</th>
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
        
        <form action="<?php echo e(url('export_cashout_year')); ?>">
        <?php echo csrf_field(); ?>


        <div class="form-group">
            <label>Date Range</label>
            <div>
                <div class="input-daterange input-group" data-provide="datepicker" data-date-format="dd M, yyyy" data-date-autoclose="true">
                    <input type="text" class="form-control" name="start" />
                    <input type="text" class="form-control" name="end" />
                </div>
            </div>
        </div>

        
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Select Year:</label>
            <select id="user" name="user" class="w-full form-control form-select" required="">
                <option value="" selected="selected" disabled="disabled">
                    Please select
                </option>

                <?php echo e($last= date('Y')-15); ?>

                <?php echo e($now = date('Y')); ?>


                <?php for($i = $now; $i >= $last; $i--): ?>
                    <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                <?php endfor; ?>
            </select>
          </div>
        

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Select Month:</label>
            <select id="user" name="user" class="w-full form-control form-select" required="">
                <option value="" selected="selected" disabled="disabled">
                    Please select
                </option>
         

                <?php for($i = 1; $i <= 12; $i++): ?>

                <?php 
                $lval= date('F', strtotime( "$i/12/10" ));
                ?> 
                <option value="<?php echo e($i); ?>"><?php echo e($lval); ?></option>
                <?php endfor; ?>
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


                <?php echo $__env->make('admin.layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
                <?php echo $__env->yieldPushContent('adminside-js'); ?>
                <?php echo $__env->yieldPushContent('adminside-validataion'); ?>
                <?php echo $__env->yieldPushContent('adminside-confirm'); ?>
                <?php echo $__env->yieldPushContent('adminside-datatable'); ?>
                

                <script>
                var tempcsrf = '<?php echo csrf_token(); ?>';
                $(document).ready(function() {
                    datatable();
                    
                    $('#datetimepicker1').datetimepicker({
                        format: 'L',
                        disabledHours: true,
                    });
                });
                
               
            
                function datatable(){
                    $('#myTable').dataTable().fnDestroy();
                    $('#myTable').DataTable({
                        searching: true,
                        ordering: true,
                        dom: 'lfrtip',
                        info: true,
                        iDisplayLength: 10,
                        lengthMenu: [
                            [10, 50, 100, -1],
                            [10, 50, 100, "All"]
                        ],
                        ajax: {
                            url: "<?php echo e(route('get_all_respondents')); ?>",
                            data: {
                                _token: tempcsrf,
                            },
                            error: function(xhr, error, thrown) {
                                alert("undefind error");
                            }
                        },
            
                        columns: [{
                            data: 'id',
                            name: '#',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'name',
                            name: 'name',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'surname',
                            name: 'surname',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'mobile',
                            name: 'mobile',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'whatsapp',
                            name: 'whatsapp',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'email',
                            name: 'email',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'age',
                            name: 'age',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'gender',
                            name: 'gender',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'race',
                            name: 'race',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'profile_completion',
                            name: 'profile_completion',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'inactive_until',
                            name: 'inactive_until',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'opeted_in',
                            name: 'opeted_in',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            width: 75,
                            className: "text-center"
                        },{
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
                            targets: 5
                        },
                        {
                            targets: 6
                        },
                        {
                            targets: 7
                        },
                        {
                            targets: 8
                        },
                        {
                            targets: 9
                        },
                        {
                            targets: 10
                        },
                        {
                            targets: 11
                        },
                        {
                            targets: 12
                        },
                        {
                            targets: 13,
                            width: 115,
                            className: "text-center"
                        }
                    ],
                    });
                }
            
                $(document).on('click', '#delete_respondents', function(e) {
                    e.preventDefault();
                    var id = $(this).data("id");
                    var url = "<?php echo e(route('respondents.destroy', ':id')); ?>";
                    url = url.replace(':id', id);
                  
                    $.confirm({
                        title: "<?php echo e(Config::get('constants.delete')); ?>",
                        content:  "<?php echo e(Config::get('constants.delete_confirmation')); ?>",
                        autoClose: 'cancelAction|8000',
                        buttons: {
                            delete: {
                                text: 'delete',
                                action: function() {
                                    $.ajax({
                                        type: "DELETE",
                                        data: {
                                            _token: tempcsrf,
                                        },
                                        url: url,
                                        dataType: "json",
                                        success: function(response) {
                                            if (response.status == 404) {
                                                $('.delete_student').text('');
                                            } else {
                                                datatable();
                                                $.alert('Respondents Deleted!');
                                                $('.delete_student').text('Yes Delete');
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
            </script>
            <?php /**PATH C:\wamp64\www\bms_new\resources\views/admin/respondents/index.blade.php ENDPATH**/ ?>