<footer class="pos-fixed bg-white">
    <!-- <div class="container"> -->
    <div class="container py-2">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 col-sm-12">
                <div class="d-md-flex d-lg-flex d-sm-block align-items-end">
                    <p class="mb-0 pb-0">@
                        <script>
                            document.write(new Date().getFullYear())
                        </script> {{ Config::get('constants.app_title') }}
                    </p>
                    <a  class="ps-2" href="{{ route('terms') }}" class="nav-link mb-0 pb-0">Terms & Conditions</a>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="social-icons text-md-end text-lg-end text-sm-start">
                    <a href="https://www.instagram.com/thebrandsurgeon/?igshid=YmMyMTA2M2Y%3D" target="_blank"><i
                            class="fa fa-instagram" aria-hidden="true"></i></a>
                    <a href="https://www.facebook.com/thebrandsurgeonsa" target="_blank"><i class="fa fa-facebook"
                            aria-hidden="true"></i></a>
                    <a href="https://www.linkedin.com/company/the-brand-surgeon-company/" target="_blank"><i
                            class="fa fa-linkedin" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
</footer>

<!-- Common modal -->
<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle"></h5>
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

</body>
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('assets/js/admin/jquery.validate.js') }}"></script>

<script src="{{ asset('assets/js/admin/confirm.min.js') }}"></script>

<script>
    $(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]',
        function() {
            var data = {};
            var title1 = $(this).data("title");
            var title2 = $(this).data("bs-original-title");
            var title = (title1 != undefined) ? title1 : title2;
            var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
            var url = $(this).data('url');
            let color = $(this).data("color");
            let value = $(this).data("value");

            $("#colortype").val(color);
            $("#commonModal .modal-title").html(title);
            $("#commonModal .modal-dialog").addClass('modal-' + size);

            if ($('#vc_name_hidden').length > 0) {
                data['vc_name'] = $('#vc_name_hidden').val();
            }
            if ($('#warehouse_name_hidden').length > 0) {
                data['warehouse_name'] = $('#warehouse_name_hidden').val();
            }

            $.ajax({
                url: url,
                data: {
                    value
                },
                success: function(data) {
                    if (data['html_page'] != undefined) {
                        $('#commonModal .modal-body').html(data['html_page']);
                    } else {
                        $('#commonModal .modal-body').html(data);
                    }

                    $("#commonModal").modal('show');
                },
                error: function(data) {
                    data = data.responseJSON;
                    toastr.error("Something Went Wrong");
                }
            });
        });
    $(document).ready(function() {
        setTimeout(function() {
            $('#container').addClass('loaded');
            // Once the container has finished, the scroll appears
            if ($('#container').hasClass('loaded')) {
                // It is so that once the container is gone, the entire preloader section is deleted
                $('#preloader').delay(1000).queue(function() {
                    $(this).remove();
                });
            }
        }, 400);
    });
</script>

</html>
