    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © {{Config::get('constants.app_title')}}.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-right d-none d-sm-block">
                       
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->
@section('adminside-theme')
    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title px-3 py-4">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
                <h5 class="m-0">Settings</h5>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="{{ asset('public/assets/images/layouts/layout-1.jpg') }}" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch" checked />
                    <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('public/assets/images/layouts/layout-2.jpg') }}" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch" data-bsStyle="{{ asset('public/assets/css/bootstrap-dark.min.css') }}" data-appStyle="{{ asset('assets/css/app-dark.min.css') }}" />
                    <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('public/assets/images/layouts/layout-3.jpg') }}" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-5">
                    <input type="checkbox" class="custom-control-input theme-choice" id="rtl-mode-switch" data-appStyle="{{ asset('public/assets/css/app-rtl.min.css') }}" />
                    <label class="custom-control-label" for="rtl-mode-switch">RTL Mode</label>
                </div>
            </div>
        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->
@stop

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('public/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('public/assets/libs/feather-icons/feather.min.js') }}"></script>



     <!-- Required datatable js -->
     <script src="{{ asset('public/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

        <!-- Buttons examples -->
        <script src="{{ asset('public/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
        <script src="{{ asset('public/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
        
        <!-- Responsive examples -->
        <script src="{{ asset('public/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('public/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

        <!-- Datatable init js -->
        <script src="{{ asset('public/assets/js/pages/datatables.init.js') }}"></script>


    <!-- Responsive Table js -->
        <script src="{{ asset('public/assets/libs/admin-resources/rwd-table/rwd-table.min.js') }}"></script>

        <!-- Init js -->
        <script src="{{ asset('public/assets/js/pages/table-responsive.init.js') }}"></script>
  

    <script src="{{ asset('public/assets/js/app.js') }}"></script>


</body>
</html>