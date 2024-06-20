{{ Form::model($survey, array('route' => array('survey.update', $survey->id),
'method' => 'POST' ,'id'=>'editsurvey','class'=>'needs-validation')) }}

<div class="modal-body">
    <div>
            {{ Form::label('title', __('Survey Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::text('title', null, array('class' => 'form-control',
            'placeholder'=>__('Enter Survey Name'),'required'=>'required')) }}
    </div>
    <br>
    <div>
            {!! Form::label('survey_type', 'Survey Type') !!}<span class="text-danger pl-1">*</span>
            <br>
            <div class="options">{{ Form::radio('survey_type', 'survey' , true,['class'=>'survey_type']) }}&nbsp&nbsp&nbsp{{ __('Survey') }} &nbsp&nbsp&nbsp
            {{ Form::radio('survey_type', 'profile' , false,['class'=>'survey_type']) }}&nbsp&nbsp&nbsp{{ __('Profile') }}</div>
    </div>
    <br>
    <br>
        <div>
            {!! Form::label('shareable_type', 'Shareable Type') !!}<span class="text-danger pl-1">*</span>
            <br>
            <div class="options">
                {{ Form::radio('shareable_type', 'noshare' , true,['class'=>'shareable_type']) }}&nbsp;&nbsp;&nbsp;{{ __('Not Shareable') }} &nbsp;&nbsp;&nbsp;
                {{ Form::radio('shareable_type', 'share' , false,['class'=>'shareable_type']) }}&nbsp;&nbsp;&nbsp;{{ __('Shareable') }}
                </div>
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
input.survey_type, input.shareable_type{
    accent-color: #448E97;
}

</style>