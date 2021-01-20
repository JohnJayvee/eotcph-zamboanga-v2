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
                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Application No.</label>
                                        <p class="form-data text-success text-uppercase text-uppercase">{{ session('application_no') }}</p>
                                        <input type="hidden" name="application_no" value="{{ session('application_no') }}">
                                    </div>
                                </div> -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business ID. No.</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->business_id_no }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="text-form pb-2">Type of Application</label>
                                        <input type="hidden" class="type_of_application" name="type_of_application">
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
                                        {{-- <div class="form-check">
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
                                        </div> --}}
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
                                        <p class="form-data text-success text-uppercase">{{ now() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">DTI/SEC/CDA registration No.</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->dti_sec_cda_registration_no }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">DTI/SEC/CDA registration Date</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->dti_sec_cda_registration_date }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Cedula No.</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->ctc_no }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business TIN.</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->business_tin }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Type of Ownership</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->business_type}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="text-form pb-2">Are you enjoying tax incentive from any Goverment Entity?</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->tax_incentive }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Name</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->business_name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Trade name / Franchise</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->tradename }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Business Address</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <p class="form-data text-success text-uppercase">{{ $business->region_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">City Municipality</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->town_name }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->brgy_name }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="input_zipcode" class="text-form pb-2">Zipcode</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->zipcode }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">House/Bldg No.</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->unit_no }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Street Address</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->street_address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Mobile Number</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->mobile_no }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Telephone Number</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->telephone_no }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Website URL</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->website_url }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Area (Sq. m)</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->business_area }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Total No. Employees</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Male</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->no_of_male_employee }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Female</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->no_of_female_employee }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Total No. Employees Residing in City</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Male</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->male_residing_in_city }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Female</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->female_residing_in_city }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Name of Tax Payer/Owner</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Last Name</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->owner_lname }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">First Name</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->owner_fname }}</p>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Middle Name</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->owner_mname }}</p>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Gender</label>
                                        <p class="form-data text-success text-uppercase">{{ $auth->gender }}</p>
                                    </div>
                                </div> --}}
                            </div>
                            <h5 class="text-title text-uppercase">Owner's Address</h5>
                            {{-- <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Region</label>
                                        <p class="form-data text-success text-uppercase">{{ $auth->region_name }}</p>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row">
                                {{-- <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">City Municipality</label>
                                        <p class="form-data text-success text-uppercase">{{ $auth->town_name }}</p>
                                    </div>
                                </div> --}}
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->owner_brgy_name }}</p>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="input_zipcode" class="text-form pb-2">Zipcode</label>
                                        <p class="form-data text-success text-uppercase">{{ $auth->zipcode }}</p>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">House/Bldg No.</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->owner_unit_no }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Street Address</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->owner_street }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->owner_email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Mobile Number</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->owner_mobile_no }}</p>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Telephone Number</label>
                                        <p class="form-data text-success text-uppercase">{{ $auth->region_name }}</p>
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
                            <h5 class="text-title text-uppercase">Name of Authorized Representative</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Last Name</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->rep_lastname }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">First Name</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->rep_firstname }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Middle Name</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->rep_middlename }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Gender</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->rep_gender }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Position</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->rep_position }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">TIN</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->rep_tin }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">If place of Business is Rented (Lessor Detail)</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Monthly Rental</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->lessor_monthly_rental }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Start Date of Rental (MM/DD/YYYY)</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->lessor_rental_date }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Name of Lessor / Corporation</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->lessor_fullname }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Gender</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->lessor_gender }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputEmail1" class="text-form pb-2">Region</label>
                                    <p class="form-data text-success text-uppercase">{{ $business->lessor_region_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">City Municipality</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->lessor_town_name }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->lessor_brgy_name }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="input_zipcode" class="text-form pb-2">Zipcode</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->lessor_zipcode }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">House/Bldg No.</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->lessor_unit_no }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Street Address</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->lessor_street_address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->lessor_email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Mobile Number</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->lessor_mobile_no }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Telephone Number</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->lessor_tel_no }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Incase of Emergency</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Contact Person</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->emergency_contact_fullname }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Tel. No</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->emergency_contact_tel_no }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Mobile No.</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->emergency_contact_mobile_no}}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email Address</label>
                                        <p class="form-data text-success text-uppercase">{{ $business->emergency_contact_email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="text-center">
                                                <th class="text-title text-uppercase">Line of Business <span class="text-danger">*</span></th>
                                                <th class="text-title text-uppercase">No. Units</th>
                                                <th class="text-title text-uppercase new" style="display: none;">New (Capital Investment)</th>
                                                <th class="text-title text-uppercase renew" style="display: none;">Renew (Gross Sales / Capital) <span class="text-danger">*</span></th>
                                                <th class="text-title text-uppercase">Action</th>
                                            </thead>
                                            <tbody id="businessline_tbody">
                                                @foreach ($business_line as $key => $item)
                                                <tr id="repeat_form" class="activity">
                                                    <td>
                                                        <input type="text" readonly class="form-control form-control-sm {{ $errors->has('line_of_business.*') ? 'is-invalid': NULL  }}" name="line_of_business[]" value="{{old('line_of_business[]', $item->name.($item->particulars ? " (".$item->particulars.")" : "")) }}">
                                                        <input type="hidden" readonly class="form-control form-control-sm {{ $errors->has('account_code.*') ? 'is-invalid': NULL  }}" name="account_code[]" value="{{old('class[]', $item->name."---".$item->reference_code."---".$item->b_class."---".$item->s_class."---".($item->x_class ? $item->x_class : 0))."---".$item->account_code."---".$item->particulars }}">
                                                        <input type="hidden" class="form-control form-control-sm" name="is_new[]" value="0">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm {{ $errors->has('no_of_units.*') ? 'is-invalid': NULL  }}" name="no_of_units[]" value="{{ old('no_of_units[]') }}" placeholder="{{ $errors->first('no_of_units.*') }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm {{ $errors->has('amount.*') ? 'is-invalid': NULL  }}" name="amount[]" value="{{ old('amount[]', $item->gross_sales) }}" placeholder="{{ $errors->first('amount.*') }}">
                                                    </td>
                                                    <td>
                                                        {{-- <button type="button" class="btn btn-danger bt-primary btn-remove">Remove</button> --}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{-- <button class="btn btn-light btn-sm" id="repeater_add_activity" type="button"><i class="fa fa-plus mr-2"></i>Add Line of Business</button> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <th class="text-title">Requirement Name</th>
                                                <th class="text-title" class="text-wrap">File <span class="text-danger">*</span></th>
                                            </thead>
                                            {{-- <tr>
                                                <td>BN Certificate</td>
                                                <td>
                                                    <input type="file" name="file[bn_certificate]" class="text-wrap" accept="image/x-png,image/gif,image/jpeg,application/pdf">
                                                    @if($errors->first('file'))
                                                    <p class="help-block text-danger">{{$errors->first('file')}}</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Barangay Clearance</td>
                                                <td>
                                                    <input type="file" name="file[brgy_clearance]" class="text-wrap" accept="image/x-png,image/gif,image/jpeg,application/pdf">
                                                    @if($errors->first('file'))
                                                    <p class="help-block text-danger">{{$errors->first('file')}}</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Occupancy Permit</td>
                                                <td>
                                                    <input type="file" name="file[occupancy_permit]" class="text-wrap" accept="image/x-png,image/gif,image/jpeg,application/pdf">
                                                    @if($errors->first('file'))
                                                    <p class="help-block text-danger">{{$errors->first('file')}}</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Land Title (Home based) *If owned</td>
                                                <td>
                                                    <input type="file" name="file[land_title]" class="text-wrap" accept="image/x-png,image/gif,image/jpeg,application/pdf">
                                                    @if($errors->first('file'))
                                                    <p class="help-block text-danger">{{$errors->first('file')}}</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Authorization from Owner *If rent</td>
                                                <td>
                                                    <input type="file" name="file[authorization_owner]" class="text-wrap" accept="image/x-png,image/gif,image/jpeg,application/pdf">
                                                    @if($errors->first('file'))
                                                    <p class="help-block text-danger">{{$errors->first('file')}}</p>
                                                    @endif
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td>Actual Photo of Establishment </td>
                                                <td>
                                                    <input type="file" name="photo_establishment" class="text-wrap" accept="image/x-png,image/gif,image/jpeg">
                                                    @if($errors->first('photo_establishment'))
                                                    <p class="help-block text-danger">{{$errors->first('photo_establishment')}}</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>BIR ITR Form/Financial Statement / Previous year assessment details / Percentage tax/monthly/quarterly returns</td>
                                                <td>
                                                    <input type="file" name="bir_itr_form" class="text-wrap" accept="image/x-png,image/gif,image/jpeg,application/pdf">
                                                    @if($errors->first('bir_itr_form'))
                                                    <p class="help-block text-danger">{{$errors->first('bir_itr_form')}}</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input type="checkbox" name="agree" class="form-check-input" value="{{ old('agree') }}" id="agree">
                                        <label for="checkbox" class="form-check-label">I AGREE UNDER PENALTY OF PERJUARY that the foregoing Information
                                            are based on my personal knowledge and authentic records.Further, I agree to comply with the regulatory requirements and other
                                            deficiencies within 30 days from release of the Business Permit. FAILURE TO COMPLY WITH ALL THE REQUIREMENTS WILL AUTOMATICALLY REVOKE
                                            THE PERMIT
                                        </label>
                                        @if($errors->first('agree'))
                                            <p class="help-block text-danger">{{$errors->first('agree')}}</p>
                                        @endif
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
        @if (session('successmodal') == 1)
        <div class="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <h1 class="text-success text-uppercase">Success</h1>
                            <p style="font-weight: bold">This is to confirm that we have recieved your assessment request. We will process your request and will update you on the status. Thank you!</p>
                            <a href="{{route('web.business.history',[$business->id])}}" class="btn btn-light text-success text-uppercase session-forget">Return</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        @endif
    </div>

</section>
<!--team section end-->


@stop
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('system/vendors/select2/select2.min.css')}}"/>
<style type="text/css">
    .is-invalid{
        border: solid 2px;
    }
    .select2-container .select2-selection--single {
      height: 47px !important;
    }
    span.select2.select2-container{
        width: 100% !important;
    }
    span.select2-selection__rendered{
        padding: 10px !important;
    }
    span.select2-selection__arrow{
        top:10px !important;
    }
</style>
@endsection

@section('page-scripts')
<script src="{{asset('system/vendors/select2/select2.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
    var line_of_businesses = null;

    $('.session-forget').click(function (){
        {{ session()->forget('successmodal') }}
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

    $.fn.get_line_of_business = function(){
      $.get("{{env('OBOSS_UPLOAD_LINE_OF_BUSINESS')}}", function( data ) {
        line_of_businesses = data.data;
      });
    }
     $(function(){
        $(this).get_line_of_business();
        $('.modal').modal('show');
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
        $('.type_of_application').val('{{ session('application.transaction_type') }}');

        $('#repeater_add_activity').on('click', function(){
            var list_of_lob = '<option>Select Line of Business</option>';
            $.each(line_of_businesses,function(index,value){
                var code = value.Class+"---"+value.RefCode+'---'+value.BClass+"---"+value.SClass+"---"+(value.XClass ? value.XClass:"0")+"---"+value.AcctCode+"---"+value.Particulars;
                list_of_lob += `<option value="${code}">${value.Class}</option>`;
            })
            var repeat_item = `<tr id="repeat_form" class="activity">
                                    <td>
                                        <select class="select-line-of-business form-control form-control-sm classic {{ $errors->has('account_code.*') ? 'is-invalid': NULL  }}" name="account_code[]" value="{{ old('account_code[]') }}" placeholder="{{ $errors->first('account_code.*') }}">
                                            ${list_of_lob}
                                        </select>
                                        <input type="text" class="form-control form-control-sm mt-3" name="line_of_business[]" placeholder="Enter Particular">
                                        <input type="hidden" class="form-control form-control-sm" name="is_new[]" value="1">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm {{ $errors->has('no_of_units.*') ? 'is-invalid': NULL  }}" name="no_of_units[]" value="0" placeholder="{{ $errors->first('no_of_units.*') }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm {{ $errors->has('amount.*') ? 'is-invalid': NULL  }}" name="amount[]" value="{{ old('amount[]') }}" placeholder="{{ $errors->first('amount.*') }}">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger bt-primary btn-remove">Remove</button>
                                    </td>
                                </tr>`;
            $("#businessline_tbody").append(repeat_item);
            $('.select-line-of-business').select2();
        });

        $("#businessline_tbody").delegate(".btn-remove","click",function(){
            var parent_div = $(this).parents(".activity");
            parent_div.remove();
        });

        $('#agree').click(function () {
            $(this).val(1);
        })
    })
</script>
@endsection
