@include('user.layout.header-2')
    <link rel="stylesheet" href="{{ asset('assets/wizard/css/jquery.steps.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        a {text-decoration: none;}
        /* .wizard>.steps{
            width: 20% !important;
        } */
        .wizard.vertical > .actions {
            margin: 11px 2.5%;
        }
        .wizard.vertical > .content {
            width: 75%;
        }
        select {
            width: 100%;
            margin-bottom: 0px !important;
        }

        .wizard > .content {
            background: #fff;
        }
        /* .wizard > .steps .current a, .wizard > .steps .current a:hover, .wizard > .steps .current a:active {
            background: #edbf1b;
        }
        .wizard > .steps .done a, .wizard > .steps .done a:hover, .wizard > .steps .done a:active {
            background: #ebddae;
            color: #fff;
        } */

        .select2-container .select2-selection--single {
            height: 49px;
            align-content: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 12px;
        }

        .wizard > .steps .done a, .wizard > .steps .done a:hover, .wizard > .steps .done a:active {
            background: #5cbf5b;
            color: #fff;
        }
        input.select2-search__field {
            height: 10% !important;
        }

        .input-group-text {
            line-height: 2.3;
        }
    </style>

    <section class="bg-greybg">
        <br>
        <main class="my-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section">
                            <form action="" name="profile_wizard_form" id="profile_wizard_form">
                                <div id="profile_wizard">
                                    <h2>Basic Details</h2>
                                    <section>
                                        <div class="row">
                                            <div class="col-6 col-sm-12">
                                                <label for="unique_id">PID</label>
                                                <input type="number" class="form-control unique_id" id="unique_id" disabled value="{{$pid}}">
                                                <input type="hidden" name="unique_id" class="form-control unique_id" id="get_unique_id" value="{{$pid}}">
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="first_name">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{$resp_details->name}}" required>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{$resp_details->surname}}" required>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="mobile_number">Mobile Number</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">+27</div>
                                                    </div>
                                                    <input type="text" name="mobile_number" id="mobile_number" placeholder="081 966 0786" class="form-control vi-border-clr border-radius-0"
                                                    value="{{$resp_details->mobile}}" oninput ="numonly(this);" maxlength="16" required>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="whatsapp_number">Whats App Number</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">+27</div>
                                                    </div>
                                                    <input type="text" name="whatsapp_number" id="whatsapp_number" placeholder="081 966 0786" class="form-control vi-border-clr border-radius-0"
                                                    value="{{$resp_details->whatsapp}}" oninput ="numonly(this);" maxlength="16" required>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{$resp_details->email}}" required>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="date_of_birth">Date of Birth</label>
                                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{$resp_details->date_of_birth}}" required>
                                                <span id="agecal"></span>
                                            </div>
                                        </div>
                                    </section>
                    
                                    <h2>Essential Details</h2>
                                    <section style="overflow-x: auto;">
                                        <div class="row">
                                            <div class="col-6 col-sm-4">
                                                <label for="relationship_status">Relationship Status</label>
                                                <select name="relationship_status" id="relationship_status" required>
                                                    <option value="">Select</option>
                                                    <option value="single" @isset($profile_data['relationship_status']) @if($profile_data['relationship_status'] == "single") selected @endif @endisset>Single</option>
                                                    <option value="cohabitation" @isset($profile_data['relationship_status']) @if($profile_data['relationship_status'] == "cohabitation") selected @endif @endisset>Cohabitation</option>
                                                    <option value="engaged" @isset($profile_data['relationship_status']) @if($profile_data['relationship_status'] == "engaged") selected @endif @endisset>Engaged</option>
                                                    <option value="divorced" @isset($profile_data['relationship_status']) @if($profile_data['relationship_status'] == "divorced") selected @endif @endisset>Divorced</option>
                                                    <option value="married" @isset($profile_data['relationship_status']) @if($profile_data['relationship_status'] == "married") selected @endif @endisset>Married</option>
                                                    <option value="widowed" @isset($profile_data['relationship_status']) @if($profile_data['relationship_status'] == "widowed") selected @endif @endisset>Widowed</option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4">
                                                <label for="gender">Gender</label>
                                                <select name="gender" id="gender" required>
                                                    <option value="">Select</option>
                                                    <option value="male" @isset($profile_data['gender']) @if($profile_data['gender'] == "male") selected @endif @endisset>Male</option>
                                                    <option value="female" @isset($profile_data['gender']) @if($profile_data['gender'] == "female") selected @endif @endisset>Female</option>
                                                    <option value="non_binary" @isset($profile_data['gender']) @if($profile_data['gender'] == "non_binary") selected @endif @endisset>Non-Binary</option>
                                                    <option value="perfer_not_to_say" @isset($profile_data['gender']) @if($profile_data['gender'] == "perfer_not_to_say") selected @endif @endisset>Perfer not to say</option>
                                                    <option value="other" @isset($profile_data['gender']) @if($profile_data['gender'] == "other") selected @endif @endisset>Other</option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4">
                                                <label for="ethnic_group">Ethnic Group / Race</label>
                                                <select name="ethnic_group" id="ethnic_group" required>
                                                    <option value="">Select</option>
                                                    <option value="asian" @isset($profile_data['ethnic_group']) @if($profile_data['ethnic_group'] == "asian") selected @endif @endisset>Asian</option>
                                                    <option value="black" @isset($profile_data['ethnic_group']) @if($profile_data['ethnic_group'] == "black") selected @endif @endisset>Black</option>
                                                    <option value="coloured" @isset($profile_data['ethnic_group']) @if($profile_data['ethnic_group'] == "coloured") selected @endif @endisset>Coloured</option>
                                                    <option value="indian" @isset($profile_data['ethnic_group']) @if($profile_data['ethnic_group'] == "indian") selected @endif @endisset>Indian</option>
                                                    <option value="white" @isset($profile_data['ethnic_group']) @if($profile_data['ethnic_group'] == "white") selected @endif @endisset>White</option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="education_level">Highest Education Level</label>
                                                <select name="education_level" id="education_level" required>
                                                    <option value="">Select</option>
                                                    <option value="matric" @isset($profile_data['education_level']) @if($profile_data['education_level'] == "matric") selected @endif @endisset>Matric</option>
                                                    <option value="post_matric_courses" @isset($profile_data['education_level']) @if($profile_data['education_level'] == "post_matric_courses") selected @endif @endisset>Post Matric Courses / Higher Certificate</option>
                                                    <option value="post_matric_diploma" @isset($profile_data['education_level']) @if($profile_data['education_level'] == "post_matric_diploma") selected @endif @endisset>Post Matric Diploma</option>
                                                    <option value="ug" @isset($profile_data['education_level']) @if($profile_data['education_level'] == "ug") selected @endif @endisset>Undergrad University Degree</option>
                                                    <option value="pg" @isset($profile_data['education_level']) @if($profile_data['education_level'] == "pg") selected @endif @endisset>Post Grad Degree - Honours, Masters, PhD, MBA</option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="employment_status">Employment Status</label>
                                                <select name="employment_status" id="employment_status" required>
                                                    <option value="">Select</option>
                                                    <option value="emp_full_time" @isset($profile_data['employment_status']) @if($profile_data['employment_status'] == "emp_full_time") selected @endif @endisset>Employed Full-Time</option>
                                                    <option value="emp_part_time" @isset($profile_data['employment_status']) @if($profile_data['employment_status'] == "emp_part_time") selected @endif @endisset>Employed Part-Time</option>
                                                    <option value="self" @isset($profile_data['employment_status']) @if($profile_data['employment_status'] == "self") selected @endif @endisset>Self-Employed</option>
                                                    <option value="study" @isset($profile_data['employment_status']) @if($profile_data['employment_status'] == "study") selected @endif @endisset>Studying Full-Time (Not Working)</option>
                                                    <option value="working_and_studying" @isset($profile_data['employment_status']) @if($profile_data['employment_status'] == "working_and_studying") selected @endif @endisset>Working & Studying</option>
                                                    <option value="home_person" @isset($profile_data['employment_status']) @if($profile_data['employment_status'] == "home_person") selected @endif @endisset>Stay at Home person</option>
                                                    <option value="retired" @isset($profile_data['employment_status']) @if($profile_data['employment_status'] == "retired") selected @endif @endisset>Retired</option>
                                                    <option value="unemployed" @isset($profile_data['employment_status']) @if($profile_data['employment_status'] == "unemployed") selected @endif @endisset>Unemployed</option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="industry_my_company">Industry my company is in</label>
                                                <select name="industry_my_company" id="industry_my_company" required>
                                                    <option value="">Select</option>
                                                    @foreach ($industry_company as $industry)
                                                        <option value="{{$industry->id}}" @isset($profile_data['industry_my_company']) @if($profile_data['industry_my_company'] == $industry->id) selected @endif @endisset>{{$industry->company}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="job_title">Job Title</label>
                                                <input type="text" class="form-control" id="job_title" name="job_title" required @isset($profile_data['job_title']) value ="{{$profile_data['job_title']}}" @endisset>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="personal_income_per_month">Personal Income Per Month</label>
                                                <select name="personal_income_per_month" id="personal_income_per_month" required>
                                                    <option value="">Select</option>
                                                    @foreach ($income_per_month as $income)
                                                        <option value="{{$income->id}}" @isset($profile_data['personal_income_per_month']) @if($profile_data['personal_income_per_month'] == $income->id) selected @endif @endisset>{{$income->income}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="household_income_per_month">Household Income per month</label>
                                                <select name="household_income_per_month" id="household_income_per_month" required>
                                                    <option value="">Select</option>
                                                    @foreach ($income_per_month as $income)
                                                        <option value="{{$income->id}}" @isset($profile_data['household_income_per_month']) @if($profile_data['household_income_per_month'] == $income->id) selected @endif @endisset>{{$income->income}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="province">Province</label>
                                                <select name="province" id="province" required>
                                                    <option value="">Select</option>
                                                    @foreach ($state as $states)
                                                        <option value="{{$states->id}}" @isset($profile_data['province']) @if($profile_data['province'] == $states->id) selected @endif @endisset>{{$states->state}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="suburb">Suburb</label>
                                                <select name="suburb" id="suburb" required>
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="metropolitan_area">Metropolitan Area</label>
                                                <select name="metropolitan_area" id="metropolitan_area" required>
                                                </select>
                                            </div>

                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="no_houehold">Number of people living in your household</label>
                                                <input type="number" name="no_houehold" id="no_houehold" class="form-control" required @isset($profile_data['no_houehold']) value ="{{$profile_data['no_houehold']}}" @endisset>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="no_children">Number of Children</label>
                                                <input type="number" name="no_children" id="no_children" class="form-control" required @isset($profile_data['no_children']) value ="{{$profile_data['no_children']}}" @endisset>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="no_vehicle">Number of Vehicles</label>
                                                <input type="number" name="no_vehicle" id="no_vehicle" class="form-control" required @isset($profile_data['no_vehicle']) value ="{{$profile_data['no_vehicle']}}" @endisset>
                                            </div>
                                        </div>
                                    </section>
                    
                                    <h2>Extended Details</h2>
                                    <section style="overflow-x: auto;">
                                        <div class="row">
                                            <div class="col-6 col-sm-5">
                                                <table border="1" id="children_table" class="children_table table table-bordered table-striped table-highlight">
                                                    <colgroup>
                                                        <col width="20%"/>
                                                        <col width="50%"/>
                                                        <col width="30%"/>
                                                    </colgroup>
                                                    <tr>
                                                        <th style="text-align: center;">Child</th>
                                                        <th style="text-align: center;">DOB</th>
                                                        <th style="text-align: center;">Gender</th>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-6 col-sm-7">
                                                <table border="1" id="vehicle_table" class="vehicle_table table table-bordered table-striped table-highlight">
                                                    <colgroup>
                                                        <col width="20%"/>
                                                        <col width="20%"/>
                                                        <col width="20%"/>
                                                        <col width="20%"/>
                                                        <col width="20%"/>
                                                    </colgroup>
                                                    <tr>
                                                        <th style="text-align: center;">Vehicle</th>
                                                        <th style="text-align: center;">Brand</th>
                                                        <th style="text-align: center;">Type of vehicle</th>
                                                        <th style="text-align: center;">Model</th>
                                                        <th style="text-align: center;">Year</th>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="business_org">Which best describes the role in you business / organization?</label>
                                                <select name="business_org" id="business_org">
                                                    <option value="">Select</option>
                                                    <option value="eastern_cape" @isset($profile_data['business_org']) @if($profile_data['business_org'] == "eastern_cape") selected @endif @endisset>Owner / director (CEO, COO, CFO)</option>
                                                    <option value="free_state" @isset($profile_data['business_org']) @if($profile_data['business_org'] == "free_state") selected @endif @endisset>Senior Manager</option>
                                                    <option value="gauteng" @isset($profile_data['business_org']) @if($profile_data['business_org'] == "gauteng") selected @endif @endisset>Mid-Level Manager</option>
                                                    <option value="kwazulu" @isset($profile_data['business_org']) @if($profile_data['business_org'] == "kwazulu") selected @endif @endisset>Team leader / Supervisor</option>
                                                    <option value="limpopo" @isset($profile_data['business_org']) @if($profile_data['business_org'] == "limpopo") selected @endif @endisset>General Worker (e.g., Admin, Call Centre Agent, Nurse, Teacher, Carer, etc.)</option>
                                                    <option value="mpumalanga" @isset($profile_data['business_org']) @if($profile_data['business_org'] == "mpumalanga") selected @endif @endisset>Worker (e.g., Security Guard, Cleaner, Helper, etc.)</option>
                                                    <option value="north_West_province" @isset($profile_data['business_org']) @if($profile_data['business_org'] == "north_West_province") selected @endif @endisset>Other</option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="org_company">What is the number of people in your organisation / company?</label>
                                                <select name="org_company" id="org_company">
                                                    <option value="">Select</option>
                                                    <option value="just_me" @isset($profile_data['org_company']) @if($profile_data['org_company'] == "just_me") selected @endif @endisset>Just Me (Sole Proprietor)</option>
                                                    <option value="2_5" @isset($profile_data['org_company']) @if($profile_data['org_company'] == "2_5") selected @endif @endisset>2-5 people</option>
                                                    <option value="6_10" @isset($profile_data['org_company']) @if($profile_data['org_company'] == "6_10") selected @endif @endisset>6-10 people</option>
                                                    <option value="11_20" @isset($profile_data['org_company']) @if($profile_data['org_company'] == "11_20") selected @endif @endisset>11-20 people</option>
                                                    <option value="21_30" @isset($profile_data['org_company']) @if($profile_data['org_company'] == "21_30") selected @endif @endisset>21-30 people</option>
                                                    <option value="31_50" @isset($profile_data['org_company']) @if($profile_data['org_company'] == "31_50") selected @endif @endisset>31-50 people</option>
                                                    <option value="51_100" @isset($profile_data['org_company']) @if($profile_data['org_company'] == "51_100") selected @endif @endisset>51-100 people</option>
                                                    <option value="101_250" @isset($profile_data['org_company']) @if($profile_data['org_company'] == "101_250") selected @endif @endisset>101-250 people</option>
                                                    <option value="251_500" @isset($profile_data['org_company']) @if($profile_data['org_company'] == "251_500") selected @endif @endisset>251-500 people</option>
                                                    <option value="500_1000" @isset($profile_data['org_company']) @if($profile_data['org_company'] == "500_1000") selected @endif @endisset>500-1000 people</option>
                                                    <option value="more_than_1000" @isset($profile_data['org_company']) @if($profile_data['org_company'] == "more_than_1000") selected @endif @endisset>More than 1000 people</option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="bank_main">Which bank do you bank with (which is your bank main)</label>
                                                <select name="bank_main" id="bank_main">
                                                    <option value="">Select</option>
                                                    @foreach ($banks as $bank)
                                                        <option value="{{$bank->id}}" @isset($profile_data['bank_main']) @if($profile_data['bank_main'] == $bank->id) selected @endif @endisset>{{$bank->bank_name}}</option>
                                                    @endforeach
                                                    <option value="other" @isset($profile_data['bank_main']) @if($profile_data['bank_main'] == "other") selected @endif @endisset>Other</option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-sm-4 mt-3">
                                                <label for="home_lang">Home Language</label>
                                                <select name="home_lang" id="home_lang">
                                                    <option value="">Select</option>
                                                    <option value="afrikaans" @isset($profile_data['home_lang']) @if($profile_data['home_lang'] == "afrikaans") selected @endif @endisset>Afrikaans</option>
                                                    <option value="english" @isset($profile_data['home_lang']) @if($profile_data['home_lang'] == "english") selected @endif @endisset>English</option>
                                                    <option value="ndebele" @isset($profile_data['home_lang']) @if($profile_data['home_lang'] == "ndebele") selected @endif @endisset>Ndebele</option>
                                                    <option value="pedi" @isset($profile_data['home_lang']) @if($profile_data['home_lang'] == "pedi") selected @endif @endisset>Pedi</option>
                                                    <option value="sotho" @isset($profile_data['home_lang']) @if($profile_data['home_lang'] == "sotho") selected @endif @endisset>Sotho</option>
                                                    <option value="swati" @isset($profile_data['home_lang']) @if($profile_data['home_lang'] == "swati") selected @endif @endisset>Swati</option>
                                                    <option value="tsonga" @isset($profile_data['home_lang']) @if($profile_data['home_lang'] == "tsonga") selected @endif @endisset>Tsonga</option>
                                                    <option value="tswana" @isset($profile_data['home_lang']) @if($profile_data['home_lang'] == "tswana") selected @endif @endisset>Tswana</option>
                                                    <option value="venda" @isset($profile_data['home_lang']) @if($profile_data['home_lang'] == "venda") selected @endif @endisset>Venḓa</option>
                                                    <option value="xhosa" @isset($profile_data['home_lang']) @if($profile_data['home_lang'] == "xhosa") selected @endif @endisset>Xhosa</option>
                                                    <option value="zulu" @isset($profile_data['home_lang']) @if($profile_data['home_lang'] == "zulu") selected @endif @endisset>Zulu</option>
                                                    <option value="other" @isset($profile_data['home_lang']) @if($profile_data['home_lang'] == "other") selected @endif @endisset>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>

@include('user.layout.footer')
    <script src="{{ asset('assets/wizard/js/jquery.steps.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/inputmask.js') }}"></script>
    <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <script>
        $(function () {
            var tempcsrf = '{!! csrf_token() !!}';
            var form = $("#profile_wizard_form");
            
            $("#profile_wizard").steps({
                headerTag: "h2",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                // stepsOrientation: "vertical",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    if(currentIndex == 0 && newIndex == 1 || currentIndex == 2 && newIndex == 1){

                        if(form.valid() == true){

                            get_unique_id   = $("#get_unique_id").val();
                            first_name      = $("#first_name").val();
                            last_name       = $("#last_name").val();
                            mobile_number   = $("#mobile_number").val();
                            whatsapp_number = $("#whatsapp_number").val();
                            email           = $("#email").val();
                            date_of_birth   = $("#date_of_birth").val();

                            datas1 = {_token: tempcsrf, serialize_data: form.serialize(), step: 1};

                            if(currentIndex == 0 && newIndex == 1){
                                wizard_save(datas1);
                            }
                        }

                        return form.valid();
                    }
                    else if(currentIndex == 1 && newIndex == 2){
                        // return form.valid();
                        datas2 = {_token: tempcsrf, serialize_data: form.serialize(), step: 2};
                        wizard_save(datas2);
                    }
                    else{
                        relationship_status = $("#relationship_status").val();
                        console.log("relationship_status",relationship_status);
                    }
                    return true;
                },
                labels: {
                    finish: 'Finish <i class="fa fa-chevron-right"></i>',
                    next: 'Next <i class="fa fa-chevron-right"></i>',
                    previous: '<i class="fa fa-chevron-left"></i> Previous'
                },
                onFinishing: function (event, currentIndex)
                {
                    console.log("Finishing");
                    return true;
                },
                onFinished: function (event, currentIndex)
                {
                    $.confirm({
                        title: "Confirmation!",
                        content: "Are You Sure To Complete Your Profile?",
                        autoClose: 'cancel|8000',
                        type: 'blue',
                        icon: 'fa fa-check',
                        typeAnimated: true,
                        draggable: false,
                        animationBounce: 2,
                        buttons: {
                            confirm: {
                                text: "Confirm",
                                btnClass: 'btn-red',
                                action: function() {
                                    datas2 = {_token: tempcsrf, serialize_data: form.serialize(), step: 3};
                                    wizard_save(datas2);
                                    location.reload();
                                }
                            },
                            cancel: function() {

                            }
                        }
                    });
                    return true;
                }
            });

            function numonly(input) {
                let value = input.value;
                let numbers = value.replace(/[^0-9]/g, "");
                input.value = numbers;
            }
            $('#mobile_number').inputmask("999 999-9999");
            $('#whatsapp_number').inputmask("999 999-9999");

            $('#relationship_status, #gender, #ethnic_group, #education_level, #employment_status, #industry_my_company, #personal_income_per_month,'+
                '#household_income_per_monty, #province, #suburb, #metropolitan_area, #org, #org_company, #bank_main, #home_lang').select2({ height: '10%', width: '100%' });

            $("#no_children").keyup(function(){
                no_children = $(this).val();
                scroll_div  = $("#children_table");
                append_html = "";
                $("#children_table .more_tr").html("");
                if(no_children != 0){
                    for(child = 1; child <= no_children; child++){
                        append_html += '<tr class="more_tr role_tr" id="children_tr'+child+'">'+
                            '<td>'+
                                '<lable>Child '+child+'</lable>'+
                            '</td>'+
                            '<td>'+
                                '<input type="date" class="form-control children_child_'+child+'" name="children[dob_'+child+'][]">'+
                            '</td>'+
                            '<td>'+
                                '<select class="form-control" name="children[gender_'+child+'][]">'+
                                    '<option value="">Select</option>'+
                                    '<option value="male">Male</option>'+
                                    '<option value="female">Female</option>'+
                                '</select>'+
                            '</td>'+
                        '</tr>';
                    }
                    scroll_div.append(append_html);
                }
            });

            $("#no_vehicle").keyup(function(){
                no_vehicle = $(this).val();
                scroll_div_vehicle  = $("#vehicle_table");
                vehicle_html = "";
                $("#vehicle_table .more_tr").html("");
                if(no_vehicle != 0){
                    for(vehicles = 1; vehicles <= no_vehicle; vehicles++){
                        vehicle_html += '<tr class="more_tr role_tr" id="vehicle_tr'+vehicles+'">'+
                            '<td>'+
                                '<lable>Vehicle '+vehicles+'</lable>'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control brand_'+vehicles+'" name="vehicle[brand_'+vehicles+'][]">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control type_'+vehicles+'" name="vehicle[type_'+vehicles+'][]">'+
                            '</td>'+
                            '<td>'+
                                '<input type="text" class="form-control model_'+vehicles+'" name="vehicle[model_'+vehicles+'][]">'+
                            '</td>'+
                            '<td>'+
                                '<input type="number" class="form-control year_'+vehicles+'" name="vehicle[year_'+vehicles+'][]">'+
                            '</td>'+
                        '</tr>';
                    }
                    scroll_div_vehicle.append(vehicle_html);
                }
            });

            $("#date_of_birth").change(function() {
                var date_of_birth = $(this).val();
                var birthDay = $(this).val();
                var DOB = new Date(birthDay);
                var today = new Date();
                var age = today.getTime() - DOB.getTime();
                var elapsed = new Date(age);
                var year = elapsed.getYear() - 70;
                var month = elapsed.getMonth();
                var day = elapsed.getDay();
                var ageTotal = year + " Years," + month + " Months," + day + " Days";
                console.log("ageTotal",ageTotal);
                document.getElementById('agecal').innerText = ageTotal;
            });

            $("#province").change(function() {
                province = $(this).val();
                $.ajax({
                    url : '{{route("get_suburb")}}',
                    type : 'GET',
                    data : {
                        'province' : province
                    },
                    dataType:'json',
                    success : function(data) { 
                        if(data.type == true)             {
                            $("#suburb").html(data.data);
                        }
                    },
                    error : function(request,error)
                    {
                        // alert("Request: "+JSON.stringify(request));
                    }
                });
            });

            $("#suburb").change(function() {
                suburb = $(this).val();
                $.ajax({
                    url : '{{route("get_area")}}',
                    type : 'GET',
                    data : {
                        'suburb' : suburb
                    },
                    dataType:'json',
                    success : function(data) { 
                        if(data.type == true)             {
                            $("#metropolitan_area").html(data.data);
                        }
                    },
                    error : function(request,error)
                    {
                        // alert("Request: "+JSON.stringify(request));
                    }
                });
            });
        });

        function wizard_save(datas){
            $.ajax({
                url: "{{ route('profile_save') }}",
                data: datas,
                dataType: "json",
                success: function(response) {
                    if (response.success == true && response.status == 200) {
                        toastr.success(response.message);
                    }
                }
            });
        }
        
        $(document).ready(function() {
            $('#nav_profile').addClass('active');
        });
    </script>
