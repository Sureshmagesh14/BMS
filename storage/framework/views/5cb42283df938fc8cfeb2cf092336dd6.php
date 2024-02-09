<form id="projects_form" class="validation">
    <?php echo csrf_field(); ?>
    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name / Code *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="number" name="number">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Client *
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="client" name="client">
        </div>
    </div>


    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Name *</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Creator *</label>
        <div class="col-md-10">
            <select id="user" name="user" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option value="3">
                    Alison Steven
                </option>
                <option value="8">
                    Ano Gandure
                </option>
                <option value="4">
                    Brad FV
                </option>
                <option value="21">
                    Busisiwe Nhlapo
                </option>
                <option value="13">
                    Clinton Mtambo
                </option>
                <option value="12">
                    Demo User
                </option>
                <option value="16">
                    Michelle Cremer
                </option>
                <option value="17">
                    Mojalefa Malope
                </option>
                <option value="19">
                    Nissar Goolam
                </option>
                <option value="22">
                    Nokuthula Magubane
                </option>
                <option value="20">
                    Nontando Diniso
                </option>
                <option value="23">
                    Tebogo Dlamini
                </option>
                <option value="6">
                    Towdah Ndhlovu
                </option>
                <option value="1">
                    Wade FV
                </option>
            </select>
        </div>
    </div>



    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Type *
        </label>
        <div class="col-md-10">
            <select id="type_id" name="type_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option value="1">
                    Pre-Screener
                </option>
                <option value="2">
                    Pre-Task
                </option>
                <option value="3">
                    Paid survey
                </option>
                <option value="4">
                    Unpaid survey
                </option>
            </select>
        </div>
    </div>


    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Reward Amount (R)
        </label>
        <div class="col-md-10">
            <input type="number" class="form-control" id="reward" name="reward">
        </div>
    </div>

    <?php
        $refcode = \App\Models\Respondents::randomPassword(); #function call
    ?>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Project Link
        </label>
        <div class="col-md-10">
            <input type="url" class="form-control" id="project_link" name="project_link"
                value="<?php echo e(Config::get('constants.url') . $refcode); ?>" disabled>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Status *
        </label>
        <div class="col-md-10">
            <select id="status_id" name="status_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option value="1">
                    Pending
                </option>
                <option value="2">
                    Active
                </option>
                <option value="3">
                    Completed
                </option>
                <option value="4">
                    Cancelled
                </option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Description
        </label>
        <div class="col-md-10">
            <textarea class="form-control" name="description" id="description"></textarea>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email Description 1
        </label>
        <div class="col-md-10">
            <textarea class="form-control" name="description1" id="description1"></textarea>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Email Description 2 (Pre-task only)

        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="description2" name="description2">
        </div>
    </div>

    <div class="form-group row">
        <label for="example-text-input" class="col-md-2 col-form-label">Survey Duration (Minutes) *</label>
        <div class="col-md-10">
            <input type="number" class="form-control" id="survey_duration" name="survey_duration">

        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Live Date *
        </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="published_date" name="published_date" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Closing Date
        </label>
        <div class="col-md-10">
            <input type="date" class="form-control" id="closing_date" name="closing_date">
        </div>
    </div>



    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Accessibility *
        </label>
        <div class="col-md-10">
            <select id="access_id" name="access_id" class="w-full form-control form-select" required>
                <option value="" selected="selected" disabled="disabled">
                    Choose an option
                </option>
                <option value="1">
                    Shareable
                </option>
                <option value="2">
                    Assigned
                </option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="example-search-input" class="col-md-2 col-form-label">Survey Link *
        </label>
        <div class="col-md-10">
            <input type="url" class="form-control" id="survey_link" name="survey_link">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="projects_create">Create New</button>
    </div>
</form>


<script>
    $("#projects_create").click(function() {
        if (!$("#projects_form").valid()) { // Not Valid
            return false;
        } else {
            var data = $('#projects_form').serialize();

            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('projects.store')); ?>",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#projects_create').html('....Please wait');
                },
                success: function(response) {
                    toastr.success(response.message);
                    $("#commonModal").modal('hide');
                    datatable();
                },
                complete: function(response) {
                    $('#projects_create').html('Create New');
                }
            });
        }
    });
</script>
<?php /**PATH C:\wamp64\www\bms_new\resources\views/admin/projects/create.blade.php ENDPATH**/ ?>