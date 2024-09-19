<style>
    select {width: 100%;margin-bottom: 0px !important;}

    /*Style one*/
    @import url("https://fonts.googleapis.com/css?family=Work+Sans:200");
    *, *:after, *:before {
        box-sizing: border-box;
    }
    /*Style 3*/
    .switch {
        display: inline-block;
        height:28px;
        position: relative;
        width:50px;
    }
    .switch input {
        display: none;
    }
    .slider {
        background-color: #ccc;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }
    .slider:before {
        background-color: #fff;
        bottom: 4px;
        content: "";
        height:20px;
        left: 4px;
        position: absolute;
        transition: .4s;
        width:20px;
    }
    input:checked + .slider {
        background-color: #66bb6a;
    }
    input:checked + .slider:before {
        transform: translateX(22px);
    }
    .slider.round {
        border-radius: 34px;
    }
    .slider.round:before {
        border-radius: 50%;
    }

    .error {
        color: red;
    }
    .input-group-text {
        line-height: 2.3;
    }
</style>

<div class="container">
    <form action="{{route('cashout_sent')}}" method="POST" class="validation">
        @csrf
        <input type="hidden" name="reward" value="{{ $points }}">
        <div class="form-group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Cashout Methods</label>
            <div class="col-md-9">
                <select name="method" class="form-control" required onchange="method_change(this)">
                    <option value="">Select Method</option>
                    <option value="EFT">EFT Deposit</option>
                    <option value="Airtime">Airtime</option>
                    <option value="Data">Mobile Data</option>
                    <option value="Donations">Donations</option>
                </select>
            </div>
        </div>

        <div class="eft_method" style="display: none;">
            <div class="form-group row">
                <label for="example-text-input" class="col-md-3 col-form-label">Bank *</label>
                <div class="col-md-9">
                    <select name="bank_value" class="form-control" id="bank_name">
                        <option value="">Select Bank</option>
                        @foreach ($banks as $bank)
                            <option value="{{$bank->id}}">{{$bank->bank_name}} - {{$bank->branch_code}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        
            <div class="form-group row">
                <label for="example-text-input" class="col-md-3 col-form-label">Branch Code *</label>
                <div class="col-md-9">
                    <input type="text" name="branch" id="branch" class="form-control" readonly>
                    <input type="hidden" name="branch_name" id="branch_name" class="form-control">
                </div>
            </div>
        
            <div class="form-group row">
                <label for="example-search-input" class="col-md-3 col-form-label">Account Number *</label>
                <div class="col-md-9">
                    <input type="text" name="account_number" class="form-control">
                </div>
            </div>
        
            <div class="form-group row">
                <label for="example-search-input" class="col-md-3 col-form-label">Account Holder Name *</label>
                <div class="col-md-9">
                    <input type="text" name="holder_name" class="form-control">
                </div>
            </div>
        </div>

        <div class="airtime_mobile_data_method" style="display: none;">
            <div class="form-group row">
                <label for="example-text-input" class="col-md-3 col-form-label">Network Service Provider *</label>
                <div class="col-md-9">
                    <select name="network" class="form-control">
                        <option value="">Select Network Service Provider</option>
                        @foreach ($networks as $network)
                            <option value="{{$network->id}}">{{$network->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="example-search-input" class="col-md-3 col-form-label">Mobile Number *</label>
                <div class="col-md-9">
                    
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">+27</div>
                        </div>
                        @php
                            $string = $respondent->mobile;
                            if($string != null){
                                $remove = "27";
                                $result = preg_replace('/' . preg_quote($remove, '/') . '/', '', $string, 1); // Replace the first occurrence of "27" with an empty string
                            }
                            else{
                                $result = '';
                            }
                        @endphp

                        <input type="text" name="mobile_number" id="mobile" placeholder="81 966 9078" class="form-control vi-border-clr border-radius-0 w-50" maxlength="16" value="{{$result}}">
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="donations_method" style="display: none;">
            <div class="form-group row">
                <label for="example-text-input" class="col-md-3 col-form-label">Organisation *</label>
                <div class="col-md-9">
                    <select name="charitie" class="form-control">
                        <option value="">Select Organisation</option>
                        @foreach ($charities as $charitie)
                            <option value="{{$charitie->id}}">{{$charitie->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="style3" style="display: none;">
            <input type="text" name="accept_value" id="accept_value" value="0" style="display: none;">
            <label class="switch" for="checkbox">
                <input name="accept" type="checkbox" id="checkbox" class="accept accept_check" required/>
                <div class="slider round"></div>
            </label>
            <p>I have <b>checked my info</b> and agree to the 
                <a href="#" data-url="{{ route('terms_and_conditions') }}" data-value="{{ $points }}" data-size="xl" data-ajax-popup="true" data-bs-original-title="{{ __('Terms and Conditions') }}" data-bs-toggle="tooltip">terms & conditions</a> 
                specified.</p>
            <p class="accept_error" style="color: red;display: none">This Field Is Required</p>
        </div>
        
        <div class="modal-footer hide_footer" style="display: none;">
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="request_confirmation">Request Confirmation</button>
        </div>
    </form>
</div>

<script src="{{ asset('assets/js/inputmask.js') }}"></script>
<script>
    $('#mobile').inputmask("99 999 9999");

    $("#request_confirmation").click(function(){
        if($('.accept_check').prop('checked') == true){
            $("#accept_value").val("1");
            $(".accept_error").hide();
            $(".validation").submit();

        }else{
            $("#accept_value").val("0");
            $(".accept_error").show();
        }
    });

    $("#bank_name").change(function() {
        var bank_id = this.value;
        $.ajax({

            type: "GET",
            url: "{{ route('user_get_branch_code') }}",
            data: {
                "bank_id": bank_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $("#branch_name").val(data.repsonse);
                $("#branch").val(data.repsonse);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {

            }
        });
    });
   
    function method_change(get_this){
        val = $(get_this).val();
        if(val == "EFT"){
            $(".hide_footer").show();
            $(".eft_method").show();
            $(".style3").show();
            $(".airtime_mobile_data_method").hide();
            $(".donations_method").hide();
        }
        else if(val == "Airtime" || val == "Data"){
            $(".airtime_mobile_data_method").show();
            $(".hide_footer").show();
            $(".style3").show();
            $(".eft_method").hide();
            $(".donations_method").hide();
        }
        else if(val == "Donations"){
            $(".donations_method").show();
            $(".hide_footer").show();
            $(".style3").show();
            $(".eft_method").hide();
            $(".airtime_mobile_data_method").hide();
        }
        else{
            $(".hide_footer").hide();
            $(".eft_method").hide();
            $(".style3").hide();
            $(".airtime_mobile_data_method").hide();
            $(".donations_method").hide();
        }
    }
</script>