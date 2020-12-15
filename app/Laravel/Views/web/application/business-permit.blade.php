@extends('web._layouts.main')
@section('content')

<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
        <div class="row">
            @include('web.business.business_sidebar')
            <div class="col-md-9">
                <form class="create-form" method="POST" enctype="multipart/form-data">
                    @include('system._components.notifications')
                    {!!csrf_field()!!}
                    <div class="card">
                        <div class="card-header text-center">
                            <h2>Application for Business Permit</h2>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Application No.</label>
                                        <p class="form-data text-success">{{ session('application_no') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business ID. No.</label>
                                        <p class="form-data text-success">{{ $business->business_id_no }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="text-form pb-2">Type of Application</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input application_type" name="application_type" disabled value="new" {{ session('application.transaction_type')=="new" ? "checked" : ""}}>New
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input application_type" name="application_type" disabled value="renew" {{ session('application.transaction_type')=="renew" ? "checked" : ""}}>Renew
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input application_type" name="application_type" disabled value="additional">Additional
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input application_type" name="application_type" disabled value="transfer">Transafer
                                            </label>
                                        </div>
                                        <div id="transfer" style="display:none;">
                                            <div class="ml-5">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                      <input type="checkbox" class="form-check-input transfer" value="transfer_ownership" name="application_type">Ownership
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                      <input type="checkbox" class="form-check-input transfer" value="transfer_location" name="application_type">Location
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                      <input type="checkbox" class="form-check-input transfer" value="transfer_organization" name="application_type">Organization
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $(function () {
                                            $(".application_type").change(function(){
                                                var radioValue = $("input[name='application_type']:checked").val();

                                                if(radioValue == "renew"){
                                                    $('.renew').show();
                                                    $('.new').hide();
                                                } else {
                                                    $('.renew').hide();

                                                }
                                                if(radioValue == "new"){
                                                    $('.new').show();
                                                    $('.renew').hide();
                                                }
                                            }).change();

                                            $(".transfer").change(function(){
                                                $(".transfer").prop('checked',false);
                                                $(this).prop('checked',true);
                                            });

                                            $(".amendments").change(function(){
                                                $(".amendments").prop('checked',false);
                                                $(this).prop('checked',true);
                                            });


                                        })
                                    </script>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="text-form pb-2">Amendments</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input amendments" name="amendments" value="single_to_parnership">From Single To Partnership
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input amendments" name="amendments" value="single_to_corporation">From Single To Corporation
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input amendments" name="amendments" value="partnership_to_single">From Partnership To Single
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input amendments" name="amendments" value="partnership_to_corporation">From Partnership To Corporation
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input amendments" name="amendments" value="corporation_to_single">From Corporation To Single
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input amendments" name="amendments" value="corporation_to_partnership">From Corporation To Partnership
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Date of Application</label>
                                        <p class="form-data text-success">{{ now() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">DTI/SEC/CDA registration No.</label>
                                        <p class="form-data text-success">{{ $business->dti_sec_cda_registration_no }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">DTI/SEC/CDA registration Date</label>
                                        <p class="form-data text-success">{{ $business->dti_sec_cda_registration_date }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">CTC No.</label>
                                        <p class="form-data text-success">{{ $business->ctc_no }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business TIN.</label>
                                        <p class="form-data text-success">{{ $business->business_tin }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Type of Ownership</label>
                                        <p class="form-data text-success">{{ $business->business_type}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="text-form pb-2">Are you enjoying tax incentive from any Goverment Entity?</label>
                                        <p class="form-data text-success">{{ $business->tax_incentive }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Name</label>
                                        <p class="form-data text-success">{{ $business->business_name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Trade name / Franchise</label>
                                        <p class="form-data text-success">{{ $business->tradename }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Name of Tax Payer/Owner</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Last Name</label>
                                        <p class="form-data text-success">{{ $auth->lname }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">First Name</label>
                                        <p class="form-data text-success">{{ $auth->fname }}</p>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Middle Name</label>
                                        <p class="form-data text-success">{{ $auth->mname }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Gender</label>
                                        <p class="form-data text-success">{{ $auth->gender }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Name of Authorized Representative</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Last Name</label>
                                        <p class="form-data text-success">{{ $business->rep_lastname }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">First Name</label>
                                        <p class="form-data text-success">{{ $business->rep_firstname }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Middle Name</label>
                                        <p class="form-data text-success">{{ $business->rep_middlename }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Gender</label>
                                        <p class="form-data text-success">{{ $business->rep_gender }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Position</label>
                                        <p class="form-data text-success">{{ $business->rep_position }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">TIN</label>
                                        <p class="form-data text-success">{{ $business->rep_tin }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Business Address</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <p class="form-data text-success">{{ $business->region_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">City Municipality</label>
                                        <p class="form-data text-success">{{ $business->town_name }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay</label>
                                        <p class="form-data text-success">{{ $business->brgy_name }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="input_zipcode" class="text-form pb-2">Zipcode</label>
                                        <p class="form-data text-success">{{ $business->zipcode }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">House/Bldg No.</label>
                                        <p class="form-data text-success">{{ $business->unit_no }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Street Address</label>
                                        <p class="form-data text-success">{{ $business->street_address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email</label>
                                        <p class="form-data text-success">{{ $business->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Mobile Number</label>
                                        <p class="form-data text-success">{{ $business->mobile_no }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Telephone Number</label>
                                        <p class="form-data text-success">{{ $business->telephone_no }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Website URL</label>
                                        <p class="form-data text-success">{{ $business->website_url }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Area (Sq. m)</label>
                                        <p class="form-data text-success">{{ $business->business_area }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Total No. Employees</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Male</label>
                                        <p class="form-data text-success">{{ $business->no_of_male_employee }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Female</label>
                                        <p class="form-data text-success">{{ $business->no_of_female_employee }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Total No. Employees Residing in City</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Male</label>
                                        <p class="form-data text-success">{{ $business->male_residing_in_city }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Female</label>
                                        <p class="form-data text-success">{{ $business->female_residing_in_city }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Owner's Address</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Region</label>
                                        <p class="form-data text-success">{{ $auth->region_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">City Municipality</label>
                                        <p class="form-data text-success">{{ $auth->town_name }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay</label>
                                        <p class="form-data text-success">{{ $auth->barangay_name }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="input_zipcode" class="text-form pb-2">Zipcode</label>
                                        <p class="form-data text-success">{{ $auth->zipcode }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">House/Bldg No.</label>
                                        <p class="form-data text-success">{{ $auth->unit_number }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Street Address</label>
                                        <p class="form-data text-success">{{ $auth->street_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email</label>
                                        <p class="form-data text-success">{{ $auth->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Mobile Number</label>
                                        <p class="form-data text-success">{{ $auth->contact_number }}</p>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Telephone Number</label>
                                        <p class="form-data text-success">{{ $auth->region_name }}</p>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                {{-- <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Website URL</label>
                                        <input type="url" class="form-control form-control-sm {{ $errors->first('owner_website') ? 'is-invalid': NULL  }}"  name="owner_website" value="{{old('owner_website',$auth->telephone_no) }}">
                                        @if($errors->first('owner_website'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_website')}}</small>
                                        @endif
                                    </div>
                                </div> --}}
                            </div>
                            <h5 class="text-title text-uppercase">If place of Business is Rented (Lessor Detail)</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Monthly Rental</label>
                                        <p class="form-data text-success">{{ $business->lessor_monthly_rental }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Start Date of Rental (MM/DD/YYYY)</label>
                                        <p class="form-data text-success">{{ $business->lessor_rental_date }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Name of Lessor / Corporation</label>
                                        <p class="form-data text-success">{{ $business->lessor_fullname }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Gender</label>
                                        <p class="form-data text-success">{{ $business->lessor_gender }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputEmail1" class="text-form pb-2">Region</label>
                                    <p class="form-data text-success">{{ $business->lessor_region_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">City Municipality</label>
                                        <p class="form-data text-success">{{ $business->lessor_town_name }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay</label>
                                        <p class="form-data text-success">{{ $business->lessor_brgy_name }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="input_zipcode" class="text-form pb-2">Zipcode</label>
                                        <p class="form-data text-success">{{ $business->lessor_zipcode }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">House/Bldg No.</label>
                                        <p class="form-data text-success">{{ $business->lessor_unit_no }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Street Address</label>
                                        <p class="form-data text-success">{{ $business->lessor_street_address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email</label>
                                        <p class="form-data text-success">{{ $business->lessor_email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Mobile Number</label>
                                        <p class="form-data text-success">{{ $business->lessor_mobile_no }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Telephone Number</label>
                                        <p class="form-data text-success">{{ $business->lessor_tel_no }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Incase of Emergency</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Contact Person</label>
                                        <p class="form-data text-success">{{ $business->emergency_contact_fullname }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Tel. No</label>
                                        <p class="form-data text-success">{{ $business->emergency_contact_tel_no }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Mobile No.</label>
                                        <p class="form-data text-success">{{ $business->emergency_contact_mobile_no}}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email Address</label>
                                        <p class="form-data text-success">{{ $business->emergency_contact_email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center">
                                                <th class="text-title text-uppercase">Line of Business</th>
                                                <th class="text-title text-uppercase">No. Units</th>
                                                <th class="text-title text-uppercase new" style="display: none;">New (Capital Investment)</th>
                                                <th class="text-title text-uppercase renew" style="display: none;">Renew (Gross Sales / Receipt)</th>
                                            </thead>
                                            <tbody id="businessline_tbody">
                                                @foreach ($business_line as $key => $item)
                                                <tr id="repeat_form">
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" name="line_of_business[]" value="{{ $item->name }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm" name="no_of_units[]">
                                                    </td>
                                                    <td class="new"  style="display: none;">
                                                        <input type="number" class="form-control form-control-sm" name="capitalization[]">
                                                    </td>
                                                    <td class="renew"  style="display: none;">
                                                        <input type="number" class="form-control form-control-sm" name="renew[]">
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <button class="btn btn-light btn-sm" id="repeater_add_activity" type="button"><i class="fa fa-plus mr-2"></i>Add Line of Business</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <th class="text-title">Requirment Name</th>
                                                <th class="text-title" class="text-wrap">File</th>
                                            </thead>
                                            <tr>
                                                <td>BN Certificate</td>
                                                <td><input type="file" class="text-wrap"></td>
                                            </tr>
                                            <tr>
                                                <td>Barangay Clearance</td>
                                                <td><input type="file" class="text-wrap"></td>
                                            </tr>
                                            <tr>
                                                <td>Occupancy Permit</td>
                                                <td><input type="file" class="text-wrap"></td>
                                            </tr>
                                            <tr>
                                                <td>Land Title (Home based) *If owned</td>
                                                <td><input type="file" class="text-wrap"></td>
                                            </tr>
                                            <tr>
                                                <td>Authorization from Owner *If rent</td>
                                                <td><input type="file" class="text-wrap"></td>
                                            </tr>
                                            <tr>
                                                <td>Actual Photo of Establishment</td>
                                                <td><input type="file" class="text-wrap"></td>
                                            </tr>
                                            <tr>
                                                <td>BIR ITR Form</td>
                                                <td><input type="file" class="text-wrap"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn badge-primary-2 text-white trigger-modal" style="float: right;">Request Assessment</button>
                            <a href="{{route('web.business.index')}}" class="btn btn-light mr-2" style="float: right;">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <h1 class="text-success">Success</h1>
                            <p style="font-weight: bold">This is to confirm that we have recieved your assessment request. We will process your request and will update you on the status. Thank you!</p>
                            <a href="{{route('web.business.index')}}" class="btn btn-light text-success">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!--team section end-->


@stop

@section('page-scripts')

<script type="text/javascript">

    $('.trigger-modal').click(function (){
        $('.modal').modal('show');
    })
     $.fn.get_region = function(input_region,input_province,input_city,input_brgy,selected){

      $(input_city).empty().prop('disabled',true)
      $(input_brgy).empty().prop('disabled',true)

      $(input_region).append($('<option>', {
                value: "",
                text: "Loading Content..."
            }));
      $.getJSON("{{env('PSGC_REGION_URL')}}", function( response ) {
          $(input_region).empty().prop('disabled',true)
          $.each(response.data,function(index,value){
            $(input_region).append($('<option>', {
                value: index,
                text: value
            }));
          })

          $(input_region).prop('disabled',false)
          $(input_region).prepend($('<option>',{value : "",text : "--Select Region--"}))
          if(selected.length > 0){
            $(input_region).val($(input_region+" option[value="+selected+"]").val());
          }else{
            $(input_region).val($(input_region+" option:first").val());
          }
      });
      // return result;
    };

    $.fn.get_city = function(reg_code,input_city,input_brgy,selected){
      $(input_brgy).empty().prop('disabled',true)
      $(input_city).append($('<option>', {
            value: "",
            text: "Loading Content..."
        }));
      $.getJSON("{{env('PSGC_CITY_URL')}}?region_code="+reg_code, function( data ) {
        console.log(data)
          $(input_city).empty().prop('disabled',true)
          $.each(data,function(index,value){
              $(input_city).append($('<option>', {
                  value: index,
                  text: value
              }));
          })

          $(input_city).prop('disabled',false)
          $(input_city).prepend($('<option>',{value : "",text : "--SELECT MUNICIPALITY/CITY, PROVINCE--"}))
          if(selected.length > 0){
            $(input_city).val($(input_city+" option[value="+selected+"]").val());
          }else{
            $(input_city).val($(input_city+" option:first").val());
          }
      });
      // return result;
    };

    $.fn.get_brgy = function(munc_code,input_brgy,selected){
      $(input_brgy).empty().prop('disabled',true);
      $(input_brgy).append($('<option>', {
                value: "",
                text: "Loading Content..."
            }));
      $.getJSON("{{env('PSGC_BRGY_URL')}}?city_code="+munc_code, function( data ) {
          $(input_brgy).empty().prop('disabled',true);

          $.each(data,function(index,value){
            $(input_brgy).append($('<option>', {
                value: index,
                text: value.desc,
                "data-zip_code" : (value.zip_code).trim()
            }));
          })
          $(input_brgy).prop('disabled',false)
          $(input_brgy).prepend($('<option>',{value : "",text : "--SELECT BARANGAY--"}))

          if(selected.length > 0){
            $(input_brgy).val($(input_brgy+" option[value="+selected+"]").val());

            if(typeof $(input_brgy+" option[value="+selected+"]").data('zip_code')  === undefined){
              $(input_brgy.replace("brgy","zipcode")).val("")
            }else{
              $(input_brgy.replace("brgy","zipcode")).val($(input_brgy+" option[value="+selected+"]").data('zip_code'))
            }

          }else{
            $(input_brgy).val($(input_brgy+" option:first").val());
          }
      });
    }
     $(function(){

        $(this).get_region("#input_region","#input_province","#input_town","#input_brgy","{{old('region')}}")

        $("#input_region").on("change",function(){
            var _val = $(this).val();
            var _text = $("#input_region option:selected").text();
            $(this).get_city($("#input_region").val(), "#input_town", "#input_brgy", "{{old('town')}}");
            $('#input_zipcode').val('');
            $('#input_region_name').val(_text);
        });

        $("#input_town").on("change",function(){
            var _val = $(this).val();
            var _text = $("#input_town option:selected").text();
            $(this).get_brgy(_val, "#input_brgy", "");
            $('#input_zipcode').val('');
            $('#input_town_name').val(_text);
        });

        @if(strlen(old('region')) > 0)
            $(this).get_city("{{old('region')}}", "#input_town", "#input_brgy", "{{old('town')}}");
        @endif

        @if(strlen(old('town')) > 0)
            $(this).get_brgy("{{old('town')}}", "#input_brgy", "{{old('brgy')}}");
        @endif

        $("#input_brgy").on("change",function(){
            $('#input_zipcode').val($(this).find(':selected').data('zip_code'))
            var _text = $("#input_brgy option:selected").text();
            $('#input_brgy_name').val(_text);
        });

        $('#repeater_add_activity').on('click', function(){
            var repeat_item = $("#repeat_form").eq(0).prop('outerHTML');
            $("#businessline_tbody").append(repeat_item)
            $('.new').show();
            $('.renew').hide();
            $(".application_type").prop('checked', false);
            $('input[name=application_type][value=new]').prop('checked', true);

        });
    })
</script>
@endsection
