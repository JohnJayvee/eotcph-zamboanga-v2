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
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('application_no') ? 'is-invalid': NULL  }}"  name="application_no" value="{{old('application_no') }}">
                                        @if($errors->first('application_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('application_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business ID. No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('business_id_no') ? 'is-invalid': NULL  }}"  name="business_id_no" value="{{old('business_id_no', $business->business_id_no) }}">
                                        @if($errors->first('business_id_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_id_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="text-form pb-2">Type of Application</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input application_type" name="application_type" value="new" checked>New
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input application_type" name="application_type" value="renew">Renew
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input application_type" name="application_type" value="additional">Additional
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="checkbox" class="form-check-input application_type" name="application_type" value="transfer">Transafer
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
                                                $(".application_type").prop('checked',false);
                                                $(this).prop('checked',true);
                                                if($(this).val() == 'transfer'){
                                                    $('#transfer').show();
                                                } else {
                                                    $('#transfer').hide();
                                                }

                                                if($(this).val() == 'renew'){
                                                    $('.renew').show();
                                                    $('.new').hide();
                                                } else {
                                                    $('.renew').hide();

                                                }
                                                if($(this).val() == 'new'){
                                                    $('.new').show();
                                                    $('.renew').hide();
                                                }
                                            });

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
                                        <input type="date" class="form-control form-control-sm {{ $errors->first('application_date') ? 'is-invalid': NULL  }}"  name="application_date" value="{{old('application_date') }}">
                                        @if($errors->first('application_date'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('application_date')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">DTI/SEC/CDA registration No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('dti_sec_cda_registration_no') ? 'is-invalid': NULL  }}"  name="dti_sec_cda_registration_no" value="{{old('dti_sec_cda_registration_no') }}">
                                        @if($errors->first('dti_sec_cda_registration_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('dti_sec_cda_registration_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">DTI/SEC/CDA registration Date</label>
                                        <input type="date" class="form-control form-control-sm {{ $errors->first('dti_sec_cda_registration_date') ? 'is-invalid': NULL  }}"  name="dti_sec_cda_registration_date" value="{{old('dti_sec_cda_registration_date') }}">
                                        @if($errors->first('dti_sec_cda_registration_date'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('dti_sec_cda_registration_date')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">CTC No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('ctc_no') ? 'is-invalid': NULL  }}"  name="ctc_no" value="{{old('ctc_no') }}">
                                        @if($errors->first('ctc_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('ctc_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business TIN.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('business_tin') ? 'is-invalid': NULL  }}"  name="business_tin" value="{{old('business_tin') }}">
                                        @if($errors->first('business_tin'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_tin')}}</small>
                                        @endif
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Frequency of Payment</label>
                                        <select name="frequency_of_payment" id="" class="form-control">
                                            <option value="Annualy">Annualy</option>
                                            <option value="semi-annually">Semi-Annually</option>
                                            <option value="quarterly">Quarterly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="text-form pb-2">Are you enjoying tax incentive from any Goverment Entity?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-control form-control-sm" type="checkbox" name="checkbox" value="yes" style="width: 30px; height: 30px;">
                                            <label class="my-2 mx-1" for="inlineCheckbox1">YES</label>
                                            {{-- <small class="my-2" for="inlineCheckbox3">Please Specify entity:</small> --}}
                                        </div>
                                        <script>
                                            $(function(){
                                                $('input[name="checkbox"]').on('change', function () {
                                                    $('input[name="checkbox"]').not(this).prop('checked', false);
                                                    if($(this).val() == 'yes'){
                                                        $('input[name="tax_incentive"]').val('');
                                                        $('#checkYes').show();
                                                    }
                                                    if($(this).val() == 'no'){
                                                        $('#checkYes').hide();
                                                        $('input[name="tax_incentive"]').val('no');
                                                    }
                                                });
                                            })
                                        </script>
                                        <div class="form-check form-check-inline">
                                            <input class="form-control form-control-sm" type="checkbox" name="checkbox" value="no" style="width: 30px; height: 30px;">
                                            <label class="my-2 mx-1" for="inlineCheckbox3">NO</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="display:none;" id="checkYes">
                                        <label class="text-form pb-2 text-title">Please Specify entity:</label>
                                        <input type="text" class="form-control form-control-sm" name="tax_incentive">
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
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('trade_name') ? 'is-invalid': NULL  }}"  name="trade_name" value="{{old('trade_name') }}">
                                        @if($errors->first('trade_name'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('trade_name')}}</small>
                                        @endif
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
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('rep_lastname') ? 'is-invalid': NULL  }}"  name="rep_lastname" value="{{old('rep_lastname') }}">
                                        @if($errors->first('rep_lastname'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('rep_lastname')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">First Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('rep_firstname') ? 'is-invalid': NULL  }}"  name="rep_firstname" value="{{old('rep_firstname') }}">
                                        @if($errors->first('rep_firstname'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('rep_firstname')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Middle Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('rep_middlename') ? 'is-invalid': NULL  }}"  name="rep_middlename" value="{{old('rep_middlename') }}">
                                        @if($errors->first('rep_middlename'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('rep_middlename')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Gender</label>
                                        <select name="rep_gender" id="" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Position</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('rep_position') ? 'is-invalid': NULL  }}"  name="rep_position" value="{{old('rep_position') }}">
                                        @if($errors->first('rep_position'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('rep_position')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">TIN</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('rep_tin') ? 'is-invalid': NULL  }}"  name="rep_tin" value="{{old('rep_tin') }}">
                                        @if($errors->first('rep_tin'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('rep_tin')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Business Address</h5>
                            <input type="hidden" class="form-control" name="business_region_name" id="input_region_name" value="{{old('business_region_name')}}">
                            <input type="hidden" class="form-control" name="business_town_name" id="input_town_name" value="{{old('business_town_name')}}">
                            <input type="hidden" class="form-control" name="business_brgy_name" id="input_brgy_name" value="{{old('business_brgy_name')}}">
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
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('business_area') ? 'is-invalid': NULL  }}"  name="business_area" value="{{old('business_area',$auth->telephone_no) }}">
                                        @if($errors->first('business_area'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_area')}}</small>
                                        @endif
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
                                        <p class="form-data text-success">{{ $auth->unit_no }}</p>
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
                                        <p class="form-data text-success">{{ $auth->email }}</p>
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
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('lessor_monthly_rental') ? 'is-invalid': NULL  }}"  name="lessor_monthly_rental" value="{{old('lessor_monthly_rental',$auth->telephone_no) }}">
                                        @if($errors->first('lessor_monthly_rental'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_monthly_rental')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Start Date of Rental (MM/DD/YYYY)</label>
                                        <input type="date" class="form-control form-control-sm {{ $errors->first('lessor_rental_date') ? 'is-invalid': NULL  }}"  name="lessor_rental_date" value="{{old('lessor_rental_date',$auth->telephone_no) }}">
                                        @if($errors->first('lessor_rental_date'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_rental_date')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Name of Lessor / Corporation</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('lessor_fullname') ? 'is-invalid': NULL  }}"  name="lessor_fullname" value="{{old('lessor_fullname',$auth->telephone_no) }}">
                                        @if($errors->first('lessor_fullname'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_fullname')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Gender</label>
                                        <select name="lessor_gender" id="" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputEmail1" class="text-form pb-2">Region</label>
                                        {!!Form::select('region',[],old('region'),['id' => "input_region",'class' => "form-control form-control-sm classic ".($errors->first('lessor_region') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('lessor_region'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_region')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">City Municipality</label>
                                        {!!Form::select('town',[],old('lessor_town'),['id' => "input_town",'class' => "form-control form-control-sm classic ".($errors->first('lessor_town') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('lessor_town'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_town')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay</label>
                                        {!!Form::select('brgy',[],old('lessor_brgy'),['id' => "input_brgy",'class' => "form-control form-control-sm classic ".($errors->first('lessor_brgy') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('lessor_brgy'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_brgy')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="input_zipcode" class="text-form pb-2">Zipcode</label>
                                        <input type="text" id="input_zipcode" class="form-control form-control-sm  {{ $errors->first('lessor_zipcode') ? 'is-invalid': NULL  }}" name="lessor_zipcode" value="{{old('lessor_zipcode')}}" readonly="readonly">
                                        @if($errors->first('lessor_zipcode'))
                                        <p class="help-block text-danger">{{$errors->first('lessor_zipcode')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">House/Bldg No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('lessor_unit_no') ? 'is-invalid': NULL  }}"  name="lessor_unit_no" value="{{old('lessor_unit_no') }}">
                                        @if($errors->first('lessor_unit_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_unit_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Street Address</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('lessor_street_address') ? 'is-invalid': NULL  }}"  name="lessor_street_address" value="{{old('lessor_street_address') }}">
                                        @if($errors->first('lessor_street_address'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_street_address')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('lessor_email') ? 'is-invalid': NULL  }}"  name="lessor_email" value="{{old('lessor_email',$auth->email) }}">
                                        @if($errors->first('lessor_email'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_email')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Mobile Number</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('lessor_mobile_no') ? 'is-invalid': NULL  }}"  name="lessor_mobile_no" value="{{old('lessor_mobile_no',$auth->mobile_no) }}">
                                        @if($errors->first('lessor_mobile_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_mobile_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Telephone Number</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('lessor_tel_no') ? 'is-invalid': NULL  }}"  name="lessor_tel_no" value="{{old('lessor_tel_no',$auth->telephone_no) }}">
                                        @if($errors->first('lessor_tel_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_tel_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-title text-uppercase">Incase of Emergency</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Contact Person</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('emergency_contact_fullname') ? 'is-invalid': NULL  }}"  name="emergency_contact_fullname" value="{{old('emergency_contact_fullname',$auth->telephone_no) }}">
                                        @if($errors->first('emergency_contact_fullname'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('emergency_contact_fullname')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Tel. No</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('emergency_contact_tel_no') ? 'is-invalid': NULL  }}"  name="emergency_contact_tel_no" value="{{old('emergency_contact_tel_no',$auth->telephone_no) }}">
                                        @if($errors->first('emergency_contact_tel_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('emergency_contact_tel_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Mobile No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('emergency_contact_mobile_no') ? 'is-invalid': NULL  }}"  name="emergency_contact_mobile_no" value="{{old('emergency_contact_mobile_no',$auth->telephone_no) }}">
                                        @if($errors->first('emergency_contact_mobile_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('emergency_contact_mobile_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email Address</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('emergency_contact_email') ? 'is-invalid': NULL  }}"  name="emergency_contact_email" value="{{old('emergency_contact_email',$auth->telephone_no) }}">
                                        @if($errors->first('emergency_contact_email'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('emergency_contact_email')}}</small>
                                        @endif
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
                                            <tbody>
                                                @foreach (range(0,3) as $item)
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" name="line_of_business[]">
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
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <th class="text-title">Requirment Name</th>
                                                <th class="text-title">File</th>
                                            </thead>
                                            <tr>
                                                <td>BN Certificate</td>
                                                <td><input type="file"></td>
                                            </tr>
                                            <tr>
                                                <td>Barangay Clearance</td>
                                                <td><input type="file"></td>
                                            </tr>
                                            <tr>
                                                <td>Occupancy Permit</td>
                                                <td><input type="file"></td>
                                            </tr>
                                            <tr>
                                                <td>Land Title (Home based) *If owned</td>
                                                <td><input type="file"></td>
                                            </tr>
                                            <tr>
                                                <td>Authorization from Owner *If rent</td>
                                                <td><input type="file"></td>
                                            </tr>
                                            <tr>
                                                <td>Actual Photo of Establishment</td>
                                                <td><input type="file"></td>
                                            </tr>
                                            <tr>
                                                <td>BIR ITR Form</td>
                                                <td><input type="file"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn badge-primary-2 text-white" style="float: right;">Apply</button>
                            <a href="{{route('web.business.index')}}" class="btn btn-light mr-2" style="float: right;">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</section>
<!--team section end-->


@stop

@section('page-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
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

    })
</script>
@endsection
