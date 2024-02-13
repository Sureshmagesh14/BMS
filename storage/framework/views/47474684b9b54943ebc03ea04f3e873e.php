<?php echo $__env->make('admin.layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('adminside-favicon'); ?>
<?php echo $__env->yieldContent('adminside-css'); ?>

<?php echo $__env->make('admin.layout.horizontal_left_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.layout.horizontal_right_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.layout.vertical_side_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                    <h4 class="mb-0">projects</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">projects</li>
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


<a href="#!" data-url="<?php echo e(route('export_projects')); ?>" data-size="xl" data-ajax-popup="true"
    class="btn btn-primary" data-bs-original-title="<?php echo e(__('Respondent Projects')); ?>" class="btn btn-primary" data-size="xl"
        data-ajax-popup="true" data-bs-toggle="tooltip"
    id="export">
    Export
</a>
                                        </div>

                                        <h4 class="card-title"> </h4>
                                        <p class="card-title-desc"></p>
        
                                        <table id="myTable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                
                                                <th>#</th>
                                                <th>Number/Code</th>
                                                <th>Client</th>
                                                <th>Name</th>
                                                <th>Creator</th>
                                                <th>Type</th>
                                                <th>Reward Amount</th>
                                                <th>Project Link</th>
                                                <th>Created</th>
                                                <th>Status</th>                                               
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


            
    <?php echo $__env->make('admin.layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
    <?php echo $__env->yieldPushContent('adminside-js'); ?>
    <?php echo $__env->yieldPushContent('adminside-validataion'); ?>
    <?php echo $__env->yieldPushContent('adminside-confirm'); ?>
    <?php echo $__env->yieldPushContent('adminside-datatable'); ?>


    <script>
        var tempcsrf = '<?php echo csrf_token(); ?>';
        $(document).ready(function() {
            datatable();
          
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
                    url: "<?php echo e(route('get_all_projects')); ?>",
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
                data: 'numbers',
                name: 'numbers',
                orderable: true,
                searchable: true
            },
            {
                data: 'client',
                name: 'client',
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
                data: 'creator',
                name: 'creator',
                orderable: true,
                searchable: true
            },
            {
                data: 'type',
                name: 'type',
                orderable: true,
                searchable: true
            },
            {
                data: 'reward_amount',
                name: 'reward_amount',
                orderable: true,
                searchable: true
            },
            {
                data: 'project_link',
                name: 'project_link',
                orderable: true,
                searchable: true
            },
            {
                data: 'created',
                name: 'created',
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
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
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
                targets: 3,
                width: 175,
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
                targets: 10,
                width: 115,
                className: "text-center"
            }
        ],
            });
        }
    
        $(document).on('click', '#delete_projects', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "<?php echo e(route('projects.destroy', ':id')); ?>";
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
                                        $.alert('Project Deleted!');
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
    <?php /**PATH C:\wamp64\www\bms_new\resources\views/admin/projects/index.blade.php ENDPATH**/ ?>