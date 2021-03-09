@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    @include('system._components.notifications')
                    @if($errors->first('valid_business'))
                        <small class="form-text pl-1" style="color:red;">{{$errors->first('valid_business')}}asdsadsads</small>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <form method="get" action="{{ route('web.business.create') }}">
                                <h5 class="text-title text-uppercase">Business ID No. </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="text-form pb-2">Business ID No. <span class="text-danger">* </span> <a href="#myModal" role="button" class="text-info" data-toggle="modal">To know where your BusinessID No. is click here</a>
                                            <input type="hidden" class="form-control"  name="permit_no" value="{{old('permit_no', $business['PermitNo'] ?? '') }}">
                                            <input type="hidden" class="form-control"  name="business_plate_no" value="{{old('business_plate_no', $business['BusinessPlateNo'] ?? '') }}">

                                            <input type="number" class="form-control form-control-sm {{ $errors->first('business_id_no') ? 'is-invalid': NULL  }}"  name="business_id_no" value="{{old('business_id_no', $business['BusinessID'] ?? '') }}" required>
                                            <span class="text-info"><small>Please make sure that your BID is correct. You can't undo this action.</small></span>
                                            @if($errors->first('business_id_no'))
                                                <small class="form-text pl-1" style="color:red;">{{$errors->first('business_id_no')}}</small>
                                            @endif
                                            @if($errors->first('BusinessID'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('BusinessID')}}</small>
                                            @endif
                                            <button type="submit" class="btn badge-primary-2 text-white mr-2" style="float: right;">Validate</button>
                                        </div>

                                        @if (session('negativelist') == 1)
                                        <div class="modal modal_negative">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body d-flex flex-column">
                                                        <div class="row mx-auto">
                                                            <i class="fas fa-exclamation-triangle fa-5x text-danger text-center"></i>
                                                            <br>
                                                        </div>
                                                        <h3>Oops, sorry! Your Business ID is in our Negative List. Please contact the BPLO Office for further concerns.</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <script>
                                            $(function() {
                                                $('.modal_negative').modal('show');
                                            })
                                        </script>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="create-form" method="POST" action="{{ route('web.business.create') }}" enctype="multipart/form-data">
                            {!!csrf_field()!!}
                            <input type="hidden" name="business_id_no" value="{{  old('business_id_no' ,( $business['BusinessID'] ?? '') )}}">
                            <input type="hidden" name="valid_business" class="form-control form-control-sm {{ $errors->first('valid_business') ? 'is-invalid': NULL  }}" value="{{ session('status_code') ?? '' }}">
                            @if($errors->first('valid_business'))
                                <small class="form-text pl-1" style="color:red;">{{$errors->first('valid_business')}}</small>
                            @endif
                            <h5 class="text-title text-uppercase">Business Information</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Scope <span class="text-danger">*</span></label>
                                        {!!Form::select("business_scope", $business_scopes, old('business_scope'), ['id' => "input_business_scope", 'class' => "form-control form-control-sm classic ".($errors->first('business_scope') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('business_scope'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_scope')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Type <span class="text-danger">*</span></label>
                                        {!!Form::select("business_type", $business_types, old('business_type' , (!empty($business_type_f) ? $business_type_f : null)), ['id' => "input_business_type", !empty($business_type_f) ? 'disabled' : '','class' => "form-control form-control-sm classic".($errors->first('business_type') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('business_type'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_type')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Dominant Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('dominant_name') ? 'is-invalid': NULL  }}"  name="dominant_name" value="{{old('dominant_name', $business['BusinessName'] ?? '') }}">
                                        @if($errors->first('dominant_name'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('dominant_name')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('business_name') ? 'is-invalid': NULL  }}"  name="business_name" value="{{old('business_name', $business['BusinessName'] ?? '') }}">
                                        @if($errors->first('business_name'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_name')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Trade name / Franchise <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('trade_name') ? 'is-invalid': NULL  }}"  name="trade_name" value="{{old('trade_name', $business['TradeName'] ?? '') }}">
                                        @if($errors->first('trade_name'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('trade_name')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">DTI/SEC/CDA registration No. <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('dti_sec_cda_registration_no') ? 'is-invalid': NULL  }}"  name="dti_sec_cda_registration_no" value="{{old('dti_sec_cda_registration_no') }}">
                                        @if($errors->first('dti_sec_cda_registration_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('dti_sec_cda_registration_no')}}</small>
                                        @endif
                                        @if (session()->has('bnn-error'))
                                            <small class="form-text pl-1" style="color:red;">{{ session('bnn-error') }}</small>
                                        @endif
                                        <p class="text-right text-primary"><a href="https://bnrs.dti.gov.ph/registration" target="_blank">Not yet registered to DTI? click here.</a></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">DTI/SEC/CDA registration Date <span class="text-danger">*</span></label>
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
                                        <label for="exampleInputEmail1" class="text-form pb-2">Cedula No.<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('ctc_no') ? 'is-invalid': NULL  }}"  name="ctc_no" value="{{old('ctc_no', $business['CTCNo'] ?? '' ) }}">
                                        @if($errors->first('ctc_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('ctc_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business TIN.<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm {{ $errors->first('business_tin') ? 'is-invalid': NULL  }}"  name="business_tin" value="{{old('business_tin', $business['TIN'] ?? '') }}">
                                        @if($errors->first('business_tin'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_tin')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="text-form pb-2 col-md-6">Are you enjoying tax incentive from any Goverment Entity?</label>
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
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Business Area (Sq. m) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm {{ $errors->first('business_area') ? 'is-invalid': NULL  }}"  name="business_area" value="{{old('business_area', $business['BusArea'] ?? '') }}">
                                        @if($errors->first('business_area'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('business_area')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="input_no_male_employee" class="text-form pb-2">Total No. of Male Employees <span class="text-danger">*</span></label>
										<input type="number" id="input_no_male_employee" class="form-control {{ $errors->first('no_male_employee') ? 'is-invalid': NULL  }}" name="no_male_employee" value="{{old('no_male_employee')}}">
										@if($errors->first('no_male_employee'))
										<p class="help-block text-danger">{{$errors->first('no_male_employee')}}</p>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="input_male_residing_in_city" class="text-form pb-2">No. of Male Employees Residing In City <span class="text-danger">*</span></label>
										<input type="number" id="input_male_residing_in_city" class="form-control {{ $errors->first('male_residing_in_city') ? 'is-invalid': NULL  }}" name="male_residing_in_city" value="{{old('male_residing_in_city')}}">
										@if($errors->first('male_residing_in_city'))
										<p class="help-block text-danger">{{$errors->first('male_residing_in_city')}}</p>
										@endif
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="input_no_female_employee" class="text-form pb-2">Total No. of Female Employees <span class="text-danger">*</span></label>
										<input type="number" id="input_no_female_employee" class="form-control {{ $errors->first('no_female_employee') ? 'is-invalid': NULL  }}" name="no_female_employee" value="{{old('no_female_employee')}}">
										@if($errors->first('no_female_employee'))
										<p class="help-block text-danger">{{$errors->first('no_female_employee')}}</p>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="input_female_residing_in_city" class="text-form pb-2">No. of Female Employees Residing In City <span class="text-danger">*</span></label>
										<input type="number" id="input_female_residing_in_city" class="form-control {{ $errors->first('female_residing_in_city') ? 'is-invalid': NULL  }}" name="female_residing_in_city" value="{{old('female_residing_in_city')}}">
										@if($errors->first('female_residing_in_city'))
										<p class="help-block text-danger">{{$errors->first('female_residing_in_city')}}</p>
										@endif
									</div>
								</div>
							</div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Capitalization <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control form-control-sm {{ $errors->first('capitalization') ? 'is-invalid': NULL  }}"  name="capitalization" value="{{old('capitalization') }}">
                                        @if($errors->first('capitalization'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('capitalization')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="region_name" id="input_region_name" value="{{old('region_name', 'REGION IX (ZAMBOANGA PENINSULA)')}}">
                            <input type="hidden" class="form-control" name="town_name" id="input_town_name" value="{{old('town_name', 'ZAMBOANGA DEL SUR - CITY OF ZAMBOANGA')}}">
                            <input type="hidden" class="form-control" name="brgy_name" id="input_brgy_name" value="{{old('brgy_name')}}">

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="exampleInputEmail1" class="text-form pb-2">Region <span class="text-danger">*</span></label>
                                       {!!Form::select('region',[],old('region'),['id' => "input_region",'class' => "form-control form-control-sm classic ".($errors->first('region') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('region'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('region')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">City Municipality <span class="text-danger">*</span></label>
                                        {!!Form::select('town',[],old('town'),['id' => "input_town",'class' => "form-control form-control-sm classic ".($errors->first('town') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('town'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('town')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay <span class="text-danger">*</span></label>
                                        {!!Form::select('brgy',[],old('brgy'),['id' => "input_brgy",'class' => "form-control form-control-sm classic ".($errors->first('brgy') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('brgy'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('brgy')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="input_zipcode" class="text-form pb-2">Zipcode <span class="text-danger">*</span></label>
                                        <input type="text" id="input_zipcode" class="form-control form-control-sm  {{ $errors->first('zipcode') ? 'is-invalid': NULL  }}" name="zipcode" value="{{old('zipcode')}}" readonly="readonly">
                                        @if($errors->first('zipcode'))
                                        <p class="help-block text-danger">{{$errors->first('zipcode')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">House/Bldg No. <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('unit_no') ? 'is-invalid': NULL  }}"  name="unit_no" value="{{old('unit_no'), ($business['BusBldgName'] ?? '').' '.($business['BusBldgNo'] ?? '')}}">
                                        @if($errors->first('unit_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('unit_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Street Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('street_address') ? 'is-invalid': NULL  }}"  name="street_address" value="{{old('street_address', $business['BusStreet'] ?? '') }}">
                                        @if($errors->first('street_address'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('street_address')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control form-control-sm {{ $errors->first('email') ? 'is-invalid': NULL  }}"  name="email" value="{{old('email', $business['BusEmailAddress'] ?? '') }}">
                                        @if($errors->first('email'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('email')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <!-- <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Website (URL)</label>
                                        <input type="url" class="form-control form-control-sm {{ $errors->first('website_url') ? 'is-invalid': NULL  }}"  name="website_url" value="{{old('website_url', $business['BusWebsite'] ?? '') }}">
                                        @if($errors->first('website_url'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('website_url')}}</small>
                                        @endif
                                    </div>
                                </div> -->
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Mobile Number <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-title fw-600">+63 <span class="pr-1 pl-2" style="padding-bottom: 2px"> |</span></span>
                                            </div>
                                            <input type="number" class="form-control {{ $errors->first('mobile_no') ? 'is-invalid': NULL  }} br-left-white" name="mobile_no" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="Contact Number" value="{{old('mobile_no', $business['BusTelNo'] ?? '')}}">

                                        </div>
                                        @if($errors->first('mobile_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('mobile_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Telephone Number</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('telephone_no') ? 'is-invalid': NULL  }}"  name="telephone_no" value="{{old('telephone_no') }}">
                                        @if($errors->first('telephone_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('telephone_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="lessor_region_name" id="input_lessor_region_name" value="{{old('lessor_region_name', 'REGION IX (ZAMBOANGA PENINSULA)')}}">
                            <input type="hidden" class="form-control" name="lessor_town_name" id="input_lessor_town_name" value="{{old('lessor_town_name', 'ZAMBOANGA DEL SUR - CITY OF ZAMBOANGA')}}">
                            <input type="hidden" class="form-control" name="lessor_brgy_name" id="input_lessor_brgy_name" value="{{old('lessor_brgy_name')}}">

                            <h5 class="text-title text-uppercase">Owners Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">First Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('owner_firstname') ? 'is-invalid': NULL  }}"  name="owner_firstname" value="{{old('owner_firstname', $business['FirstName'] ?? '') }}" autocomplete="none">
                                        @if($errors->first('owner_firstname'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_firstname')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Middle Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('owner_middlename') ? 'is-invalid': NULL  }}"  name="owner_middlename" value="{{old('owner_middlename', $business['MiddleName'] ?? '') }}" autocomplete="none">
                                        @if($errors->first('owner_middlename'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_middlename')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Last Name</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('owner_lastname') ? 'is-invalid': NULL  }}"  name="owner_lastname" value="{{old('owner_lastname', $business['LastName'] ?? '') }}" autocomplete="none">
                                        @if($errors->first('owner_lastname'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_lastname')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Owner TIN</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('owner_tin') ? 'is-invalid': NULL  }}"  name="owner_tin" value="{{old('owner_tin' , $business['OwnerTIN'] ?? '') }}" autocomplete="none">
                                        @if($errors->first('owner_tin'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_tin')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email </label>
                                        <input type="email" class="form-control form-control-sm {{ $errors->first('owner_email') ? 'is-invalid': NULL  }}"  name="owner_email" value="{{old('owner_email', $business['OwnerEmailAddress'] ?? '') }}" autocomplete="none">
                                        @if($errors->first('owner_email'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_email')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Mobile Number </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-title fw-600">+63 <span class="pr-1 pl-2" style="padding-bottom: 2px"> |</span></span>
                                            </div>
                                            <input type="number" class="form-control {{ $errors->first('owner_mobile_no') ? 'is-invalid': NULL  }} br-left-white" name="owner_mobile_no" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="Contact Number" value="{{old('owner_mobile_no', $business['OwnerTelNo'] ?? '')}}" autocomplete="none">
                                        </div>
                                        @if($errors->first('owner_mobile_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_mobile_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay </label>
                                        {!!Form::select('owner_brgy',[],old('owner_brgy'),['id' => "input_owner_brgy",'class' => "form-control form-control-sm classic ".($errors->first('owner_brgy') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('owner_brgy'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_brgy')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" class="form-control" name="owner_brgy_name" id="input_owner_brgy_name" value="{{old('owner_brgy_name')}}">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Street Address </label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('owner_street') ? 'is-invalid': NULL  }}"  name="owner_street" value="{{old('owner_street', $business['OwnerStreet'] ?? '') }}" autocomplete="none">
                                        @if($errors->first('owner_street'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_street')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">House/Bldg No. </label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('owner_unit_no') ? 'is-invalid': NULL  }}"  name="owner_unit_no" value="{{old('owner_unit_no'), ($business['BusBldgName'] ?? '').' '.($business['BusBldgNo'] ?? '')}}" autocomplete="none">
                                        @if($errors->first('owner_unit_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('owner_unit_no')}}</small>
                                        @endif
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
                                        <input type="number" class="form-control form-control-sm {{ $errors->first('rep_tin') ? 'is-invalid': NULL  }}"  name="rep_tin" value="{{old('rep_tin') }}">
                                        @if($errors->first('rep_tin'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('rep_tin')}}</small>
                                        @endif
                                    </div>
                                </div>
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
                                        {!!Form::select('lessor_region',[],old('lessor_region'),['id' => "input_lessor_region",'class' => "form-control form-control-sm classic ".($errors->first('lessor_region') ? 'border-red' : NULL)])!!}
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
                                        {!!Form::select('lessor_town',[],old('lessor_town'),['id' => "input_lessor_town",'class' => "form-control form-control-sm classic ".($errors->first('lessor_town') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('lessor_town'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_town')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Barangay</label>
                                        {!!Form::select('lessor_brgy',[],old('lessor_brgy'),['id' => "input_lessor_brgy",'class' => "form-control form-control-sm classic ".($errors->first('lessor_brgy') ? 'border-red' : NULL)])!!}
                                        @if($errors->first('lessor_brgy'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_brgy')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="input_zipcode" class="text-form pb-2">Zipcode</label>
                                        <input type="text" id="input_lessor_zipcode" class="form-control form-control-sm  {{ $errors->first('lessor_zipcode') ? 'is-invalid': NULL  }}" name="lessor_zipcode" value="{{old('lessor_zipcode')}}" readonly="readonly">
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
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email</label>
                                        <input type="email" class="form-control form-control-sm {{ $errors->first('lessor_email') ? 'is-invalid': NULL  }}"  name="lessor_email" value="{{old('lessor_email') }}">
                                        @if($errors->first('lessor_email'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('lessor_email')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Mobile Number</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-title fw-600">+63 <span class="pr-1 pl-2" style="padding-bottom: 2px"> |</span></span>
                                            </div>
                                            <input type="number" class="form-control {{ $errors->first('lessor_mobile_no') ? 'is-invalid': NULL  }} br-left-white" name="lessor_mobile_no" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="Contact Number" value="{{old('lessor_mobile_no')}}">

                                        </div>
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
                                        <label class="text-form pb-2">Mobile Number</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-title fw-600">+63 <span class="pr-1 pl-2" style="padding-bottom: 2px"> |</span></span>
                                            </div>
                                            <input type="number" class="form-control {{ $errors->first('emergency_contact_mobile_no') ? 'is-invalid': NULL  }} br-left-white" name="emergency_contact_mobile_no" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="Contact Number" value="{{old('emergency_contact_mobile_no')}}">

                                        </div>
                                        @if($errors->first('emergency_contact_mobile_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('emergency_contact_mobile_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Email Address</label>
                                        <input type="email" class="form-control form-control-sm {{ $errors->first('emergency_contact_email') ? 'is-invalid': NULL  }}"  name="emergency_contact_email" value="{{old('emergency_contact_email',$auth->telephone_no) }}">
                                        @if($errors->first('emergency_contact_email'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('emergency_contact_email')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            	<div class="col-md-12" id="repeat_form">
                                    @if ((!empty($lob)))
                                        <div class="row activity">
                                            @foreach ($lob as $key => $item)
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="text-form pb-2">Line of Business {{ $key }}</label>
                                                    <input type="text" class="form-control form-control-sm {{ $errors->first("business_line.{$key}") ? 'is-invalid': NULL  }}"  name="business_line[]" value="{{ $item }}" readonly>
                                                    @if($errors->first("business_line.{$key}"))
                                                        <small class="form-text pl-1" style="color:red;">{{$errors->first("business_line.{$key}")}}</small>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-title text-uppercase">Other Information Form (Government Owned Or Controlled Corporations)</h5>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">TIN No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('tin_no') ? 'is-invalid': NULL  }}"  name="tin_no" value="{{old('tin_no', $business['BusTIN'] ?? '') }}">
                                        @if($errors->first('tin_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('tin_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">SSS No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('sss_no') ? 'is-invalid': NULL  }}"  name="sss_no" value="{{old('sss_no') }}">
                                        @if($errors->first('sss_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('sss_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">Philhealth No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('philhealth_no') ? 'is-invalid': NULL  }}"  name="philhealth_no" value="{{old('philhealth_no') }}">
                                        @if($errors->first('philhealth_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('philhealth_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="text-form pb-2">PAGIBIG No.</label>
                                        <input type="text" class="form-control form-control-sm {{ $errors->first('pagibig_no') ? 'is-invalid': NULL  }}"  name="pagibig_no" value="{{old('pagibig_no') }}">
                                        @if($errors->first('pagibig_no'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('pagibig_no')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <a href="{{route('web.business.index')}}" class="btn btn-light" style="float: right;">Cancel</a>
                            <button type="submit" class="btn badge-primary-2 text-white mr-2" style="float: right;">Create Record</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

</section>
<!--team section end-->
<div class="modal fade bd-example-modal-lg show" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="dynamic-content">
                <img src="{{asset('web/img/guide.jpg')}}" width="100%">
            </div>
        </div>
    </div>
</div>

@stop
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('system/vendors/select2/select2.min.css')}}"/>
<style type="text/css">
  .is-invalid{
    border: solid 2px;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice{
    font-size: 18px;
  }
  span.select2.select2-container{
    width: 100% !important;
  }
</style>
@endsection

@section('page-scripts')
<script src="{{asset('system/vendors/select2/select2.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
    $.fn.get_region = function (input_region, input_province, input_city, input_brgy, selected) {

        $(input_city).empty().prop('disabled', true)
        $(input_brgy).empty().prop('disabled', true)

        $(input_region).append($('<option>', {
            value: "",
            text: "Loading Content..."
        }));
        $.getJSON("{{env('PSGC_REGION_URL')}}", function (response) {
            $(input_region).empty().prop('disabled', true)
            $.each(response.data, function (index, value) {
                $(input_region).append($('<option>', {
                    value: index,
                    text: value
                }));
            })

            $(input_region).prop('disabled', true)
            $(input_region).prepend($('<option>', {
                value: "",
                text: "--Select Region--"
            }))
            if (selected.length > 0) {
                $(input_region).val($(input_region + " option[value=" + selected + "]").val());
            } else {
                $(input_region).val($(input_region + " option:first").val());
            }
        });
        // return result;
    };

    $.fn.get_city = function (reg_code, input_city, input_brgy, selected) {
        $(input_brgy).empty().prop('disabled', true)
        $(input_city).append($('<option>', {
            value: "",
            text: "Loading Content..."
        }));
        $.getJSON("{{env('PSGC_CITY_URL')}}?region_code=" + reg_code, function (data) {
            console.log(data)
            $(input_city).empty().prop('disabled', true)
            $.each(data, function (index, value) {
                $(input_city).append($('<option>', {
                    value: index,
                    text: value
                }));
            })

            $(input_city).prop('disabled', true)
            $(input_city).prepend($('<option>', {
                value: "",
                text: "--SELECT MUNICIPALITY/CITY, PROVINCE--"
            }))
            if (selected.length > 0) {
                $(input_city).val($(input_city + " option[value=" + selected + "]").val());
            } else {
                $(input_city).val($(input_city + " option:first").val());
            }
        });
        // return result;
    };

    $.fn.get_brgy = function (munc_code, input_brgy, selected) {
        $(input_brgy).empty().prop('disabled', true);
        $(input_brgy).append($('<option>', {
            value: "",
            text: "Loading Content..."
        }));
        $.getJSON("{{env('PSGC_BRGY_URL')}}?city_code=" + munc_code, function (data) {
            $(input_brgy).empty().prop('disabled', true);

            $.each(data, function (index, value) {
                $(input_brgy).append($('<option>', {
                    value: index,
                    text: value.desc,
                    "data-zip_code": (value.zip_code).trim()
                }));
            })
            $(input_brgy).prop('disabled', false)
            $(input_brgy).prepend($('<option>', {
                value: "",
                text: "--SELECT BARANGAY--"
            }))

            if (selected.length > 0) {
                $(input_brgy).val($(input_brgy + " option[value=" + selected + "]").val());

                if (typeof $(input_brgy + " option[value=" + selected + "]").data('zip_code') === undefined) {
                    $(input_brgy.replace("brgy", "zipcode")).val("")
                } else {
                    $(input_brgy.replace("brgy", "zipcode")).val($(input_brgy + " option[value=" + selected + "]").data('zip_code'))
                }

            } else {
                $(input_brgy).val($(input_brgy + " option:first").val());
            }
        });
    }

    $(function () {
        $('.create-form').on('submit', function() {
            $('#input_business_type').prop('disabled', false);
        });

        load_barangay();
        $(this).get_region("#input_region", "#input_province", "#input_town", "#input_brgy", "{{old('region', '090000000')}}")
        $(this).get_city("090000000", "#input_town", "#input_brgy", "{{old('town', '097332000')}}");

        $("#input_region").on("change", function () {
            var _val = $(this).val();
            var _text = $("#input_region option:selected").text();
            $(this).get_city($("#input_region").val(), "#input_town", "#input_brgy", "{{old('town')}}");
            $('#input_zipcode').val('');
            $('#input_region_name').val(_text);
        });

        $("#input_town").on("change", function () {
            var _val = $(this).val();
            var _text = $("#input_town option:selected").text();
            $(this).get_brgy(_val, "#input_brgy", "");
            $('#input_zipcode').val('');
            $('#input_town_name').val(_text);
        });

        function load_barangay() {
            var _val = "097332000";
            var _text = "ZAMBOANGA DEL SUR - CITY OF ZAMBOANGA";
            $(this).get_brgy(_val, "#input_brgy", "");
            $(this).get_brgy(_val, "#input_owner_brgy", "");
            $('#input_zipcode').val('');
            $('#input_town_name').val(_text);
        }

        @if(strlen(old('region')) > 0)
        $(this).get_city("{{old('region')}}", "#input_town", "#input_brgy", "{{old('town')}}");
        @endif

        @if(strlen(old('town')) > 0)
        $(this).get_brgy("{{old('town')}}", "#input_brgy", "{{old('brgy')}}");
        @endif

        $("#input_brgy").on("change", function () {
            $('#input_zipcode').val($(this).find(':selected').data('zip_code'))
            var _text = $("#input_brgy option:selected").text();
            $('#input_brgy_name').val(_text);
        });

        $("#input_owner_brgy").on("change", function () {
            var _text = $("#input_owner_brgy option:selected").text();
            $('#input_owner_brgy_name').val(_text);
        });

    })

    $(function(){

        $('#buttonID').click(function(){
            alert('click');
        })
        // Lessor
        load_lessor_barangay();
        $(this).get_region("#input_lessor_region", "#input_lessor_province", "#input_lessor_town", "#input_lessor_brgy", "{{old('lessor_region', '090000000')}}")
        $(this).get_city("090000000", "#input_lessor_town", "#input_lessor_brgy", "{{old('lessor_town', '097332000')}}");

        $("#input_lessor_region").on("change", function () {
            var _val = $(this).val();
            var _text = $("#input_lessor_region option:selected").text();
            $(this).get_city('090000000', "#input_lessor_town", "#input_lessor_brgy", "{{old('lessor_town')}}");
            $('#input_lessor_zipcode').val('');
            $('#input_lessor_region_name').val(_text);
        });

        $("#input_lessor_town").on("change", function () {
            var _val = $(this).val();
            var _text = $("#input_lessor_town option:selected").text();
            $(this).get_brgy(_val, "#input_lessor_brgy", "");
            $('#input_lessor_zipcode').val('');
            $('#input_lessor_town_name').val(_text);
        });

        function load_lessor_barangay() {
            var _val = "097332000";
            var _text = "ZAMBOANGA DEL SUR - CITY OF ZAMBOANGA";
            $(this).get_brgy(_val, "#input_lessor_brgy", "");
            $('#input_lessor_zipcode').val('');
            $('#input_lessor_town_name').val(_text);
        }

        @if(strlen(old('lessor_region')) > 0)
        $(this).get_city("{{old('lessor_region')}}", "#input_lessor_town", "#input_lessor_brgy", "{{old('lessor_town')}}");
        @endif

        @if(strlen(old('lessor_town')) > 0)
        $(this).get_brgy("{{old('lessor_town')}}", "#input_lessor_brgy", "{{old('lessor_brgy')}}");
        @endif

        $("#input_lessor_brgy").on("change", function () {
            $('#input_lessor_zipcode').val($(this).find(':selected').data('zip_code'))
            var _text = $("#input_lessor_brgy option:selected").text();
            $('#input_lessor_brgy_name').val(_text);
        });

    })
</script>
@endsection
