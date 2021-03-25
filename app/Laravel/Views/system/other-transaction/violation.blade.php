@extends('system._layouts.main')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('system.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('system.department.index')}}">Traffic Violations Management</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add New Traffic Violations</li>
  </ol>
</nav>
@stop

@section('content')
<div class="col-md-8 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Traffic Violations Create Form</h4>
      <form class="create-form" method="POST" enctype="multipart/form-data" action={{ route('system.other_transaction.store') }}>
        @include('system._components.notifications')
        {!!csrf_field()!!}
        <input type="hidden" name="type" value="{{$type}}">
        <input type="hidden" name="customer_id" value="{{$customer_id}}">
        <input type="hidden" name="violation_count" value="{{$violation_count}}">
        <input type="hidden" name="violation_name" value="{{old('violation_name')}}" id="input_violation_name">
        <div class="row">
        	<div class="col-md-4">
       			<div class="form-group">
       				<label for="input_title">Ticket No.</label>
    					<label>The ticket number will be generated once the Violation has been saved.</label>
		        </div>
     		  </div>
        </div>
        <label for="input_title">Driver's Name</label>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <input type="text" class="form-control" id="input_d_firstname" name="d_firstname" placeholder="First Name" value="{{Str::title($customer->firstname)}}" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <input type="text" class="form-control" id="input_d_middlename" name="d_middlename" placeholder="Middle Name" value="{{Str::title($customer->middlename)}}" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <input type="text" class="form-control" id="input_d_lastname" name="d_lastname" placeholder="Last Name" value="{{Str::title($customer->lastname)}}" readonly>
            </div>
          </div>
        </div>
       	<label for="input_title">Owner's Full Name</label>
       	<div class="row">
       		<div class="col-md-4">
       			<div class="form-group">
  					<input type="text" class="form-control {{$errors->first('p_firstname') ? 'is-invalid' : NULL}}" id="input_p_firstname" name="p_firstname" placeholder="First Name" value="{{old('p_firstname')}}">
  					@if($errors->first('p_firstname'))
  					<p class="mt-1 text-danger">{!!$errors->first('p_firstname')!!}</p>
  					@endif
  				</div>
       		</div>
       		<div class="col-md-4">
       			<div class="form-group">
  					<input type="text" class="form-control {{$errors->first('p_middlename') ? 'is-invalid' : NULL}}" id="input_p_middlename" name="p_middlename" placeholder="Middle Name" value="{{old('p_middlename')}}">
  					@if($errors->first('p_middlename'))
  					<p class="mt-1 text-danger">{!!$errors->first('p_middlename')!!}</p>
  					@endif
  		        </div>
       		</div>
       		<div class="col-md-4">
  				<div class="form-group">
  					<input type="text" class="form-control {{$errors->first('p_lastname') ? 'is-invalid' : NULL}}" id="input_p_lastname" name="p_lastname" placeholder="Last Name" value="{{old('p_lastname')}}">
  					@if($errors->first('p_lastname'))
  					<p class="mt-1 text-danger">{!!$errors->first('p_lastname')!!}</p>
  					@endif
  				</div>
       		</div>
       	</div>
       	<div class="row">
       		<div class="col-md-6">
       			<div class="form-group">
       			<label for="input_title">Email</label>
  					<input type="text" class="form-control {{$errors->first('email') ? 'is-invalid' : NULL}}" id="input_email" name="email" placeholder="Email" value="{{old('email')}}">
  					@if($errors->first('email'))
  					<p class="mt-1 text-danger">{!!$errors->first('email')!!}</p>
  					@endif
  				</div>
       		</div>
       		<div class="col-md-6">
       			<div class="form-group">
              <label class="text-form ">Contact Number</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text text-title fw-600">+63 <span class="pr-1 pl-2" style="padding-bottom: 2px"> |</span></span>
                </div>
                <input type="text" class="form-control {{ $errors->first('contact_number') ? 'is-invalid': NULL  }} br-left-white" name="contact_number" placeholder="Contact Number" value="{{old('contact_number')}}">
              </div>
              @if($errors->first('contact_number'))
                <small class="form-text pl-1" style="color:red;">{{$errors->first('contact_number')}}</small>
              @endif
            </div>
       		</div>
       	</div>
       	<div class="row">
       		<div class="col-md-12">
       			<div class="form-group">
       				<label for="input_title">Address</label>
  					<input type="text" class="form-control {{$errors->first('address') ? 'is-invalid' : NULL}}" id="input_address" name="address" placeholder="Address" value="{{old('address')}}">
  					@if($errors->first('address'))
  					<p class="mt-1 text-danger">{!!$errors->first('address')!!}</p>
  					@endif
  		        </div>
       		</div>
       		<div class="col-md-12">
       			<div class="form-group">
       				<label for="input_title">Violations</label>
  					{!!Form::select("violation", $violations, old('violation'), ['id' => "input_violation", 'class' => "custom-select mb-2 mr-sm-2 ".($errors->first('violation') ? 'is-invalid' : NULL)])!!}
  					@if($errors->first('violation'))
  					<p class="mt-1 text-danger">{!!$errors->first('violation')!!}</p>
  					@endif
  		        </div>
       		</div>
       		<div class="col-md-12">
       			<div class="form-group">
       				<label for="input_title">Place Of Violation</label>
  					<input type="text" class="form-control {{$errors->first('place_of_violation') ? 'is-invalid' : NULL}}" id="input_place_of_violation" name="place_of_violation" placeholder="Place of Violation" value="{{old('place_of_violation')}}">
  					@if($errors->first('place_of_violation'))
  					<p class="mt-1 text-danger">{!!$errors->first('place_of_violation')!!}</p>
  					@endif
  		        </div>
       		</div>
       	</div>
       	<div class="row">
          <div class='col-sm-12'>
            <div class="form-group">
          	  <label for="input_title">Date</label>
              <input type="date" class="form-control {{$errors->first('violation_date') ? 'is-invalid' : NULL}}" id="input_violation_date" name="violation_date" placeholder="" value="{{old('violation_date')}}">
              @if($errors->first('violation_date'))
  		          <p class="mt-1 text-danger">{!!$errors->first('violation_date')!!}</p>
  		        @endif
            </div>
          </div>
      	</div>
        <div class="row">
          <div class='col-sm-12'>
            <div class="form-group">
              <label for="input_title">Time</label>
              <input type="time" class="form-control {{$errors->first('violation_time') ? 'is-invalid' : NULL}}" id="input_violation_time" name="violation_time" placeholder="" value="{{old('violation_time')}}">
              @if($errors->first('violation_time'))
                <p class="mt-1 text-danger">{!!$errors->first('violation_time')!!}</p>
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="input_title">Remarks</label>
              <textarea class="form-control {{$errors->first('remarks') ? 'is-invalid' : NULL}}" id="exampleFormControlTextarea1" rows="5" name="remarks">{{old('remarks')}}</textarea>
              @if($errors->first('remarks'))
              <p class="mt-1 text-danger">{!!$errors->first('remarks')!!}</p>
              @endif
              </div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-md-12">
            <label>This serves as the driver’s temporary operator’s permit for 72 hours (three (3) days) from the apprehension, and also as an Official document to inform the concerned private individual found violating the above-stated charges.
            Furthermore, the undersigned hereby promised to appear at CMO/ZCPO/CTO before the expiration of this TOP/Citation Ticket within seventy-two (72) hours to answer the above-cited offenses, otherwise, it will cause the filing of appropriate criminal charges in the court of law.
            </label>
          </div>
        </div>
        <button type="submit" class="btn btn-primary mr-2">Proceed</button>
        <a href="{{route('system.other_customer.show',[$customer->id])}}" class="btn btn-light">Return to Customer Records</a>
      </form>
    </div>
  </div>
</div>
@stop
@section('page-styles')
<link rel="stylesheet" href="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('system/vendors/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
<style type="text/css" media="screen">
	.datetimepicker.dropdown-menu{
		width: 40%;
	} 
	.datetimepicker.dropdown-menu table{ width: 50%; } 
	.datetimepicker table tr td.active:active, .datetimepicker table tr td.active:hover:active, .datetimepicker table tr td.active.disabled:active, .datetimepicker table tr td.active.disabled:hover:active, .datetimepicker table tr td.active.active, .datetimepicker table tr td.active:hover.active, .datetimepicker table tr td.active.disabled.active, .datetimepicker table tr td.active.disabled:hover.active,
	.datetimepicker table tr td span.active:active, .datetimepicker table tr td span.active:hover:active, .datetimepicker table tr td span.active.disabled:active, .datetimepicker table tr td span.active.disabled:hover:active, .datetimepicker table tr td span.active.active, .datetimepicker table tr td span.active:hover.active, .datetimepicker table tr td span.active.disabled.active, .datetimepicker table tr td span.active.disabled:hover.active { background: #3bb001; }
</style>
@stop

@section('page-scripts')
<script src="{{asset('system/vendors/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script src="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('system/vendors/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script type="text/javascript">
  $(function(){
    $(".editor").each(function(){
        CKEDITOR.replace(this);
    });
   
    $(".datetimepicker").datetimepicker({
      pickDate: false,
      minuteStep: 15,
      pickerPosition: 'bottom-right',
      format: 'HH:ii p',
      autoclose: true,
      showMeridian: true,
      startView: 1,
      maxView: 1,
    });

    $("#input_violation").on("change",function(){
        var _val = $(this).val();
        var _text = $("#input_violation option:selected").text();
        $("#input_violation_name").val(_text);
    });

  })
</script>
@stop