{{ Form::model($survey, array('route' => array('survey.movesurveyupdate', $survey->id),
'method' => 'POST' ,'id'=>'movesurvey','class'=>'needs-validation')) }}

<div class="modal-body">
    <input type="hidden" name="survey_id" id="survey_id" value="{{$survey->id}}"/>
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
        <div class="rounded-md bg-grey-7 d-flex py-3 px-4 mt-3"><svg xmlns="http://www.w3.org/2000/svg" class="mt-1" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M6.33934 6.49902H7.10601V9.33236" stroke="#979797" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6.33333 9.33252H7.87289" stroke="#979797" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.06667 4.49723C7.06667 4.5302 7.0569 4.56242 7.03858 4.58983C7.02027 4.61724 6.99424 4.6386 6.96379 4.65121C6.93333 4.66383 6.89982 4.66713 6.86749 4.6607C6.83516 4.65427 6.80546 4.63839 6.78215 4.61508C6.75884 4.59178 6.74297 4.56208 6.73654 4.52975C6.73011 4.49742 6.73341 4.46391 6.74602 4.43345C6.75864 4.403 6.78 4.37697 6.80741 4.35865C6.83482 4.34034 6.86704 4.33057 6.9 4.33057" stroke="#979797" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6.90001 4.33057C6.94421 4.33057 6.9866 4.34813 7.01786 4.37938C7.04912 4.41064 7.06668 4.45303 7.06668 4.49723" stroke="#979797" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M9.66667 0.999023H4.33333C2.49238 0.999023 1 2.49141 1 4.33236V9.66569C1 11.5066 2.49238 12.999 4.33333 12.999H9.66667C11.5076 12.999 13 11.5066 13 9.66569V4.33236C13 2.49141 11.5076 0.999023 9.66667 0.999023Z" stroke="#979797" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg><h4 class="ss-text ss-text__size--h4 ss-text__color--black ms-2 foldermove">Once moved, the Folder owner will have complete access to this survey.</h4></div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light"  data-dismiss="modal">
    <input type="submit" id="updated_survey" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

<script>
    $('#movesurvey').validate({
        rules: {
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
    .foldermove {
        margin-left: 6px;
    }
</style>