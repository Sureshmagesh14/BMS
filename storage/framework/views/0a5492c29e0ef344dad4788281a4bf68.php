<?php echo $__env->make('admin.layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('adminside-favicon'); ?>
<?php echo $__env->yieldContent('adminside-css'); ?>

<?php echo $__env->make('admin.layout.horizontal_left_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.layout.horizontal_right_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.layout.vertical_side_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


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
                                    <h4 class="mb-0">Actions</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Actions</li>
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
                                            
                                        </div>

                                        <h4 class="card-title"> </h4>
                                        <p class="card-title-desc"></p>
        
                                        <table id="myTable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                
                                                <th>#</th>
                                                <th>ACTION NAME</th>                                           
                                                <th>ACTION INITIATED BY	</th>
                                                <th>ACTION TARGET</th>
                                                <th>ACTION STATUS</th>
                                                <th>ACTION HAPPENED AT</th>
                                                <th></th>
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
<?php echo $__env->make('admin.layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
$(document).ready(function() {
    var tempcsrf = '<?php echo csrf_token(); ?>';
    
    $('#myTable').dataTable().fnDestroy();

    $('#myTable').DataTable({
      
        searching: true,
        serverSide: true,
        deferRender: true,
        ordering: true,
        dom : 'lfrtip',
        info: true,
        iDisplayLength: 10,
        lengthMenu: [
            [ 10, 50, 100, -1],
            [10, 50, 100, "All"]
        ],
        ajax: {
            url: "<?php echo e(route('get_all_actions')); ?>",
            data: {
                _token: tempcsrf,
            },
            error: function(xhr, error, thrown) {
               alert("undefind error")
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
                data: 'uname',
                name: 'uname',
                orderable: true,
                searchable: true
            },
            {
                data: 'target_id',
                name: 'target_id',
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
                data: 'updated_at',
                name: 'updated_at',
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
                targets: 2,
                width: 115,
                className: "text-center"
            }
        ],
    });
});
</script>
<?php /**PATH C:\wamp64\www\bms_new\resources\views/admin/action/index.blade.php ENDPATH**/ ?>