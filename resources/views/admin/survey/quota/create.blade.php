{{ Form::open(array('url' => route('survey.storequota'),'id'=>'createsurveyquota','class'=>'needs-validation')) }}

<div class="modal-body">
    <div>
        {{ Form::label('quota_name', __('Quota Label'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
        {{ Form::text('quota_name', null, array('class' => 'form-control',
        'placeholder'=>__('Enter Quota Label'),'required'=>'required')) }}
    </div>
    <br>
    <div>
        {{ Form::label('quota_limit', __('Quota Limit'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
        {{ Form::number('quota_limit', null, array('class' => 'form-control',
        'placeholder'=>__('Enter Quota Limit'),'required'=>'required')) }}
    </div>
    <br>
   
    <div class="surveyfoldername"> 
        <label class="control-label">Questions</label><span class="text-danger pl-1">*</span>
        <div class="form-group mb-0">
            <select class="select2 form-control" id="surveyfoldername" name="folder_id"  data-placeholder="Choose ...">
                <option value="">Choose Questions</option>
                @foreach($display_logic as $key=>$value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
                @foreach($display_logic_matrix as $key=>$value) 
                    <optgroup label="{{$value->question_name}}">
                        <?php if($value!=null){
                            if($value->qus_ans!=null){
                                $qusvalue1 = json_decode($value->qus_ans); 
                            }else{
                                $qusvalue1=[];
                            }
                        }else{
                            $qusvalue1=[];
                        }
                        $exiting_qus_matrix=$qusvalue1!=null ? explode(",",$qusvalue1->matrix_qus): []; $i=0; ?>
                        @foreach($exiting_qus_matrix as $key1=>$qus) 
                                <option value="{{$value->id}}_{{$key1}}">{{$qus}} </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light"  data-dismiss="modal">
    <input type="submit" id="create_folder" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

<script>
    
    $('#createsurvey').validate({
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
input.survey_type{
    accent-color: #448E97;
}

</style>