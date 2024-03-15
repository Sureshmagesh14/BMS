{{ Form::model($survey, array('route' => array('survey.updatesettings', $survey->id),
'method' => 'POST' ,'id'=>'surveysettings','class'=>'needs-validation')) }}

<div class="modal-body">
    <div>
            {{ Form::label('avg_completion_time', __('Avg Completion Time'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::text('avg_completion_time', null, array('class' => 'form-control',
            'placeholder'=>__('Enter Avg Completion Time'),'required'=>'required')) }}
    </div>
    <br>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light"  data-dismiss="modal">
    <input type="submit" id="create_folder" value="{{__('Save')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

<script>
    // $('#multipleSelect').val(str1.split(" "););

    $('#surveysettings').validate({
        rules: {
            avg_completion_time:{
                required: true,
            },
            
            
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
   

    $(".folder_type").change(function() {
        if ($("input[name='folder_type']:checked").val() == 'private') {
            $(".privateusers").css("display","block");
            $("#privateusers").prop("required", true);

        }
        if ($("input[name='folder_type']:checked").val() == 'public') {
            $(".privateusers").css("display","none");
            $("#privateusers").prop("required", false);

        }
    });
</script>
<style>
.btn.btn-primary{
    color: #fff !important;
    border: thin solid #448E97 !important;
    background-color: #448E97 !important;
}
input.folder_type{
    accent-color: #448E97;
}

.select2-container--default .select2-results__option[aria-selected=true]:hover,.select2-container--default .select2-results__option--highlighted[aria-selected]{
    background-color:#448E97 !important;
}
</style>