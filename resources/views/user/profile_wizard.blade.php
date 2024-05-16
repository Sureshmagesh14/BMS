@include('user.layout.header-2')
    <link rel="stylesheet" href="{{ asset('assets/wizard/css/jquery.steps.css') }}">
    <style>
        a {text-decoration: none;}
        .wizard>.steps{
            width: 20% !important;
        }
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
    </style>

    <section class="bg-greybg">
        <br>
        <main class="my-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section">
                            <div id="profile_wizard">
                                <h2>Basic Details</h2>
                                <section>
                                    <div class="row">
                                        <div class="col-6 col-sm-12">
                                            <label for="unique_id">PID</label>
                                            <input type="number" class="form-control" id="unique_id" disabled value="1">
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="Christopher">
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="Alexander">
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="mobile_number">Mobile Number</label>
                                            <input type="number" class="form-control" id="mobile_number" name="mobile_number" value="27836050638">
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="whatsapp_number">Whats App Number</label>
                                            <input type="number" class="form-control" id="whatsapp_number" name="whatsapp_number">
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="jessylee09@gmail.com">
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="date_of_birth">Age</label>
                                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                                            <span id="agecal"></span>
                                        </div>
                                    </div>
                                </section>
                
                                <h2>Essential Details</h2>
                                <section style="overflow-x: auto;">
                                    <div class="row">
                                        <div class="col-6 col-sm-4">
                                            <label for="dob">DOB</label>
                                            <input type="date" class="form-control" id="dob" name="dob">
                                        </div>
                                        <div class="col-6 col-sm-4">
                                            <label for="relationship_status">Relationship Status</label>
                                            <select name="relationship_status" id="relationship_status">
                                                <option value="">Select</option>
                                                <option value="single">Single</option>
                                                <option value="cohabitation">Cohabitation</option>
                                                <option value="engaged">Engaged</option>
                                                <option value="divorced">Divorced</option>
                                                <option value="married">Married</option>
                                                <option value="widowed">Widowed</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4">
                                            <label for="gender">Gender</label>
                                            <select name="gender" id="gender">
                                                <option value="">Select</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="non_binary">Non-Binary</option>
                                                <option value="perfer_not_to_say">Perfer not to say</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="ethnic_group">Ethnic Group / Race</label>
                                            <select name="ethnic_group" id="ethnic_group">
                                                <option value="">Select</option>
                                                <option value="asian">Asian</option>
                                                <option value="black">Black</option>
                                                <option value="coloured">Coloured</option>
                                                <option value="indian">Indian</option>
                                                <option value="white">White</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="education_level">Highest Education Level</label>
                                            <select name="education_level" id="education_level">
                                                <option value="">Select</option>
                                                <option value="matric">Matric</option>
                                                <option value="post_matric_courses">Post Matric Courses / Higher Certificate</option>
                                                <option value="post_matric_diploma">Post Matric Diploma</option>
                                                <option value="ug">Undergrad University Degree</option>
                                                <option value="pg">Post Grad Degree - Honours, Masters, PhD, MBA</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="employment_status">Employment Status</label>
                                            <select name="employment_status" id="employment_status">
                                                <option value="">Select</option>
                                                <option value="emp_full_time">Employed Full-Time</option>
                                                <option value="emp_part_time">Employed Part-Time</option>
                                                <option value="self">Self-Employed</option>
                                                <option value="study">Studying Full-Time (Not Working)</option>
                                                <option value="working_and_studying">Working & Studying</option>
                                                <option value="home_person">Stay at Home person</option>
                                                <option value="retired">Retired</option>
                                                <option value="unemployed">Unemployed</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="industry_my_company">Industry my company is in</label>
                                            <select name="industry_my_company" id="industry_my_company">
                                                <option value="">Select</option>
                                                <option value="agriculture_farming">Agriculture/ farming</option>
                                                <option value="agriculture_interior">Architecture / Interior Design / Decorator</option>
                                                <option value="automotive">Automotive / motor vehicles – repairs, sales</option>
                                                <option value="aviation">Aviation / Aerospace</option>
                                                <option value="beauty">Beauty – Cosmetics, Hair, Self-Care</option>
                                                <option value="banking">Banking</option>
                                                <option value="blockchain">Blockchain / Cryptocurrency</option>
                                                <option value="business">Business Services</option>
                                                <option value="chemicals">Chemicals</option>
                                                <option value="consultant">Consultant – services</option>
                                                <option value="construction">Construction and building</option>
                                                <option value="counselling">Counselling / Psychology Services</option>
                                                <option value="creative_industry">Creative Industry – Artist / Graphic Designer</option>
                                                <option value="education">Education</option>
                                                <option value="engioneering">Engineering</option>
                                                <option value="fashion">Fashion</option>
                                                <option value="financial">Financial services / Investments</option>
                                                <option value="food">Food and Beverage – restaurant, catering, etc.</option>
                                                <option value="forestry">Forestry, paper, and packaging</option>
                                                <option value="government">Government and public sector</option>
                                                <option value="healthcare">Healthcare</option>
                                                <option value="hospitality">Hospitality and leisure</option>
                                                <option value="insurance">Insurance – finance, medical, etc.</option>
                                                <option value="legal">Legal</option>
                                                <option value="manugacturing">Manufacturing</option>
                                                <option value="marketing">Marketing / Market Research / Advertising</option>
                                                <option value="media">Media / Entertainment / Publishing</option>
                                                <option value="mining">Mining</option>
                                                <option value="non_profit_org">Non-Profit Organisation / NGOs</option>
                                                <option value="pharmaceutical">Pharmaceutical</option>
                                                <option value="power">Power, Energy, and utilities – chemicals, oil and gas</option>
                                                <option value="real_estate">Real estate</option>
                                                <option value="renewable_energy">Renewable energy / Solar</option>
                                                <option value="retail">Retail - selling food, clothes, furniture, etc.</option>
                                                <option value="service_industry">Service Industry – Maintenance, Cleaning, etc.</option>
                                                <option value="technology_it">Technology / IT</option>
                                                <option value="telecommunications">Telecommunications</option>
                                                <option value="transportations">Transportation and logistics</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="job_title">Job Title</label>
                                            <input type="text" class="form-control" id="job_title" name="job_title">
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="personal_income_per_month">Personal Income Per Month</label>
                                            <select name="personal_income_per_month" id="personal_income_per_month">
                                                <option value="">Select</option>
                                                <option value="0_2000">R0 - R2 000</option>
                                                <option value="2000_3000">R2 000 - R3 000</option>
                                                <option value="3000_4000">R3 000 - R4 000</option>
                                                <option value="4000_5000">R4 000 - R5 000</option>
                                                <option value="5000_6000">R5 000 - R6 000</option>
                                                <option value="6000_10000">R6 000 - R10 000</option>
                                                <option value="10000_15000">R10 000 - R15 000</option>
                                                <option value="15000_20000">R15 000 - R20 000</option>
                                                <option value="20000_30000">R20 000 - R30 000</option>
                                                <option value="30000_40000">R30 000 - R40 000</option>
                                                <option value="40000_50000">R40 000 - R50 000</option>
                                                <option value="50000_60000">R50 000 - R60 000</option>
                                                <option value="60000_70000">R60 000 - R70 000</option>
                                                <option value="70000_80000">R70 000 - R80 000</option>
                                                <option value="80000_100000">R80 000 - R100 000</option>
                                                <option value="100000_120000">R100 000 - R120 000</option>
                                                <option value="120000">R120 000+</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="household_income_per_monty">Household Income per monthly</label>
                                            <select name="household_income_per_monty" id="household_income_per_monty">
                                                <option value="">Select</option>
                                                <option value="0_2000">R0 - R2 000</option>
                                                <option value="2000_3000">R2 000 - R3 000</option>
                                                <option value="3000_4000">R3 000 - R4 000</option>
                                                <option value="4000_5000">R4 000 - R5 000</option>
                                                <option value="5000_6000">R5 000 - R6 000</option>
                                                <option value="6000_10000">R6 000 - R10 000</option>
                                                <option value="10000_15000">R10 000 - R15 000</option>
                                                <option value="15000_20000">R15 000 - R20 000</option>
                                                <option value="20000_30000">R20 000 - R30 000</option>
                                                <option value="30000_40000">R30 000 - R40 000</option>
                                                <option value="40000_50000">R40 000 - R50 000</option>
                                                <option value="50000_60000">R50 000 - R60 000</option>
                                                <option value="60000_70000">R60 000 - R70 000</option>
                                                <option value="70000_80000">R70 000 - R80 000</option>
                                                <option value="80000_100000">R80 000 - R100 000</option>
                                                <option value="100000_120000">R100 000 - R120 000</option>
                                                <option value="120000">R120 000+</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="province">Province</label>
                                            <select name="province" id="province">
                                                <option value="">Select</option>
                                                <option value="eastern_cape">Eastern Cape</option>
                                                <option value="free_state">Free State</option>
                                                <option value="gauteng">Gauteng</option>
                                                <option value="kwazulu">KwaZulu-Natal</option>
                                                <option value="limpopo">Limpopo</option>
                                                <option value="mpumalanga">Mpumalanga</option>
                                                <option value="north_West_province">North-West Province</option>
                                                <option value="northern_cape">Northern Cape</option>
                                                <option value="western_cape">Western Cape</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="metropolitan_area">Metropolitan Area</label>
                                            <select name="metropolitan_area" id="metropolitan_area">
                                                <option value="">Select</option>
                                                @foreach ($state as $states)
                                                    <optgroup label="{{$states->state}}">
                                                        @foreach ($metropolitan_area as $area)
                                                            @if($states->id == $area->type)
                                                                @php $areas = json_decode($area->metropolitan); @endphp
                                                                <optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;{{$area->district}}">
                                                                    @foreach ($areas as $area)
                                                                        <option value="{{$area->area_id}}">&nbsp;&nbsp;&nbsp;&nbsp;{{$area->area}}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endif
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                                
                                            </select>
                                        </div>

                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="no_children">Number of Children</label>
                                            <input type="number" name="no_children" id="no_children" class="form-control">
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="no_vehicle">Number of Vehicles</label>
                                            <input type="number" name="no_vehicle" id="no_vehicle" class="form-control">
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
                                            <label for="org">Which best describes the role in you business / organization?</label>
                                            <select name="org" id="org">
                                                <option value="">Select</option>
                                                <option value="eastern_cape">Owner / director (CEO, COO, CFO)</option>
                                                <option value="free_state">Senior Manager</option>
                                                <option value="gauteng">Mid-Level Manager</option>
                                                <option value="kwazulu">Team leader / Supervisor</option>
                                                <option value="limpopo">General Worker (e.g., Admin, Call Centre Agent, Nurse, Teacher, Carer, etc.)</option>
                                                <option value="mpumalanga">Worker (e.g., Security Guard, Cleaner, Helper, etc.)</option>
                                                <option value="north_West_province">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="org_company">What is the number of people in your organisation / company?</label>
                                            <select name="org_company" id="org_company">
                                                <option value="">Select</option>
                                                <option value="just_me">Just Me (Sole Proprietor)</option>
                                                <option value="2_5">2-5 people</option>
                                                <option value="6_10">6-10 people</option>
                                                <option value="11_20">11-20 people</option>
                                                <option value="21_30">21-30 people</option>
                                                <option value="31-50">31-50 people</option>
                                                <option value="51_100">51-100 people</option>
                                                <option value="101_250">101-250 people</option>
                                                <option value="251_500">251-500 people</option>
                                                <option value="500_1000">500-1000 people</option>
                                                <option value="more_than_1000">More than 1000 people</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="bank_main">Which bank do you bank with (which is your bank main)</label>
                                            <select name="bank_main" id="bank_main">
                                                <option value="">Select</option>
                                                <option value="absa">ABSA</option>
                                                <option value="african_bank">African Bank</option>
                                                <option value="bidvest_bank">Bidvest Bank</option>
                                                <option value="capitec">Capitec</option>
                                                <option value="discovery">Discovery</option>
                                                <option value="fnb">FNB</option>
                                                <option value="rmb">RMB</option>
                                                <option value="investec">Investec</option>
                                                <option value="mercentile_bank">Mercentile Bank</option>
                                                <option value="netbank">Nedbank</option>
                                                <option value="sasfin_bank">Sasfin Bank</option>
                                                <option value="standard_bank">Standard Bank</option>
                                                <option value="tyme_bank">TymeBank</option>
                                                <option value="ubank">UBank</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="home_lang">Home Language</label>
                                            <select name="home_lang" id="home_lang">
                                                <option value="">Select</option>
                                                <option value="afrikaans">Afrikaans</option>
                                                <option value="english">English</option>
                                                <option value="ndebele">Ndebele</option>
                                                <option value="pedi">Pedi</option>
                                                <option value="sotho">Sotho</option>
                                                <option value="swati">Swati</option>
                                                <option value="tsonga">Tsonga</option>
                                                <option value="tswana">Tswana</option>
                                                <option value="venda">Venḓa</option>
                                                <option value="xhosa">Xhosa</option>
                                                <option value="zulu">Zulu</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>

@include('user.layout.footer')
    <script src="{{ asset('assets/wizard/js/jquery.steps.js') }}"></script>
    <script>
        $(function () {
            $("#profile_wizard").steps({
                headerTag: "h2",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                stepsOrientation: "vertical",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    
                    if(currentIndex == 0 && newIndex == 1 || currentIndex == 2 && newIndex == 1){
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

                    }
                    
                    return true;
                    
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
        });
        

        
    </script>
