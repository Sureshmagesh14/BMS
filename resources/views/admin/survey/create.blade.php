{{ Form::open(array('url' => route('folder.store'),'id'=>'createfolder','class'=>'needs-validation')) }}

<div class="modal-body">
    <div>
            {{ Form::label('folder_name', __('Folder Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
            {{ Form::text('folder_name', null, array('class' => 'form-control',
            'placeholder'=>__('Enter Folder Name'),'required'=>'required')) }}
    </div>
    <br>
    <div>
            {!! Form::label('folder_type', 'Folder Type') !!}<span class="text-danger pl-1">*</span>
            <br>
            <div class="options">{{ Form::radio('folder_type', 'public' , true,['class'=>'folder_type']) }}&nbsp&nbsp&nbsp{{ __('Public') }} &nbsp&nbsp&nbsp
            {{ Form::radio('folder_type', 'private' , false,['class'=>'folder_type']) }}&nbsp&nbsp&nbsp{{ __('Private') }}</div>
    </div>
    <br>
    <div class="privateusers"> 
    <label class="control-label">Select Users</label><span class="text-danger pl-1">*</span>
        <div class="form-group mb-0">
            <select class="select2 form-control select2-multiple" id="privateusers" name="privateusers[]" multiple="multiple" data-placeholder="Choose ...">
                @foreach($users as $key=>$value)
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
    
    $('#createfolder').validate({
        rules: {
            folder_name:{
                required: true,
            },
            folder_type: {
                required: true,
            },
            privateusers:{
                required:  $("input[name='folder_type']:checked").val()=='private'
            }
            
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