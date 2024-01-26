
<style>
input#create_client1 {
    display: none;
}
</style>
{{ Form::model(array('route' => array('folder.store'),
'method' => 'PUT' ,'enctype'=>"multipart/form-data",'id'=>'create_folder')) }}
<div class="modal-body">
    <div class="row">
       

    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light"  data-dismiss="modal">
    <input type="button" id="create_client" value="{{__('Update')}}" class="btn  btn-primary">
    <input type="submit" id="create_client1" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}

