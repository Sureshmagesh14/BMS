<?php $idname="";
 if($type=='welcome') {
    $idname="createwelcomesurvey";
}else {
    $idname="createthankyousurvey"; 
} ?> 
{{ Form::open(array('url' => route('survey.storetemplate'),'id'=>"$idname",'class'=>'needs-validation','enctype'=>"multipart/form-data")) }}
<style>
    
.upload-image-placeholder {
    border-radius: 5px;
    position: relative;
    display: inline-block;
    vertical-align: top;
    min-width: 170px;
    min-height: 155px;
}

.upload-image-placeholder__upload-btn {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-direction: normal;
    -webkit-box-orient: vertical;
    -webkit-flex-direction: column;
    -moz-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    -moz-justify-content: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    -moz-align-items: center;
    align-items: center;
    -webkit-align-content: center;
    -moz-align-content: center;
    -ms-flex-line-pack: center;
    align-content: center;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: #f5f5f5;
    border: 1px dashed rgba(98, 104, 111, 0.5);
    transition: all 0.3s;
    text-align: center;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
}

.upload-image-placeholder__upload-btn:hover {
    background-color: #fff;
}

.upload-image-placeholder__upload-btn svg {
    margin-bottom: 22px;
}

.upload-image-placeholder__upload-btn p {
    font-size: 11px;
    line-height: 1.2;
    margin: 0;
    color: rgba(98, 104, 111, 0.5);
}
.modal-dialog-scrollable .modal-body {
    scrollbar-width: none;
}
</style>
<div class="modal-body">
    <input type="hidden" name="template_type" value="{{$type}}"/>
    <div>
        {{ Form::label('template_name', __('Template Name'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
        {{ Form::text('template_name', null, array('class' => 'form-control','placeholder'=>__('Enter Template Name'),'required'=>'required')) }}
    </div>
    <br>
    <div>
        {{ Form::label('title', __('Title'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
        {{ Form::text('title', null, array('class' => 'form-control','placeholder'=>__('Enter Title'),'required'=>'required')) }}
    </div>
    <br>
    <div>
        {{ Form::label('sub_title', __('Sub title'),['class'=>'form-label']) }}
        {{ Form::text('sub_title', null, array('class' => 'form-control','placeholder'=>__('Enter Sub title'))) }}
    </div>
    <br>
    @if($type == 'welcome')
    <div>
        {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
        {{ Form::text('description', null, array('class' => 'form-control','placeholder'=>__('Enter description'))) }}
    </div>
    <br>
    <div>
        {{ Form::label('button_label', __('Button Label'),['class'=>'form-label']) }}<span style='color:red;'>*</span>
        {{ Form::text('button_label', null, array('class' => 'form-control','placeholder'=>__('Enter button label'),'required'=>'required')) }}
    </div>
    <br>
    @endif

    <div>
    <div class="exitingImg" style="display:none;">
        <image src="" alt="image" width="100" height="100" id="existing_image">
        <a id="ss_draft_remove_image" class="ss_draft_remove_image pointer--cursor"><svg xmlns="http://www.w3.org/2000/svg" class="" width="30" height="30" viewBox="0 0 21 25" fill="none"><path d="M13.209 20.2187H7.30662C6.83423 20.2187 6.37926 20.0404 6.03265 19.7195C5.68605 19.3985 5.47338 18.9586 5.43715 18.4876L4.63281 8.03125H15.8828L15.0785 18.4876C15.0422 18.9586 14.8296 19.3985 14.483 19.7195C14.1364 20.0404 13.6814 20.2187 13.209 20.2187V20.2187Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M16.9271 8.03125H3.59375" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.91406 5.21875H12.6016C12.8502 5.21875 13.0887 5.31752 13.2645 5.49334C13.4403 5.66915 13.5391 5.90761 13.5391 6.15625V8.03125H6.97656V6.15625C6.97656 5.90761 7.07533 5.66915 7.25115 5.49334C7.42697 5.31752 7.66542 5.21875 7.91406 5.21875V5.21875Z" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.8984 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.61719 11.7812V16.4687" stroke="#616161" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a>
    </div>
        <div id="imgPreview"></div>
        <div class="upload-image-placeholder" id="trigger_image">
            <div class="upload-image-placeholder__upload-btn">
                <svg width="40" height="40" viewBox="0 0 36 27">
                    <path fill="#D7D7D7" d="M7.5 8.25a2.25 2.25 0 114.502.002A2.25 2.25 0 017.5 8.25zM21 9l-3.779 6-3.721-2.94-6 8.94h21L21 9zm12-6v21H3V3h30zm3-3H0v27h36V0z"></path>
                </svg>
                <p>Click here to upload a welcome image</p>
            </div>
        </div>
    </div>
    <input style="display:none;" type="file" id="image" name="image"  class="course form-control">

</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light"  data-dismiss="modal">
    <input type="submit" id="create_folder" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

<script>
$('#trigger_image').click(function(){
    $('#image').click();
});

$('#image').change(function(){
    getImgDataweclome();
})
function getImgDataweclome() {
    const chooseFile = document.getElementById("image");
    const imgPreview = document.getElementById("imgPreview");
    const files = chooseFile.files[0];
  if (files) {
    const fileReader = new FileReader();
    fileReader.readAsDataURL(files);
    fileReader.addEventListener("load", function () {
      $('.exitingImg').css('display','flex');
      $('#existing_image').attr('src',this.result);
      $('#existing_image').css('display',"block");
      $('#trigger_image').css('display','none');
      $('#ss_draft_remove_image').css('display','block');

    });    
  }
}
$('#ss_draft_remove_image').click(function(){
    $('#imgPreview').css('display','none');
    $('#existing_image').css('display','none');
    $('#trigger_image').css('display','inline-block');
    $('#ss_draft_remove_image').css('display','none');
});
    $('#createwelcomesurvey').validate({
        rules: {
            template_name:{
                required: true,
            },
            title:{
                required: true,
            },
            button_label:{
                required: true,
            },
            image: {
                required: true,
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    $('#createthankyousurvey').validate({
        rules: {
            template_name:{
                required: true,
            },
            title:{
                required: true,
            },
            image: {
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