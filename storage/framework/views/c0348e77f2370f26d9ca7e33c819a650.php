
<?php echo $__env->make('admin.layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.layout.horizontal_left_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.layout.horizontal_right_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin.layout.vertical_side_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Panel Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Panel Details</li>
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
                            <div class="mb-0" >
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <td><?php echo e($data->id); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td><?php echo e($data->name); ?></td>
                                        </tr>
                                        <tr>
                                            <th>color</th>
                                            <td><button type="button" class="btn waves-effect waves-light"
                                                    style="background-color:<?php echo e($data->colour); ?>"><i class="uil uil-user"></i></button>
                                            </td>
                                        </tr>
                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- rewards start page title -->
         

                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<?php echo $__env->make('admin.layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldPushContent('adminside-js'); ?>
<?php echo $__env->yieldPushContent('adminside-validataion'); ?>
<?php echo $__env->yieldPushContent('adminside-confirm'); ?>
<?php echo $__env->yieldPushContent('adminside-datatable'); ?>
<?php /**PATH C:\wamp64\www\bms_new\resources\views/admin/tags/view.blade.php ENDPATH**/ ?>