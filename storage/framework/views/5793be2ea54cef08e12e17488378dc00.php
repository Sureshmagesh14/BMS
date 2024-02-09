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
                        <h4 class="mb-0">Networks</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Networks</li>
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
                                <a href="#!" data-url="<?php echo e(route('networks.create')); ?>" data-size="xl" data-ajax-popup="true"
                                    class="btn btn-primary" data-bs-original-title="<?php echo e(__('Create Networks')); ?>" class="btn btn-primary" data-size="xl"
                                     data-ajax-popup="true" data-bs-toggle="tooltip"
                                    >
                                    Create Networks
                                </a>
                            </div>

                            <h4 class="card-title"> </h4>
                            <p class="card-title-desc"></p>

                            <table id="myTable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
            $("#content_create_form-data").validate();
        });
        
        $("#content_create_form-data").validate();

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
                    url: "<?php echo e(route('get_all_networks')); ?>",
                    data: {
                        _token: tempcsrf,
                    },
                    error: function(xhr, error, thrown) {
                        alert("undefind error");
                    }
                },

                columns: [
                    { data: 'id', name: '#', orderable: true, searchable: true },
                    { data: 'name', name: 'name', orderable: true, searchable: true },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                columnDefs: [
                    { targets: 0,width: 75,className: "text-center" },
                    { targets: 1 },
                    { targets: 2,width: 115,className: "text-center" }
                ],
            });
        }

        $(document).on('click', '#delete_network', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = "<?php echo e(route('networks.destroy', ':id')); ?>";
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
                                        $.alert('Network Deleted!');
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
    
<?php /**PATH C:\wamp64\www\bms_new\resources\views/admin/networks/index.blade.php ENDPATH**/ ?>