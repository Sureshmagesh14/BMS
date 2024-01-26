
<style>
input#create_client1 {
    display: none;
}
</style>
{{ Form::model($folder, array('route' => array('folder.edit', $folder->id),
'method' => 'PUT' ,'enctype'=>"multipart/form-data",'id'=>'create_folder')) }}
<div class="modal-body">
    <div class="row">
        <h5 class="sub-title"><strong>{{__('Basic Info')}}</strong></h5>

    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="button" id="create_client" value="{{__('Update')}}" class="btn  btn-primary">
    <input type="submit" id="create_client1" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

