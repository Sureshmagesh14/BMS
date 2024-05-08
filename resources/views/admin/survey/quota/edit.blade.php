{{ Form::model($quota, array('route' => array('survey.updatequota', $quota->id),
'method' => 'POST' ,'id'=>'createsurveyquota','class'=>'needs-validation')) }}


<div class="modal-body">
    <input type="hidden" name="survey_id" value="{{$survey->id}}"/>
    <div>
        {{ Form::label('quota_name', __('Quota Label'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
        {{ Form::text('quota_name', null, array('class' => 'form-control',
        'placeholder'=>__('Enter Quota Label'),'required'=>'required')) }}
    </div>
    <br>
    <div>
        {{ Form::label('quota_limit', __('Quota Limit'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
        {{ Form::number('quota_limit', null, array('class' => 'form-control',
        'placeholder'=>__('Enter Quota Limit'),'step' => 'any','required'=>'required')) }}
    </div>
    <br>
    <div class="surveyfoldername"> 
        <label class="control-label">Questions</label><span class="text-danger pl-1">*</span>
        <div class="form-group mb-0">
            <select class="select2 form-control qus_choice" id="qus_choice" name="question_id"  data-placeholder="Choose ..." required>
                <option value="">Choose Questions</option>
                @foreach($display_logic as $key=>$value)
                    
                    <option @if($quota->question_id == $key) selected @endif value="{{$key}}">{{$value}}</option>
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
                                <option @if($quota->question_id == $value->id.'_'.$key1) selected @endif  value="{{$value->id}}_{{$key1}}">{{$qus}} </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>
    <div class="optionsdropdown" style="display:none;"> 
    <br/>
        <label class="control-label">Condition</label><span class="text-danger pl-1">*</span>
        <div class="form-group mb-0" id="choiceslistans">
           
        </div>
    </div>
    <br/>
    <p class="control-label choicesdropdown1" style="display:none;margin-bottom:0.5rem;">Choices<span class="text-danger pl-1">*</span></p>
    <div class="choicesdropdown" style="display:none;margin-bottom:1rem;"> 
        <div class="form-group mb-0" id="choiceslist">
           
        </div>
    </div>
    <div class="surveyfoldername"> 
        <label class="control-label">Landing Page</label><span class="text-danger pl-1">*</span><br/>
        <span style="margin-bottom:0.5rem;">Responders are redirected here when quota is breached.</span>
        <div class="form-group mb-0">
            <select class="select2 form-control redirection_qus" id="redirection_qus" name="redirection_qus"  data-placeholder="Choose ..." required>
                <option value="">Choose Questions</option>
                @foreach($redirection as $key=>$value)
                    <option value="{{$key}}">{{$value}}</option>
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
$("html body").delegate('.qus_choice', "change", function() {    
    let val=$(this).val();
    let split_val=val.split('_');
    val=split_val[0];
    // let parentv=$(this).parent().parent().parent();
    let parentv = $('#choiceslist');
    parentv.siblings().remove()
    let url="{{route('survey.getqus')}}?qus_id="+val;
    $.ajax({url: url, success: function(result){
        var optionv=result?.resp_logic_type;
        let textDiv1='<select required class="form-control option_type" name="option_type"><option value="">Choose</option>';
        Object.entries(optionv).forEach(([key, value]) => {
            textDiv1+='<option value="'+key+'">'+value+'</option>';
        });
        textDiv1+='</select>';
        $('.optionsdropdown').css('display','block');
        $('#choiceslistans').html(textDiv1);
        let textDiv='';
        if(result?.qus_type=='single_choice' || result?.qus_type=='multi_choice' || result?.qus_type =='dropdown'){
            let choice_list=JSON.parse(result?.qus?.qus_ans);
            optionv=choice_list?.choices_list.split(',');
            textDiv+='<select required class="select2 form-control option_value select2-multiple" name="option_value[]" multiple="multiple">';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+value+'">'+value+'</option>';
            });
            textDiv+='</select>';
        }else if(result?.qus_type=='picturechoice'){
            let choice_list=JSON.parse(result?.qus?.qus_ans);
            optionv=JSON.parse(choice_list?.choices_list);
            textDiv+='<select required class="select2 form-control option_value select2-multiple" name="option_value[]" multiple="multiple">';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+key+'">'+value.text+'</option>';
            });
            textDiv+='</select>';
        }
        else if(result?.qus_type=='matrix_qus'){
            let choice_list=JSON.parse(result?.qus?.qus_ans);
            optionv=choice_list?.matrix_choice.split(',');
            textDiv+='<select required class="select2 form-control option_value select2-multiple" name="option_value[]" multiple="multiple">';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+value+'">'+value+'</option>';
            });
            textDiv+='</select>';
        }

        else if(result?.qus_type=='likert'){
            optionv={"1":1,"2":3,"3":3,"4":4,"5":5,"6":6,"7":7,"8":8,"9":9};
            textDiv+='<select required class="select2 form-control option_value select2-multiple" name="option_value[]" multiple="multiple">';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+key+'">'+value+'</option>';
            });
            textDiv+='</select>';
        }
        else if(result?.qus_type=='rankorder' || result?.qus_type=='photo_capture'){
            textDiv+='<input required style="display:none;" class="select2 form-control option_value select2-multiple" type="text" name="option_value"/>';
        }
        else if(result?.qus_type=='rating'){
            optionv={"1":1,"2":3,"3":3,"4":4,"5":5};
            textDiv+='<select required class="select2 form-control option_value select2-multiple" name="option_value[]" multiple="multiple">';
            Object.entries(optionv).forEach(([key, value]) => {
                textDiv+='<option value="'+key+'">'+value+'</option>';
            });
            textDiv+='</select>';
        }
        else if(result?.qus_type=='open_qus' || result?.qus_type=='email'){
            textDiv+='<input required  class="select2 form-control option_value select2-multiple" type="text" name="option_value"/>';
        }
        console.log('textDiv',textDiv)
        if(textDiv!=''){
            $('.choicesdropdown').css('display','block');
            $('.choicesdropdown1').css('display','block');
            $('#choiceslist').html(textDiv);
            $('.select2-multiple').select2();
        }
    }});
});

$("html body").delegate('.option_type', "change", function() {    
    let val=$(this).val();
    if(val=='isAnswered' || val=='isNotAnswered'){
        $('.choicesdropdown').css('display','none');
        $('.choicesdropdown1').css('display','none');

    }else{
        $('.choicesdropdown1').css('display','block');
        $('.choicesdropdown').css('display','block');
    }
});
    $('#createsurveyquota').validate({
        rules: {
            quota_name:{
                required: true,
            },
            quota_limit: {
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
div#choiceslist {
    display: flex;
    flex-direction: column-reverse;
}
</style>