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



<a href="#!" data-url="<?php echo e(route('export_cash')); ?>" data-size="xl" data-ajax-popup="true"
                                        class="btn btn-primary" data-bs-original-title="<?php echo e(__('Cashout Summary')); ?>" class="btn btn-primary" data-size="xl"
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
                                                
                                                <th>
                                                    <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="checkAll">
                                                    <label class="custom-control-label" for="checkAll"></label>
                                                    </div>
                                                </th>
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
        
        <form action="<?php echo e(url('export_cashout_year')); ?>">
        <?php echo csrf_field(); ?>
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
$(document).ready(function() {
    var tempcsrf = '<?php echo csrf_token(); ?>';
    
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
            url: "<?php echo e(route('get_all_cashouts')); ?>",
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
                width: 75,
                className: "text-center"
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
                width: 175,
                className: "text-center"
            }
        ],
    });
});
</script>
<?php /**PATH C:\wamp64\www\bms_new\resources\views/admin/cashouts/index.blade.php ENDPATH**/ ?>