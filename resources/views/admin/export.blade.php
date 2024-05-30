@include('admin.layout.header')
@include('admin.layout.horizontal_left_menu')
@include('admin.layout.horizontal_right_menu')
@include('admin.layout.vertical_side_menu')
<style>
    #demo {
        display: none;
    }

    .card {
        min-height: 231px !important;
    }
    .apexcharts-legend.apexcharts-align-center.position-right{
        top: 38px !important;
    }
</style>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <!-- starts -->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Export</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">BMS</a></li>
                                <li class="breadcrumb-item active">Export</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            
                <!-- start col-->
              

                <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"></h4>
                                       
                                        
                                        <form action="{{ url('admin/export_all') }}" method="post">
                                        @csrf

                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Choose Module</label>
                                                <div class="col-md-10">
                                                    <select name="module" id="module" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="Respondents info">Respondents Info</option>
                                                        <option value="Respondents">Respondents</option>
                                                        <option value="Projects">Projects</option>
                                                        <option value="Rewards">Rewards</option>
                                                        <option value="Cashout">Cashout</option>
                                                        <option value="Team Activity">Team Activity</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label">Date Range</label>
                                                <div class="col-md-10">
                                                    <div class="input-daterange input-group" data-provide="datepicker" data-date-format="dd-mm-yyyy" data-date-autoclose="true">
                                                    <input type="text" class="form-control" name="start" />
                                                    <input type="text" class="form-control" name="end" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row show_year">
                                                <label class="col-md-2 col-form-label">Select Year</label>
                                                <div class="col-md-10">
                                                <select id="year" name="year" class="w-full form-control form-select" >
                                                    <option value="" selected="selected" disabled="disabled">Please select</option>
                                                    {{ $last = date('Y') - 15 }}
                                                    {{ $now = date('Y') }}
                                                    @for ($i = $now; $i >= $last; $i--)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                </div>
                                            </div>

                                            <div class="form-group row show_month">
                                                <label class="col-md-2 col-form-label">Select Month</label>
                                                <div class="col-md-10">
                                                <select id="month" name="month" class="w-full form-control form-select" >
                                                    <option value="" selected="selected" disabled="disabled">Please select</option>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        @php
                                                            $lval = date('F', strtotime("$i/12/10"));
                                                        @endphp
                                                        <option value="{{ $i }}">{{ $lval }}</option>
                                                    @endfor
                                                </select>
                                                </div>
                                            </div>
                                            <div class="form-group row show_resp_type">
                                                <label class="col-md-2 col-form-label">Type</label>
                                                <div class="col-md-10">

                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" id="Basic and Essential Info" name="resp_type" class="custom-control-input" value="Basic and Essential Info">
                                                        <label class="custom-control-label" for="Basic and Essential Info">Basic and Essential Info</label>
                                                    </div>

                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" id="Extended Info" name="resp_type" class="custom-control-input" value="Extended Info">
                                                        <label class="custom-control-label" for="Extended Info">Extended Info</label>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group row show_resp">
                                                <label class="col-md-2 col-form-label">Status</label>
                                                <div class="col-md-10">

                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" id="Deactivated" name="resp_status" class="custom-control-input" value="Deactivated">
                                                        <label class="custom-control-label" for="Deactivated">Deactivated</label>
                                                    </div>

                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" id="Blacklisted" name="resp_status" class="custom-control-input" value="Blacklisted">
                                                        <label class="custom-control-label" for="Blacklisted">Blacklisted</label>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group row show_user">
                                                <label class="col-md-2 col-form-label">Select User</label>
                                                <div class="col-md-10">
                                                <select id="user" name="user" class="w-full form-control form-select" >
                                                    <option value="" selected="selected" disabled="disabled">Please select</option>
                                                    @foreach ($users_list as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }} {{ $user->surname }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Export</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
               
                <!-- end col-->
          
                

            <!-- End Page-content -->
            @include('admin.layout.footer')
            @yield('adminside-script')
            @stack('adminside-js')
<script>
$(document).ready(function(){
    $(".show_resp").hide();
    $(".show_resp_status").hide();
    $(".show_resp_type").hide();
    $(".show_user").hide();
    
    $(".show_year").hide();
    $(".show_month").hide();

    $("#module").val("");
    $("#year").val("");
    $("#month").val("");

    $('#module').on('change', function() {
      if ( this.value == 'Respondents')
      {
        $(".show_year").hide();
        $(".show_month").hide();
        $(".show_resp").show();
        $(".show_resp_status").hide();
        $(".show_resp_type").hide();
        $(".show_user").hide();
      }
      else if ( this.value == 'Respondents info')
      {
        $(".show_year").hide();
        $(".show_month").hide();
        $(".show_resp").hide();
        $(".show_resp_type").show();
        $(".show_resp_status").hide();
        $(".show_user").hide();
      }
      else if (( this.value == 'Cashout')||( this.value == 'Rewards'))
      {
        $(".show_year").hide();
        $(".show_month").hide();
        $(".show_resp").hide();
        $(".show_resp_status").hide();
        $(".show_resp_type").hide();
        $(".show_user").hide();
      }else if ( this.value == 'Team Activity')
      {
        $(".show_year").hide();
        $(".show_month").hide();
        $(".show_resp").hide();
        $(".show_resp_status").hide();
        $(".show_resp_type").hide();
        $(".show_user").show();
      }
      else
      {
        $(".show_user").hide();
        $(".show_year").hide();
        $(".show_month").hide();
        $(".show_resp").hide();
        $(".show_resp_status").hide();
        $(".show_resp_type").hide();
      }
    });
});
</script>