$(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
    var data = {};
    var title1 = $(this).data("title");
    var title2 = $(this).data("bs-original-title");
    var title = (title1 != undefined) ? title1 : title2;
    var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
    var url = $(this).data('url');
    let color = $(this).data("color");

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
        data: data,
        success: function (data) {
            if(data['html_page'] != undefined){
                $('#commonModal .modal-body').html(data['html_page']);
            }
            else{
                $('#commonModal .modal-body').html(data);
            }
            
            $("#commonModal").modal('show');
            // daterange_set();
            common_bind("#commonModal");
        },
        error: function (data) {
            data = data.responseJSON;

            toastr.error("Something Went Wrong");
        }
    });
});

$(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
});

function common_bind() {
    select2();
}

function select2() {
    if ($(".select2").length > 0) {
        if($('#user_ids').val()!=undefined && $('#user_ids').val()!=''){
            $('#privateusers').val($('#user_ids').val().split(","));
        }
        $('.select2').select2();
    }
}

$(document).on('change', '.select_all', function (e) {
    var checkboxes = $(this).closest('table').find(':checkbox');
    checkboxes.prop('checked', $(this).is(':checked'));
    if ($(this).is(':checked')) {
        $("#delete_all_drop").show();
    }
    else{
        $("#delete_all_drop").hide();
    }
});

toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "newestOnTop": false,
}


// toastr.success("{{ session('success') }}");
// toastr.error("{{ session('error') }}");