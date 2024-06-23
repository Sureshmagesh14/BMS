@include('user.layout.header-2')
<link rel="stylesheet" href="{{ asset('assets/wizard/css/jquery.steps.css') }}">
<link rel="stylesheet" href="{{ asset('assets/select2/select2.min.css') }}">
<style>
    a {
        text-decoration: none;
    }

    /* .wizard>.steps{
            width: 20% !important;
        } */
    .wizard.vertical>.actions {
        margin: 11px 2.5%;
    }

    .wizard.vertical>.content {
        width: 75%;
    }

    span.select2-selection.select2-selection--single.error {
        border: 1px solid #fbc2c4;
        background: rgb(251, 227, 228);
    }

    span.error {
        outline: none;
        background: rgb(251, 227, 228);
        border: 1px solid #fbc2c4;
        color: #fbc2c4;

    }


    select {
        width: 100%;
        margin-bottom: 0px !important;
    }

    .wizard>.content {
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

    .wizard>.steps .done a,
    .wizard>.steps .done a:hover,
    .wizard>.steps .done a:active {
        background: #5cbf5b;
        color: #fff;
    }

    input.select2-search__field {
        height: 10% !important;
    }

    .input-group-text {
        line-height: 2.3;
    }

    label#whatsapp_number-error {
        width: 100%;
    }

    label#mobile_number-error {
        width: 100%;
    }

    .star_require {
        color: red;
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
                                            <input type="number" class="form-control unique_id" id="unique_id" disabled
                                                value="{{ $pid }}">
                                            <input type="hidden" name="unique_id" class="form-control unique_id"
                                                id="get_unique_id" value="{{ $pid }}">
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="first_name">First Name <span
                                                    class="star_require">*</span></label><br>
                                            <input type="text" value="{{ $resp_details->name }}" disabled
                                                class="form-control">

                                            <input type="hidden" class="form-control" id="first_name"
                                                name="basic[first_name]" value="{{ $resp_details->name }}" required>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="last_name">Last Name <span class="star_require">*</span></label>
                                            <input type="text" class="form-control" id="last_name"
                                                name="basic[last_name]" value="{{ $resp_details->surname }}" required>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="mobile_number">Mobile Number <span
                                                    class="star_require">*</span></label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">+27</div>
                                                </div>
                                                <input type="text" name="basic[mobile_number]" id="mobile_number"
                                                    placeholder="081 966 0786"
                                                    class="form-control vi-border-clr border-radius-0"
                                                    value="{{ $resp_details->mobile }}" maxlength="16" required>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="whatsapp_number">Whats App Number <span
                                                    class="star_require">*</span></label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">+27</div>
                                                </div>
                                                <input type="text" name="basic[whatsapp_number]" id="whatsapp_number"
                                                    placeholder="081 966 0786"
                                                    class="form-control vi-border-clr border-radius-0"
                                                    value="{{ $resp_details->whatsapp }}" maxlength="16" required>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="email">Email <span class="star_require">*</span></label>
                                            <input type="email" class="form-control" id="email"
                                                name="basic[email]" value="{{ $resp_details->email }}" required>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="date_of_birth">Date of Birth <span
                                                    class="star_require">*</span></label><br>
                                            <input type="text" value="{{ $resp_details->date_of_birth }}" disabled
                                                class="form-control">
                                            <input type="hidden" placeholder="YYYY-MM-DD" class="form-control"
                                                id="date_of_birth" name="basic[date_of_birth]"
                                                value="{{ $resp_details->date_of_birth }}" required>

                                            @if ($resp_details->date_of_birth != null)
                                                <code>
                                                    @php
                                                        $bday = new \DateTime($resp_details->date_of_birth);
                                                        $today = new \DateTime(date('m.d.y'));
                                                        $diff = $today->diff($bday);
                                                        $age = $diff->y . ' Years';
                                                    @endphp
                                                </code>
                                                <small id="agecal" class="text-danger">{{ $age }}</small>
                                            @else
                                                <span id="agecal"></span>
                                            @endif

                                        </div>
                                    </div>
                                </section>

                                <h2>Essential Details</h2>
                                <section style="overflow-x: auto;">
                                    <div class="row">
                                        <div class="col-6 col-sm-4">
                                            <label for="relationship_status">Relationship Status <span
                                                    class="star_require">*</span></label>
                                            <select name="essential[relationship_status]" id="relationship_status"
                                                required>
                                                <option value="">Select</option>
                                                <option value="single"
                                                    @isset($essential_details['relationship_status']) @if ($essential_details['relationship_status'] == 'single') selected @endif @endisset>
                                                    Single</option>
                                                <option value="cohabitation"
                                                    @isset($essential_details['relationship_status']) @if ($essential_details['relationship_status'] == 'cohabitation') selected @endif @endisset>
                                                    Cohabitation</option>
                                                <option value="engaged"
                                                    @isset($essential_details['relationship_status']) @if ($essential_details['relationship_status'] == 'engaged') selected @endif @endisset>
                                                    Engaged</option>
                                                <option value="divorced"
                                                    @isset($essential_details['relationship_status']) @if ($essential_details['relationship_status'] == 'divorced') selected @endif @endisset>
                                                    Divorced</option>
                                                <option value="married"
                                                    @isset($essential_details['relationship_status']) @if ($essential_details['relationship_status'] == 'married') selected @endif @endisset>
                                                    Married</option>
                                                <option value="widowed"
                                                    @isset($essential_details['relationship_status']) @if ($essential_details['relationship_status'] == 'widowed') selected @endif @endisset>
                                                    Widowed</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4">
                                            <label for="gender">Gender <span class="star_require">*</span></label>
                                            <select name="essential[gender]" id="gender" required>
                                                <option value="">Select</option>
                                                <option value="male"
                                                    @isset($essential_details['gender']) @if ($essential_details['gender'] == 'male') selected @endif @endisset>
                                                    Male</option>
                                                <option value="female"
                                                    @isset($essential_details['gender']) @if ($essential_details['gender'] == 'female') selected @endif @endisset>
                                                    Female</option>
                                                <option value="non_binary"
                                                    @isset($essential_details['gender']) @if ($essential_details['gender'] == 'non_binary') selected @endif @endisset>
                                                    Non-Binary</option>
                                                <option value="perfer_not_to_say"
                                                    @isset($essential_details['gender']) @if ($essential_details['gender'] == 'perfer_not_to_say') selected @endif @endisset>
                                                    Perfer not to say</option>
                                                <option value="other"
                                                    @isset($essential_details['gender']) @if ($essential_details['gender'] == 'other') selected @endif @endisset>
                                                    Other</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4">
                                            <label for="ethnic_group">Ethnic Group / Race <span
                                                    class="star_require">*</span></label>
                                            <select name="essential[ethnic_group]" id="ethnic_group" required>
                                                <option value="">Select</option>
                                                <option value="asian"
                                                    @isset($essential_details['ethnic_group']) @if ($essential_details['ethnic_group'] == 'asian') selected @endif @endisset>
                                                    Asian</option>
                                                <option value="black"
                                                    @isset($essential_details['ethnic_group']) @if ($essential_details['ethnic_group'] == 'black') selected @endif @endisset>
                                                    Black</option>
                                                <option value="coloured"
                                                    @isset($essential_details['ethnic_group']) @if ($essential_details['ethnic_group'] == 'coloured') selected @endif @endisset>
                                                    Coloured</option>
                                                <option value="indian"
                                                    @isset($essential_details['ethnic_group']) @if ($essential_details['ethnic_group'] == 'indian') selected @endif @endisset>
                                                    Indian</option>
                                                <option value="white"
                                                    @isset($essential_details['ethnic_group']) @if ($essential_details['ethnic_group'] == 'white') selected @endif @endisset>
                                                    White</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="education_level">Highest Education Level <span
                                                    class="star_require">*</span></label>
                                            <select name="essential[education_level]" id="education_level" required>
                                                <option value="">Select</option>
                                                <option value="matric"
                                                    @isset($essential_details['education_level']) @if ($essential_details['education_level'] == 'matric') selected @endif @endisset>
                                                    Matric</option>
                                                <option value="post_matric_courses"
                                                    @isset($essential_details['education_level']) @if ($essential_details['education_level'] == 'post_matric_courses') selected @endif @endisset>
                                                    Post Matric Courses / Higher Certificate</option>
                                                <option value="post_matric_diploma"
                                                    @isset($essential_details['education_level']) @if ($essential_details['education_level'] == 'post_matric_diploma') selected @endif @endisset>
                                                    Post Matric Diploma</option>
                                                <option value="ug"
                                                    @isset($essential_details['education_level']) @if ($essential_details['education_level'] == 'ug') selected @endif @endisset>
                                                    Undergrad University Degree</option>
                                                <option value="pg"
                                                    @isset($essential_details['education_level']) @if ($essential_details['education_level'] == 'pg') selected @endif @endisset>
                                                    Post Grad Degree - Honours, Masters, PhD, MBA</option>
                                                <option value="school_no_metric"
                                                    @isset($essential_details['education_level']) @if ($essential_details['education_level'] == 'school_no_metric') selected @endif @endisset>
                                                    School But No Matric</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="employment_status">Employment Status <span
                                                    class="star_require">*</span></label>
                                            <select name="essential[employment_status]" id="employment_status" required onchange="show_other(this, 'employment_status')">
                                                <option value="">Select</option>
                                                <option value="emp_full_time"
                                                    @isset($essential_details['employment_status']) @if ($essential_details['employment_status'] == 'emp_full_time') selected @endif @endisset>
                                                    Employed Full-Time</option>
                                                <option value="emp_part_time"
                                                    @isset($essential_details['employment_status']) @if ($essential_details['employment_status'] == 'emp_part_time') selected @endif @endisset>
                                                    Employed Part-Time</option>
                                                <option value="self"
                                                    @isset($essential_details['employment_status']) @if ($essential_details['employment_status'] == 'self') selected @endif @endisset>
                                                    Self-Employed</option>
                                                <option value="study"
                                                    @isset($essential_details['employment_status']) @if ($essential_details['employment_status'] == 'study') selected @endif @endisset>
                                                    Studying Full-Time (Not Working)</option>
                                                <option value="working_and_studying"
                                                    @isset($essential_details['employment_status']) @if ($essential_details['employment_status'] == 'working_and_studying') selected @endif @endisset>
                                                    Working & Studying</option>
                                                <option value="home_person"
                                                    @isset($essential_details['employment_status']) @if ($essential_details['employment_status'] == 'home_person') selected @endif @endisset>
                                                    Stay at Home person</option>
                                                <option value="retired"
                                                    @isset($essential_details['employment_status']) @if ($essential_details['employment_status'] == 'retired') selected @endif @endisset>
                                                    Retired</option>
                                                <option value="unemployed"
                                                    @isset($essential_details['employment_status']) @if ($essential_details['employment_status'] == 'unemployed') selected @endif @endisset>
                                                    Unemployed</option>
                                                <option value="other"
                                                    @isset($essential_details['employment_status']) @if ($essential_details['employment_status'] == 'other') selected @endif @endisset>
                                                    Other</option>
                                            </select>
                                            <input type="text" name="essential[employment_status_other]" id="employment_status_other" class="form-control"
                                                @isset($essential_details['employment_status']) 
                                                    @if($essential_details['employment_status'] == "other") style="margin-top: 10px;" @else style="display:none;margin-top: 10px;" @endif
                                                @else
                                                    style="display:none;margin-top: 10px;"
                                                @endisset
                                                placeholder="Please specify" @isset($essential_details['employment_status_other']) value="{{$essential_details['employment_status_other']}}" @endisset>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="industry_my_company">Industry my company is in <span class="star_require">*</span></label>
                                            <select name="essential[industry_my_company]" id="industry_my_company" required onchange="show_other(this, 'industry_my_company')">
                                                <option value="">Select</option>
                                                @foreach ($industry_company as $industry)
                                                    <option value="{{ $industry->id }}"
                                                        @isset($essential_details['industry_my_company']) @if ($essential_details['industry_my_company'] == $industry->id) selected @endif @endisset>
                                                        {{ $industry->company }}</option>
                                                @endforeach
                                                <option value="other"
                                                    @isset($essential_details['industry_my_company'])
                                                        @if ($essential_details['industry_my_company'] == "other") selected @endif
                                                    @endisset>Other
                                                </option>
                                            </select>

                                            <input type="text" name="essential[industry_my_company_other]" id="industry_my_company_other" class="form-control" 
                                                @isset($essential_details['industry_my_company'])
                                                    @if($essential_details['industry_my_company'] == "other") style="margin-top: 10px;" @else style="display:none;margin-top: 10px;" @endif
                                                @else
                                                    style="display:none;margin-top: 10px;"
                                                @endisset
                                                placeholder="Please specify" @isset($essential_details['industry_my_company_other']) value="{{$essential_details['industry_my_company_other']}}" @endisset>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="job_title">Job Title <span
                                                    class="star_require">*</span></label>
                                            <input type="text" class="form-control" id="job_title"
                                                name="essential[job_title]" required
                                                @isset($essential_details['job_title']) value ="{{ $essential_details['job_title'] }}" @endisset>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="personal_income_per_month">Personal Income Per Month <span
                                                    class="star_require">*</span></label>
                                            <select name="essential[personal_income_per_month]"
                                                id="personal_income_per_month" required>
                                                <option value="">Select</option>
                                                @foreach ($income_per_month as $income)
                                                    <option value="{{ $income->id }}"
                                                        @isset($essential_details['personal_income_per_month']) @if ($essential_details['personal_income_per_month'] == $income->id) selected @endif @endisset>
                                                        {{ $income->income }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="household_income_per_month">Household Income per month <span
                                                    class="star_require">*</span></label>
                                            <select name="essential[household_income_per_month]"
                                                id="household_income_per_month" required>
                                                <option value="">Select</option>
                                                @foreach ($income_per_month as $income)
                                                    <option value="{{ $income->id }}"
                                                        @isset($essential_details['household_income_per_month']) @if ($essential_details['household_income_per_month'] == $income->id) selected @endif @endisset>
                                                        {{ $income->income }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="province">Province <span class="star_require">*</span></label>
                                            <select name="essential[province]" id="province" required>
                                                <option value="">Select</option>
                                                @foreach ($state as $states)
                                                    <option value="{{ $states->id }}"
                                                        @isset($essential_details['province']) @if ($essential_details['province'] == $states->id) selected @endif @endisset>
                                                        {{ $states->state }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="metropolitan_area">Metropolitan Area <span class="star_require">*</span></label>
                                            <select name="essential[suburb]" id="suburb" required>
                                                <option value="">Select</option>
                                                @foreach ($get_suburb as $suburb)
                                                    <option value="{{ $suburb->id }}"
                                                        @isset($essential_details['suburb']) @if ($essential_details['suburb'] == $suburb->id) selected @endif @endisset>
                                                        {{ $suburb->district }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="suburb">Suburb <span class="star_require">*</span></label>
                                            <input type="text" name="essential[metropolitan_area]"
                                                id="metropolitan_area" class="form-control" required
                                                @isset($essential_details['metropolitan_area']) value ="{{ $essential_details['metropolitan_area'] }}" @endisset>
                                            {{-- <select name="essential[metropolitan_area]" id="metropolitan_area" required>
                                                    <option value="">Select</option>
                                                    @foreach ($get_area as $area)
                                                        <option value="{{$area->id}}" @isset($essential_details['metropolitan_area']) @if ($essential_details['metropolitan_area'] == $area->id) selected @endif @endisset>{{$area->area}}</option>
                                                    @endforeach
                                                </select> --}}
                                        </div>

                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="no_houehold">Number of people living in your household <span
                                                    class="star_require">*</span></label>
                                            <input type="number" name="essential[no_houehold]" id="no_houehold"
                                                class="form-control" required
                                                @isset($essential_details['no_houehold']) value ="{{ $essential_details['no_houehold'] }}" @endisset
                                                min="0">
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="no_children">Number of Children <span
                                                    class="star_require">*</span></label>
                                            <input type="number" name="essential[no_children]" id="no_children"
                                                class="form-control" required
                                                @isset($essential_details['no_children']) value ="{{ $essential_details['no_children'] }}" @endisset
                                                min="0" max="10">
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="no_vehicle">Number of Vehicles <span
                                                    class="star_require">*</span></label>
                                            <input type="number" name="essential[no_vehicle]" id="no_vehicle"
                                                class="form-control" required
                                                @isset($essential_details['no_vehicle']) value ="{{ $essential_details['no_vehicle'] }}" @endisset
                                                min="0" max="10">
                                        </div>
                                    </div>
                                </section>

                                <h2>Extended Details</h2>
                                <section style="overflow-x: auto;">
                                    <div class="row">
                                        <div class="col-6 col-sm-5">
                                            <table border="1" id="children_table"
                                                class="children_table table table-bordered table-striped table-highlight">
                                                <colgroup>
                                                    <col width="20%" />
                                                    <col width="50%" />
                                                    <col width="30%" />
                                                </colgroup>
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Child</th>
                                                        <th style="text-align: center;">DOB</th>
                                                        <th style="text-align: center;">Gender</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $child_key = 1; @endphp
                                                    @if($children_set == 0)
                                                        @foreach ($child_details as $child)
                                                            <tr class="more_tr role_tr"
                                                                id="children_tr{{ $child_key }}">
                                                                <td>
                                                                    <lable>Child {{ $child_key }}</lable>
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        id="children_child_{{ $child_key }}"
                                                                        class="form-control child_age"
                                                                        name="children[dob_{{ $child_key }}][]"
                                                                        value="{{ $child['date'] }}">
                                                                </td>
                                                                <td>
                                                                    <select id="gender_{{ $child_key }}"
                                                                        class="form-control child_gender"
                                                                        name="children[gender_{{ $child_key }}][]">
                                                                        <option value="">Select</option>
                                                                        <option value="male"
                                                                            @if ($child['gender'] == 'male') selected @endif>
                                                                            Male</option>
                                                                        <option value="female"
                                                                            @if ($child['gender'] == 'female') selected @endif>
                                                                            Female</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            @php $child_key++; @endphp
                                                        @endforeach
                                                    @else
                                                        @for($child_i = 1; $child_i <= $children_set; $child_i++)
                                                            <tr class="more_tr role_tr" id="children_tr{{ $child_i }}">
                                                                <td>
                                                                    <lable>Child {{ $child_i }}</lable>
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="children_child_{{ $child_i }}" class="form-control child_age" name="children[dob_{{ $child_key }}][]">
                                                                </td>
                                                                <td>
                                                                    <select id="gender_{{ $child_i }}" class="form-control child_gender" name="children[gender_{{ $child_i }}][]">
                                                                        <option value="">Select</option>
                                                                        <option value="male">Male</option>
                                                                        <option value="female">Female</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-6 col-sm-7">
                                            <table border="1" id="vehicle_table"
                                                class="vehicle_table table table-bordered table-striped table-highlight">
                                                <colgroup>
                                                    <col width="20%" />
                                                    <col width="20%" />
                                                    <col width="20%" />
                                                    <col width="20%" />
                                                    <col width="20%" />
                                                </colgroup>
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;">Vehicle</th>
                                                        <th style="text-align: center;">Brand</th>
                                                        <th style="text-align: center;">Type of vehicle</th>
                                                        <th style="text-align: center;">Model</th>
                                                        <th style="text-align: center;">Year</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $vehicle_key = 1; @endphp
                                                    @if($vehicle_set == 0)
                                                        @foreach ($vehicle_details as $vehicle)
                                                            <tr class="more_tr role_tr" id="vehicle_tr{{ $vehicle_key }}">
                                                                <td>
                                                                    <lable>Vehicle {{ $vehicle_key }}</lable>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control vehicle_brand"
                                                                        id="brand_{{ $vehicle_key }}"
                                                                        name="vehicle[brand_{{ $vehicle_key }}][]">
                                                                        @foreach ($vehicle_master as $veh)
                                                                            <option
                                                                                @if ($veh->id == $vehicle['brand']) selected @endif
                                                                                value="{{ $veh->id }}">
                                                                                {{ $veh->vehicle_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control vehicle_type"
                                                                        id="type_{{ $vehicle_key }}"
                                                                        name="vehicle[type_{{ $vehicle_key }}][]">
                                                                        <option value="sedan"
                                                                            @isset($vehicle['type']) @if ('sedan' == $vehicle['type']) selected @endif @endisset>
                                                                            Sedan</option>
                                                                        <option value="coupe"
                                                                            @isset($vehicle['type']) @if ('coupe' == $vehicle['type']) selected @endif @endisset>
                                                                            Coupe</option>
                                                                        <option value="sports_car"
                                                                            @isset($vehicle['type']) @if ('sports_car' == $vehicle['type']) selected @endif @endisset>
                                                                            Sports Car</option>
                                                                        <option value="wagon"
                                                                            @isset($vehicle['type']) @if ('wagon' == $vehicle['type']) selected @endif @endisset>
                                                                            Station Wagon</option>
                                                                        <option value="hatchback"
                                                                            @isset($vehicle['type']) @if ('hatchback' == $vehicle['type']) selected @endif @endisset>
                                                                            Hatchback</option>
                                                                        <option value="convertible"
                                                                            @isset($vehicle['type']) @if ('convertible' == $vehicle['type']) selected @endif @endisset>
                                                                            Convertible</option>
                                                                        <option value="suv"
                                                                            @isset($vehicle['type']) @if ('suv' == $vehicle['type']) selected @endif @endisset>
                                                                            SPORT-UTILITY VEHICLE (SUV)</option>
                                                                        <option value="minivan"
                                                                            @isset($vehicle['type']) @if ('minivan' == $vehicle['type']) selected @endif @endisset>
                                                                            Minivan</option>
                                                                        <option value="pickup_tuck"
                                                                            @isset($vehicle['type']) @if ('pickup_tuck' == $vehicle['type']) selected @endif @endisset>
                                                                            Pickup Truck</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" value="{{ $vehicle['model'] }}"
                                                                        id="model_{{ $vehicle_key }}"
                                                                        class="form-control vehicle_model"
                                                                        name="vehicle[model_{{ $vehicle_key }}][]">
                                                                </td>
                                                                <td>
                                                                    <select name="vehicle[year_{{ $vehicle_key }}][]" id="year_{{ $vehicle_key }}" class="form-control vehicle_year">
                                                                        <option value="">Select Year</option>
                                                                        @for ($year_drop = date('Y'); $year_drop >= $get_year; $year_drop--)
                                                                            <option value="{{$year_drop}}" @if($year_drop == $vehicle['year']) selected @endif>{{$year_drop}}</option>
                                                                        @endfor
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            @php $vehicle_key++; @endphp
                                                        @endforeach
                                                    @else
                                                        @for($vehicle_i = 1; $vehicle_i <= $vehicle_set; $vehicle_i++)
                                                            <tr class="more_tr role_tr" id="vehicle_tr{{ $vehicle_i }}">
                                                                <td><lable>Vehicle {{ $vehicle_i }}</lable></td>
                                                                <td>
                                                                    <select class="form-control vehicle_brand" id="brand_{{ $vehicle_i }}"
                                                                        name="vehicle[brand_{{ $vehicle_i }}][]">
                                                                        @foreach ($vehicle_master as $veh)
                                                                            <option>{{ $veh->vehicle_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control vehicle_type" id="type_{{ $vehicle_i }}" name="vehicle[type_{{ $vehicle_i }}][]">
                                                                        <option value="sedan">Sedan</option>
                                                                        <option value="coupe">Coupe</option>
                                                                        <option value="sports_car">Sports Car</option>
                                                                        <option value="wagon">Station Wagon</option>
                                                                        <option value="hatchback">Hatchback</option>
                                                                        <option value="convertible">Convertible</option>
                                                                        <option value="suv">SPORT-UTILITY VEHICLE (SUV)</option>
                                                                        <option value="minivan">Minivan</option>
                                                                        <option value="pickup_tuck">Pickup Truck</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="model_{{ $vehicle_i }}" class="form-control vehicle_model" name="vehicle[model_{{ $vehicle_i }}][]">
                                                                </td>
                                                                <td>
                                                                    <select name="vehicle[year_{{ $vehicle_i }}][]" id="year_{{ $vehicle_i }}" class="form-control vehicle_year">
                                                                        <option value="">Select Year</option>
                                                                        @for ($year_drop = date('Y'); $year_drop >= $get_year; $year_drop--)
                                                                            <option value="{{$year_drop}}">{{$year_drop}}</option>
                                                                        @endfor
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="business_org">Which best describes the role in you business /
                                                organization?</label>
                                            <select name="extended[business_org]" id="business_org" onchange="show_other(this, 'business_org')">
                                                <option value="">Select</option>
                                                <option value="owner_director"
                                                    @isset($extended_details['business_org']) @if ($extended_details['business_org'] == 'owner_director') selected @endif @endisset>
                                                    Owner / director (CEO, COO, CFO)</option>
                                                <option value="senior_manager"
                                                    @isset($extended_details['business_org']) @if ($extended_details['business_org'] == 'senior_manager') selected @endif @endisset>
                                                    Senior Manager</option>
                                                <option value="mid_level_manager"
                                                    @isset($extended_details['business_org']) @if ($extended_details['business_org'] == 'mid_level_manager') selected @endif @endisset>
                                                    Mid-Level Manager</option>
                                                <option value="team_leader"
                                                    @isset($extended_details['business_org']) @if ($extended_details['business_org'] == 'team_leader') selected @endif @endisset>
                                                    Team leader / Supervisor</option>
                                                <option value="general_worker"
                                                    @isset($extended_details['business_org']) @if ($extended_details['business_org'] == 'general_worker') selected @endif @endisset>
                                                    General Worker (e.g., Admin, Call Centre Agent, Nurse, Teacher,
                                                    Carer, etc.)</option>
                                                <option value="worker_etc"
                                                    @isset($extended_details['business_org']) @if ($extended_details['business_org'] == 'worker_etc') selected @endif @endisset>
                                                    Worker (e.g., Security Guard, Cleaner, Helper, etc.)</option>
                                                <option value="other"
                                                    @isset($extended_details['business_org']) @if ($extended_details['business_org'] == 'other') selected @endif @endisset>
                                                    Other</option>
                                            </select>
                                            <br>
                                            <input type="text" name="extended[business_org_other]" id="business_org_other" class="form-control" placeholder="Please specify"
                                                @isset($extended_details['business_org'])
                                                    @if($extended_details['business_org'] == "other") style="margin-top: 10px;" @else style="display:none;margin-top: 10px;" @endif
                                                @else
                                                    style="display:none;margin-top: 10px;"
                                                @endisset
                                                @isset($extended_details['business_org_other']) value="{{$extended_details['business_org_other']}}" @endisset>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="org_company">What is the number of people in your organisation
                                                / company?</label>
                                            <select name="extended[org_company]" id="org_company">
                                                <option value="">Select</option>
                                                <option value="just_me"
                                                    @isset($extended_details['org_company']) @if ($extended_details['org_company'] == 'just_me') selected @endif @endisset>
                                                    Just Me (Sole Proprietor)</option>
                                                <option value="2_5"
                                                    @isset($extended_details['org_company']) @if ($extended_details['org_company'] == '2_5') selected @endif @endisset>
                                                    2-5 people</option>
                                                <option value="6_10"
                                                    @isset($extended_details['org_company']) @if ($extended_details['org_company'] == '6_10') selected @endif @endisset>
                                                    6-10 people</option>
                                                <option value="11_20"
                                                    @isset($extended_details['org_company']) @if ($extended_details['org_company'] == '11_20') selected @endif @endisset>
                                                    11-20 people</option>
                                                <option value="21_30"
                                                    @isset($extended_details['org_company']) @if ($extended_details['org_company'] == '21_30') selected @endif @endisset>
                                                    21-30 people</option>
                                                <option value="31_50"
                                                    @isset($extended_details['org_company']) @if ($extended_details['org_company'] == '31_50') selected @endif @endisset>
                                                    31-50 people</option>
                                                <option value="51_100"
                                                    @isset($extended_details['org_company']) @if ($extended_details['org_company'] == '51_100') selected @endif @endisset>
                                                    51-100 people</option>
                                                <option value="101_250"
                                                    @isset($extended_details['org_company']) @if ($extended_details['org_company'] == '101_250') selected @endif @endisset>
                                                    101-250 people</option>
                                                <option value="251_500"
                                                    @isset($extended_details['org_company']) @if ($extended_details['org_company'] == '251_500') selected @endif @endisset>
                                                    251-500 people</option>
                                                <option value="500_1000"
                                                    @isset($extended_details['org_company']) @if ($extended_details['org_company'] == '500_1000') selected @endif @endisset>
                                                    500-1000 people</option>
                                                <option value="more_than_1000"
                                                    @isset($extended_details['org_company']) @if ($extended_details['org_company'] == 'more_than_1000') selected @endif @endisset>
                                                    More than 1000 people</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="bank_main">Which bank do you bank with (which is your bank
                                                main)</label>
                                            <select name="extended[bank_main]" id="bank_main" onchange="show_other(this, 'bank_main')">
                                                <option value="">Select</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->id }}"
                                                        @isset($extended_details['bank_main']) @if ($extended_details['bank_main'] == $bank->id) selected @endif @endisset>
                                                        {{ $bank->bank_name }}</option>
                                                @endforeach
                                                <option value="other"
                                                    @isset($extended_details['bank_main']) @if ($extended_details['bank_main'] == 'other') selected @endif @endisset>
                                                    Other</option>
                                            </select>
                                            <br>
                                            <input type="text" name="extended[bank_main_other]" id="bank_main_other" class="form-control" placeholder="Please specify"
                                            @isset($extended_details['bank_main'])
                                                @if($extended_details['bank_main'] == "other") style="margin-top: 10px;" @else style="display:none;margin-top: 10px;" @endif
                                            @else
                                                style="display:none;margin-top: 10px;"
                                            @endisset
                                            @isset($extended_details['bank_main_other']) value="{{$extended_details['bank_main_other']}}" @endisset>
                                        </div>
                                        <div class="col-6 col-sm-4 mt-3">
                                            <label for="home_lang">Home Language</label>
                                            <select name="extended[home_lang]" id="home_lang" onchange="show_other(this, 'home_lang')">
                                                <option value="">Select</option>
                                                <option value="afrikaans"
                                                    @isset($extended_details['home_lang']) @if ($extended_details['home_lang'] == 'afrikaans') selected @endif @endisset>
                                                    Afrikaans</option>
                                                <option value="english"
                                                    @isset($extended_details['home_lang']) @if ($extended_details['home_lang'] == 'english') selected @endif @endisset>
                                                    English</option>
                                                <option value="ndebele"
                                                    @isset($extended_details['home_lang']) @if ($extended_details['home_lang'] == 'ndebele') selected @endif @endisset>
                                                    Ndebele</option>
                                                <option value="pedi"
                                                    @isset($extended_details['home_lang']) @if ($extended_details['home_lang'] == 'pedi') selected @endif @endisset>
                                                    Pedi</option>
                                                <option value="sotho"
                                                    @isset($extended_details['home_lang']) @if ($extended_details['home_lang'] == 'sotho') selected @endif @endisset>
                                                    Sotho</option>
                                                <option value="swati"
                                                    @isset($extended_details['home_lang']) @if ($extended_details['home_lang'] == 'swati') selected @endif @endisset>
                                                    Swati</option>
                                                <option value="tsonga"
                                                    @isset($extended_details['home_lang']) @if ($extended_details['home_lang'] == 'tsonga') selected @endif @endisset>
                                                    Tsonga</option>
                                                <option value="tswana"
                                                    @isset($extended_details['home_lang']) @if ($extended_details['home_lang'] == 'tswana') selected @endif @endisset>
                                                    Tswana</option>
                                                <option value="venda"
                                                    @isset($extended_details['home_lang']) @if ($extended_details['home_lang'] == 'venda') selected @endif @endisset>
                                                    Venda</option>
                                                <option value="xhosa"
                                                    @isset($extended_details['home_lang']) @if ($extended_details['home_lang'] == 'xhosa') selected @endif @endisset>
                                                    Xhosa</option>
                                                <option value="zulu"
                                                    @isset($extended_details['home_lang']) @if ($extended_details['home_lang'] == 'zulu') selected @endif @endisset>
                                                    Zulu</option>
                                                <option value="other"
                                                    @isset($extended_details['home_lang']) @if ($extended_details['home_lang'] == 'other') selected @endif @endisset>
                                                    Other</option>
                                            </select>
                                            <br>
                                            <input type="text" name="extended[home_lang_other]" id="home_lang_other" class="form-control" placeholder="Please specify"
                                            @isset($extended_details['home_lang'])
                                                @if($extended_details['home_lang'] == "other") style="margin-top: 10px;" @else style="display:none;margin-top: 10px;" @endif
                                            @else
                                                style="display:none;margin-top: 10px;"
                                            @endisset
                                            @isset($extended_details['home_lang_other']) value="{{$extended_details['home_lang_other']}}" @endisset>
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
<script src="{{ asset('assets/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/inputmask.js') }}"></script>
<script src="{{ asset('assets/inputmask/jquery.inputmask.bundle.js') }}"></script>
<script src="{{ asset('assets/moment/moment.js') }}"></script>
<script>
    $(function() {
        var tempcsrf = '{!! csrf_token() !!}';
        var form = $("#profile_wizard_form");

        $("#profile_wizard").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true,
            // saveState: true,
            // stepsOrientation: "vertical",
            onStepChanging: function(event, currentIndex, newIndex) {
                if (currentIndex == 0 && newIndex == 1 || currentIndex == 2 && newIndex == 1) {
                    if (form.valid() == true) {
                        get_unique_id = $("#get_unique_id").val();
                        first_name = $("#first_name").val();
                        last_name = $("#last_name").val();
                        mobile_number = $("#mobile_number").val();
                        whatsapp_number = $("#whatsapp_number").val();
                        email = $("#email").val();
                        date_of_birth = $("#date_of_birth").val();

                        datas1 = {
                            _token: tempcsrf,
                            serialize_data: form.serialize(),
                            step: 1
                        };

                        if (currentIndex == 0 && newIndex == 1) {
                            wizard_save(datas1);
                        }
                    }

                    return form.valid();
                } else if (currentIndex == 1 && newIndex == 2) {
                    if (form.valid() == true) {
                        datas2 = {
                            _token: tempcsrf,
                            serialize_data: form.serialize(),
                            step: 2
                        };
                        wizard_save(datas2);
                    }
                    return form.valid();
                }
                return true;
            },
            labels: {
                finish: 'Finish <i class="fa fa-chevron-right"></i>',
                next: 'Next <i class="fa fa-chevron-right"></i>',
                previous: '<i class="fa fa-chevron-left"></i> Previous'
            },
            onFinishing: function(event, currentIndex) {
                return true;
            },
            onFinished: function(event, currentIndex) {
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
                                child_val = [];
                                vehicle_val = [];
                                $('#children_table > tbody  > tr').each(function(index,
                                    tr) {
                                    get_date = $(this).find(".child_age").val();
                                    get_gender = $(this).find(".child_gender")
                                        .val();

                                    set_child = {
                                        'date': get_date,
                                        'gender': get_gender
                                    };
                                    child_val.push(set_child);
                                });

                                $('#vehicle_table > tbody  > tr').each(function(index,
                                    tr) {
                                    get_brand = $(this).find(".vehicle_brand")
                                        .val();
                                    get_type = $(this).find(".vehicle_type")
                                        .val();
                                    get_model = $(this).find(".vehicle_model")
                                        .val();
                                    get_year = $(this).find(".vehicle_year")
                                        .val();

                                    set_vehicle = {
                                        'brand': get_brand,
                                        'type': get_type,
                                        'model': get_model,
                                        'year': get_year
                                    };
                                    vehicle_val.push(set_vehicle);
                                });

                                datas2 = {
                                    _token: tempcsrf,
                                    serialize_data: form.serialize(),
                                    step: 3,
                                    child_val: child_val,
                                    vehicle_val: vehicle_val
                                };
                                wizard_save(datas2);
                                window.location.href = "{{ route('user.dashboard') }}";
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
        $('#mobile_number').inputmask("999 999 9999");
        $('#whatsapp_number').inputmask("999 999 9999");

        $('#relationship_status, #gender, #ethnic_group, #education_level, #employment_status, #industry_my_company, #personal_income_per_month, #business_org,' +
            '#household_income_per_monty, #province, #suburb, #org, #org_company, #bank_main, #home_lang, #household_income_per_month'
        ).select2({
            height: '10%',
            width: '100%'
        });

        $("#no_children").keyup(function() {
            no_children = $(this).val();
            scroll_div = $("#children_table");
            append_html = "";
            $("#children_table .more_tr").html("");
            if (no_children != 0) {
                for (child = 1; child <= no_children; child++) {
                    append_html += '<tr class="more_tr role_tr" id="children_tr' + child + '">' +
                        '<td>' +
                        '<lable>Child ' + child + '</lable>' +
                        '</td>' +
                        '<td>' +
                        '<input type="text" id="children_child_' + child +
                        '" class="form-control child_age" name="children[dob_' + child + '][]">' +
                        '</td>' +
                        '<td>' +
                        '<select id="gender_' + child +
                        '" class="form-control child_gender" name="children[gender_' + child + '][]">' +
                        '<option value="">Select</option>' +
                        '<option value="male">Male</option>' +
                        '<option value="female">Female</option>' +
                        '</select>' +
                        '</td>' +
                        '</tr>';
                }
                scroll_div.append(append_html);

                $('.child_age').inputmask("yyyy/mm/dd", {
                    "placeholder": "YYYY/MM/DD",
                    onincomplete: function() {
                        $(this).val('');
                    }
                });
            }
        });

        $("#no_vehicle").keyup(function() {
            no_vehicle = $(this).val();
            scroll_div_vehicle = $("#vehicle_table");
            vehicle_html = "";
            $("#vehicle_table .more_tr").html("");
            if (no_vehicle != 0) {
                for (vehicles = 1; vehicles <= no_vehicle; vehicles++) {
                    vehicle_html += '<tr class="more_tr role_tr" id="vehicle_tr' + vehicles + '">' +
                        '<td>' +
                        '<lable>Vehicle ' + vehicles + '</lable>' +
                        '</td>' +
                        '<td>' +
                        '<select class="form-control vehicle_brand" id="brand_' + vehicles +
                        '" name="vehicle[brand_' + vehicles + '][]">' +
                        '<option value="" selected>Select Vechicle</option>' +
                        '@foreach ($vehicle_master as $veh)' +
                        '<option value="{{ $veh->id }}">{{ $veh->vehicle_name }}</option>' +
                        '@endforeach' +
                        '</select>' +
                        '</td>' +
                        '<td>' +
                        '<select class="form-control vehicle_brand" id="type_' + vehicles +
                        '" name="vehicle[type_' + vehicles + '][]">' +
                        '<option value="sedan">Sedan</option>' +
                        '<option value="coupe">Coupe</option>' +
                        '<option value="sports_car">Sports Car</option>' +
                        '<option value="wagon">Station Wagon</option>' +
                        '<option value="hatchback">Hatchback</option>' +
                        '<option value="convertible">Convertible</option>' +
                        '<option value="suv">SPORT-UTILITY VEHICLE (SUV)</option>' +
                        '<option value="minivan">Minivan</option>' +
                        '<option value="pickup_tuck">Pickup Truck</option>' +
                        '</select>' +
                        '</td>' +
                        '<td>' +
                        '<input type="text" id="model_' + vehicles +
                        '" class="form-control vehicle_model" name="vehicle[model_' + vehicles +
                        '][]">' +
                        '</td>' +
                        '<td>' +
                        '<select name="vehicle[year_{{ $vehicle_key }}][]" id="year_{{ $vehicle_key }}" class="form-control vehicle_year">'+
                            '<option value="">Select Year</option>'+
                            '@for ($year_drop = date("Y"); $year_drop >= $get_year; $year_drop--)'+
                                '<option value="{{$year_drop}}">{{$year_drop}}</option>'+
                            '@endfor'+
                        '</select>' +
                        '</td>' +
                        '</tr>';
                }
                scroll_div_vehicle.append(vehicle_html);
            }
        }).addClass('responsive-wizard');

        $("#date_of_birth").change(function() {
            var date_of_birth = $(this).val();
            var today = new Date();
            var out;

            out = diffDate(new Date(date_of_birth), new Date(today));
            display(out);

            function diffDate(startDate, endDate) {
                var b = moment(startDate),
                    a = moment(endDate),
                    intervals1 = ['Years', 'Months', 'Days'],
                    intervals = ['Years'],
                    out = {};

                for (var i = 0; i < intervals.length; i++) {
                    var diff = a.diff(b, intervals[i]);
                    b.add(diff, intervals[i]);
                    out[intervals[i]] = diff;
                }
                return out;
            }

            function display(obj) {
                var str = '';
                for (key in obj) {
                    str = str + obj[key] + ' ' + key + ' '
                }
                console.log("str", str);
                document.getElementById('agecal').innerText = str;
            }
        });

        $("#province").change(function() {
            province = $(this).val();
            $.ajax({
                url: '{{ route('get_suburb') }}',
                type: 'GET',
                data: {
                    'province': province
                },
                dataType: 'json',
                success: function(data) {
                    if (data.type == true) {
                        $("#suburb").html(data.data);
                    }
                },
                error: function(request, error) {
                    // alert("Request: "+JSON.stringify(request));
                }
            });
        });

        // $("#suburb").change(function() {
        //     suburb = $(this).val();
        //     $.ajax({
        //         url : '{{ route('get_area') }}',
        //         type : 'GET',
        //         data : {
        //             'suburb' : suburb
        //         },
        //         dataType:'json',
        //         success : function(data) { 
        //             if(data.type == true)             {
        //                 $("#metropolitan_area").html(data.data);
        //             }
        //         },
        //         error : function(request,error)
        //         {
        //             // alert("Request: "+JSON.stringify(request));
        //         }
        //     });
        // });
    });

    function show_other(get_this, id_val){
        value = $(get_this).val();
        console.log("value",value);
        if(value == "other"){
            console.log("HI");
            $("#"+id_val+"_other").show();
        }else{
            $("#"+id_val+"_other").hide();
        }
    }

    function wizard_save(datas) {
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
        $('#date_of_birth').inputmask("yyyy/mm/dd", {
            "placeholder": "YYYY/MM/DD",
            onincomplete: function() {
                $(this).val('');
            }
        });
    });

    $(document).ready(function() {
        $("#profile_wizard_form").validate({
            rules: {
                relationship_status: "required",
                gender: "required",
                ethnic_group: "required",
                education_level: "required",
                employment_status: "required",
                industry_my_company: "required",
                personal_income_per_month: "required",
                household_income_per_month: "required",
                province: "required",
                suburb: "required",
                business_org: "required",
                org_company: "required",
                bank_main: "required",
                home_lang: "required",
            },
            highlight: function(element, errorClass, validClass) {
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    $("#select2-" + elem.attr("id") + "-container").parent().addClass(errorClass);
                } else {
                    elem.addClass(errorClass);
                }
            },
            unhighlight: function(element, errorClass, validClass) {
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    $("#select2-" + elem.attr("id") + "-container").parent().removeClass(
                        errorClass);
                } else {
                    elem.removeClass(errorClass);
                }
            },
            errorPlacement: function(error, element) {
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    element = $("#select2-" + elem.attr("id") + "-container").parent();
                    error.insertAfter(element);
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('select.select2-hidden-accessible').on("change", function(e) {
            $(this).valid();

        });

        $('.child_age').inputmask("yyyy/mm/dd", {
            "placeholder": "YYYY/MM/DD",
            onincomplete: function() {
                $(this).val('');
            }
        });
    });
</script>
