
<div class="modal-body">
   <div class="row">
    @foreach($questionTypes as $key=>$value)
        <div class="questiontype">
           <a href="{{route('survey.qustype',[$survey,$key])}}">{{$value}}</a>
        </div>
    @endforeach
    </div>
</div>

<style>
.questiontype {
    background-color: #f5f5f5;
    border-radius: 5px;
    border-bottom-color: transparent;
    width: 46%;
    padding: 10px;
    margin: 5px;
}
</style>
