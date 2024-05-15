    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    © 
                    <script>
                        document.write(new Date().getFullYear())
                    </script> {{Config::get('constants.footer')}}.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-right d-none d-sm-block">
                       
                    </div>
                    </script> © BMS.
                </div>
                {{-- <div class="col-sm-6">
                    <!-- <div class="text-sm-right d-none d-sm-block">
                        Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://themesbrand.com/"
                            target="_blank" class="text-reset">Themesbrand</a>
                    </div> -->
                </div> --}}
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
                    <img src="{{ asset('assets/images/layouts/layout-1.jpg') }}" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch" checked />
                    <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('assets/images/layouts/layout-2.jpg') }}" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-3">
                    <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch" data-bsStyle="{{ asset('assets/css/bootstrap-dark.min.css') }}" data-appStyle="{{ asset('assets/css/app-dark.min.css') }}" />
                    <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('assets/images/layouts/layout-3.jpg') }}" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="custom-control custom-switch mb-5">
                    <input type="checkbox" class="custom-control-input theme-choice" id="rtl-mode-switch" data-appStyle="{{ asset('assets/css/app-rtl.min.css') }}" />
                    <label class="custom-control-label" for="rtl-mode-switch">RTL Mode</label>
                </div>
            </div>
        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->
@stop

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Common modal -->
<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            
        </div>
    </div>
</div>

    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    
    @push('adminside-js')
        <!-- JAVASCRIPT -->
        {{-- <script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}
        <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>

        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/toastr.init.js') }}"></script>
        <script src="{{ asset('assets/libs/parsleyjs/parsley.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
        <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
        
        {{-- <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script> --}}

        <!-- apexcharts -->
        {{-- <script src="{{ asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script> --}}
        {{-- <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script> --}}
       
        <script src="{{ asset('assets/js/admin/app.js') }}"></script>
        <script src="{{ asset('assets/js/admin/common.js') }}"></script>
        <script src="{{ asset('assets/js/admin/jquery.validate.js') }}"></script>
        <script src="{{ asset('assets/js/admin/confirm.min.js') }}"></script>

        <!-- Sweet Alerts js -->
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <!-- Sweet alert init js-->
        <script src="{{ asset('assets/js/pages/sweet-alerts.init.js') }}"></script>
        <script src="{{ asset('assets/tokeninput/jquery.tokeninput.js') }}"></script>
    @endpush

    @push('adminside-datatable')
        <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

        <!-- Buttons examples -->
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

        <!-- Responsive examples -->
        <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

        <!-- Datatable init js -->
        <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
    @endpush
    
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

    <script>
        var tempcsrf = '{!! csrf_token() !!}';
        function multi_delete(method_type, set_data, route, message, datatable_function){
            $.confirm({
                title: "{{ Config::get('constants.delete') }}",
                content: "{{ Config::get('constants.delete_confirmation') }}",
                autoClose: 'cancel|8000',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    delete: {
                        text: 'delete',
                        action: function() {
                            $.ajax({
                                type: method_type,
                                data: {
                                    _token: tempcsrf,
                                    all_id: set_data
                                },
                                url: route,
                                dataType: "json",
                                success: function(response) {
                                    $.alert(message);
                                    eval(datatable_function + "()");
                                    $(".delete_all_drop").hide();
                                    return 1;
                                }
                            });
                        }
                    },
                    cancel: function() {

                    }
                }
            });
        }

        function single_delete(method_type, set_data, route, message, datatable_function){
            if(message.indexOf("Deattach") != -1){
                titles = "De-attach Resource";
                contents = "Are you sure you want to deattach the selected resources?";
                texts = "Deattach";
            }
            else{
                titles = "{{ Config::get('constants.delete') }}";
                contents = "{{ Config::get('constants.delete_confirmation') }}";
                texts = "Delete";
            }

            $.confirm({
                title: titles,
                content: contents,
                autoClose: 'cancel|8000',
                buttons: {
                    delete: {
                        text: texts,
                        action: function() {
                            $.ajax({
                                type: method_type,
                                data: {
                                    _token: tempcsrf,
                                },
                                url: route,
                                dataType: "json",
                                success: function(response) {
                                    if (response.status == 404) {
                                        $('.delete_student').text('');
                                    } else {
                                        $.alert(message);
                                        eval(datatable_function + "()");
                                    }
                                }
                            });
                        }
                    },
                    cancel: function() {
                        
                    }
                }
            });
        }

        function select_action(method_type, set_data, value, route, datatable_function, titles, contents, texts){
            $.confirm({
                title: titles,
                content: contents,
                autoClose: 'cancel|8000',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    delete: {
                        text: texts,
                        action: function() {
                            $.ajax({
                                type: method_type,
                                data: {
                                    _token: tempcsrf,
                                    all_id: set_data,
                                    value: value,
                                },
                                url: route,
                                dataType: "json",
                                success: function(response) {
                                    if (response.status == 404) {
                                        $('.delete_student').text('');
                                    } else {
                                        toastr.success(response.message,"Success");
                                        eval(datatable_function + "()");
                                    }
                                }
                            });
                        }
                    },
                    cancel: function() {
                        
                    }
                }
            });
        }

        function excel_report(value, form, route, texthead, checkbox_value){
            $.confirm({
                title: texthead,
                content: "Are You Sure You Want To Run This Action",
                autoClose: 'cancel|8000',
                buttons: {
                    run: {
                        text: 'run',
                        action: function() {
                            $.post(route, {
                                _token: tempcsrf,
                                id_value: value,
                                form: form,
                                checkbox_value: checkbox_value
                            },
                            function(resp, textStatus, jqXHR) {
                                if(resp=='Error'){
                                    console.log("Error");
                                }
                                else{
                                    window.location.assign("../"+resp);
                                }
                            });
                        }
                    },
                    cancel: function() {
                        
                    }
                }
            });
        }

        function table_checkbox(get_this, table_id) {
            count_checkbox = $("#"+table_id+" .tabel_checkbox").filter(':checked').length;
            if (count_checkbox >= 1) {
                $("."+table_id+".hided_option").show();
                $("."+table_id+".show_hided_option").hide();
            } else {
                $("."+table_id+".hided_option").hide();
                $("."+table_id+".show_hided_option").show();
            }
        }
    </script>
</body>
</html>