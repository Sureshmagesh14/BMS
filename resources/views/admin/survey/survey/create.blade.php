{{ Form::open(array('url' => route('survey.store'),'id'=>'createsurvey','class'=>'needs-validation')) }}

<div class="modal-body">
    <div>
            {{ Form::label('title', __('Survey Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::text('title', null, array('class' => 'form-control',
            'placeholder'=>__('Enter Survey Name'),'required'=>'required')) }}
    </div>
    <br>
   
    <div class="surveyfoldername"> 
        <label class="control-label">Select Folder</label><span class="text-danger pl-1">*</span>
        <div class="form-group mb-0">
            <select class="select2 form-control" id="surveyfoldername" name="folder_id"  data-placeholder="Choose ...">
                <option value="">Choose Folder</option>
                @foreach($folders as $key=>$value)
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