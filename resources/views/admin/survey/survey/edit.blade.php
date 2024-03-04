{{ Form::model($survey, array('route' => array('survey.update', $survey->id),
'method' => 'POST' ,'id'=>'editsurvey','class'=>'needs-validation')) }}

<div class="modal-body">
    <div>
            {{ Form::label('title', __('Survey Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::text('title', null, array('class' => 'form-control',
            'placeholder'=>__('Enter Survey Name'),'required'=>'required')) }}
    </div>
    <br>
    <input type="hidden" name="id" id="id" value="{{$survey->id}}"/>
   
    <div class="surveyfoldername"> 
        <label class="control-label">Select Folder</label><span class="text-danger pl-1">*</span>
        <div class="form-group mb-0">
            <select class="select2 form-control" id="surveyfoldername" name="folder_id"  data-placeholder="Choose ...">
                <option value="">Choose Folder</option>
                @foreach($folders as $key=>$value)
                    <option value="{{$key}}" @if($key==$survey->folder_id) selected @endif>{{$value}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light"  data-dismiss="modal">
    <input type="submit" id="updated_survey" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

<script>
    $('#editsurvey').validate({
        rules: {
            title:{
                required: true,
            },
            folder_id: {
                required: true,
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
   

</script>
<style>
.btn.btn-primary{
    color: #fff !important;
    border: thin solid #448E97 !important;
    background-color: #448E97 !important;
}
.select2-container--default .select2-results__option[aria-selected=true]:hover,.select2-container--default .select2-results__option--highlighted[aria-selected]{
    background-color:#448E97 !important;
}
</style>