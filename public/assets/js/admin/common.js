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
            $('#commonModal .modal-body').html(data['html_page']);
            $("#commonModal").modal('show');
        },
        error: function (data) {
            data = data.responseJSON;

            toastr.error("Something Went Wrong");
        }
    });
});

// Create Form
$(document).on('click', '#create_and_store', function (e) {
    e.preventDefault();
    create_route = $(this).data('create_route');
    form_name = $(this).data('form_name');
    var data = $('#'+form_name).serialize();
    $.ajax({
        type: 'POST',
        url: create_route,
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        // beforeSend: function() {
        //     $('#create_content').html('....Please wait');
        // },
        success: function(response) {
            toastr.success(response.message);
        },
        // complete: function(response) {
        //     $('#create_content').html('Create New');
        // }
    });
});

// Update Form
$(document).on('click', '#update_and_edit', function (e) {
    e.preventDefault();
    update_route = $(this).data('update_route');
    form_name = $(this).data('form_name');
    var data = $('#'+form_name).serialize();
    
    $.ajax({
        type: "POST",
        url: update_route,
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            toastr.success(response.message);
        },
    });
});

toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "newestOnTop": false,
}


// toastr.success("{{ session('success') }}");
// toastr.error("{{ session('error') }}");