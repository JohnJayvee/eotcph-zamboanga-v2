@extends('frontend._layouts.main')

@section('content')
<section class="profile-account-setting">
	<div class="container">
		<div class="account-tabs-setting">
			<div class="row">
				<div class="col-lg-3">
					@include('frontend._components.profile-sidebar')
				</div>
				<div class="col-lg-9">
					@include('frontend._components.notifications')

			  		<div class="acc-setting">
						<h3>Personal Information Form</h3>
						<form method="POST" action="" id="personal_info_form">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-md-6">
									<div class="form-group {{$errors->first('firstname') ? 'text-danger' : ''}}">
										<label for="">Firstname</label>
										<input type="text" class="form-control" name="firstname" value="{{ old('firstname', $auth->firstname) }}" maxlength="30">
										@if($errors->first('firstname'))
							            	<p class="help-block text-danger">{{$errors->first('firstname')}}</p>
							            @endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group {{$errors->first('middlename') ? 'text-danger' : ''}}">
										<label for="">Middlename</label>
										<input type="text" class="form-control" name="middlename" value="{{ old('middlename', $auth->middlename) }}" maxlength="30">
										@if($errors->first('middlename'))
							            	<p class="help-block text-danger">{{$errors->first('middlename')}}</p>
							            @endif
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group {{$errors->first('lastname') ? 'text-danger' : ''}}">
										<label for="">Lastname</label>
										<input type="text" class="form-control" name="lastname" value="{{ old('lastname', $auth->lastname) }}" maxlength="30">
										@if($errors->first('lastname'))
							            	<p class="help-block text-danger">{{$errors->first('lastname')}}</p>
							            @endif
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="">Suffix</label>
										{!!Form::select('suffix',$suffixes,old('suffix',$auth->suffix),['class' => "form-control"])!!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group {{$errors->first('gender') ? 'text-danger' : ''}}">
										<label for="">Gender</label>
										{!!Form::select('gender',$genders,old('gender',$auth->gender),['class' => "form-control"])!!}
										@if($errors->first('gender'))
							            	<p class="help-block text-danger">{{$errors->first('gender')}}</p>
							            @endif
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group {{$errors->first('birthdate') ? 'text-danger' : ''}}">
										<label for="">Birthdate</label>
										<input type="text" class="form-control datepicker" name="birthdate" value="{{ old('birthdate', $auth->birthdate) }}">
									</div>
									@if($errors->first('birthdate'))
						            	<p class="help-block text-danger">{{$errors->first('birthdate')}}</p>
						            @endif
								</div>
								<div class="col-md-4">
									<div class="form-group {{$errors->first('civil_status') ? 'text-danger' : ''}}">
										<label for="">Civil Status</label>
										{!!Form::select('civil_status',$civil_statuses,old('civil_status',$auth->civil_status),['class' => "form-control"])!!}
									</div>
									@if($errors->first('civil_status'))
						            	<p class="help-block text-danger">{{$errors->first('civil_status')}}</p>
						            @endif
								</div>
								<div class="col-md-4">
									<div class="form-group {{$errors->first('citizenship') ? 'text-danger' : ''}}">
										<label for="">Citizenship</label>
										{!!Form::select('citizenship',$citizenships,old('citizenship',$auth->citizenship),['class' => "form-control"])!!}
									</div>
									@if($errors->first('citizenship'))
						            	<p class="help-block text-danger">{{$errors->first('citizenship')}}</p>
						            @endif
								</div>
								<div class="col-md-6">
									<div class="form-group {{$errors->first('mobile_no') ? 'text-danger' : ''}}">
										<label for="">Mobile Number</label>
										<input type="number" class="form-control" name="mobile_no" value="{{ old('mobile_no', $auth->mobile_no) }}" maxlength="12">
										@if($errors->first('mobile_no'))
							            	<p class="help-block text-danger">{{$errors->first('mobile_no')}}</p>
							            @endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group {{$errors->first('tel_no') ? 'text-danger' : ''}}">
										<label for="">Telephone Number</label>
										<input type="number" class="form-control" name="tel_no" value="{{ old('tel_no', $auth->tel_no) }}"  maxlength="15">
										@if($errors->first('tel_no'))
							            	<p class="help-block text-danger">{{$errors->first('tel_no')}}</p>
							            @endif
									</div>
								</div>
							</div>


							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<button type="submit" class="btn btn-primary" disabled>Update Account</button>
										<a href="{{route('frontend.profile.index')}}" class="btn btn-danger">Cancel</a>
									</div>
								</div>
							</div>
						</form>
					</div><!--acc-setting end-->
				</div>
			</div>
		</div><!--account-tabs-setting end-->
	</div>
</section>
@stop

@section('page-scripts')
<script type="text/javascript">
	$(function(){
		$(".datepicker").flatpickr({
			enableTime: false,
			disableMobile: "true",
			maxDate  : "{{Carbon::now()->subYears(18)->format("Y-m-d")}}",
			minDate : "{{Carbon::now()->subYears(100)->format("Y-m-d")}}"
		});

		$(this).get_region("#input_region","#input_province","#input_town","#input_brgy","{{old('region', session()->get('soleproprietorship.new_business.region'))}}")

	    $("#input_region").on("change",function(){
	    	var _val = $(this).val();
	    	$(this).get_city($("#input_region").val(), "#input_town", "#input_brgy", "{{old('town')}}");
	    	$('#input_zipcode').val('');
	    });

	    $("#input_town").on("change",function(){
	    	var _val = $(this).val();
	    	$(this).get_brgy(_val, "#input_brgy", "");
	    	$('#input_zipcode').val('');
	    });

	    @if(strlen(old('region')) > 0 || session()->get('soleproprietorship.new_business.region'))
	    	$(this).get_city("{{old('region', session()->get('soleproprietorship.new_business.region'))}}", "#input_town", "#input_brgy", "{{old('town', session()->get('soleproprietorship.new_business.town'))}}");
	    @endif

	    @if(strlen(old('town')) > 0 || session()->get('soleproprietorship.new_business.town'))
	    	$(this).get_brgy("{{old('town', session()->get('soleproprietorship.new_business.town'))}}", "#input_brgy", "{{old('brgy', session()->get('soleproprietorship.new_business.brgy'))}}");
	    @endif

	    $("#input_brgy").on("change",function(){
	     	$('#input_zipcode').val($(this).find(':selected').data('zip_code'))
	    });

	    $('#1906_form').submit(function() {
		    $('#input_region_name').val($("#input_region option:selected").text())
		    $('#input_province_name').val($("#input_province option:selected").text())
		    $('#input_town_name').val($("#input_town option:selected").text())
		    $('#input_brgy_name').val($("#input_brgy option:selected").text())
		    return true; // return false to cancel form action
		});

        var form = $("#personal_info_form");
        form.validate({
            errorClass: "text-danger",
            success: "valid",
            rules: {
                mobile_no: {
                    required: true,
                    digits: true,
                    minlength: 11, maxlength: 12,
                    phonePH: true
                }
            },
            messages: {
                mobile_no: {
                    required: "Invalid Mobile number",
                    minlength: jQuery.validator.format("At least {0} characters required!"),
                    digits: "Invalid Mobile number",
                }
            }
        });
        jQuery.validator.addMethod("phonePH", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/^(09|\+639)\d{9}$/);
        }, "Please specify a valid PH number (Example: 09916014253)");


        $('input[name="mobile_no"]').keyup(function(){
            console.log(form.valid());
            if(form.valid() === false) {
                $(':button[type="submit"]').prop('disabled', true);
            } else {
                $(':button[type="submit"]').prop('disabled', false);
            }
        })
	})
</script>
@stop
