@extends('system._layouts.main')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('system.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('system.business_cv.index')}}">Business CV</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $profile->business_name }}</li>
  </ol>
</nav>
@stop

@section('content')
<div class="col-md-8 grid-margin stretch-card">
    <div class="card">
        <div class="card-body" style="padding: 3em">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="text-title text-uppercase mt-3">Business Information
                    </h5>
                </div>
            </div>

            <div class="row underline mb-2">
                <div class="col-md-4 mb-2">
                    <label class="text-uppercase">{{str_replace("_"," ",$profile->business_type)}}</label>
                    <p>Business Type</p>
                </div>
                 <div class="col-md-4">
                    <label class="text-uppercase">{{str_replace("_"," ",$profile->business_scope)}}</label>
                    <p>Business Scope</p>
                </div>
                <div class="col-md-4">
                    <label class="text-uppercase">{{$profile->dti_sec_cda_registration_no}}</label>
                    <p>BN Number</p>
                </div>
            </div>
            <div class="row underline mb-2">
                <div class="col-md-4">
                    <label class="text-uppercase">{{$profile->dominant_name}}</label>
                    <p>Dominant Name</p>
                </div>
                 <div class="col-md-4">
                    <label class="text-uppercase">{{$profile->business_name}}</label>
                    <p>Business Name</p>
                </div>
                <div class="col-md-4">
                    <label class="text-uppercase"><a href="{{$profile->website_url}}">{{$profile->website_url}}</a></label>
                    <p>Website (URL)</p>
                </div>

            </div>
            <div class="row underline mb-2">
                <div class="col-md-4">
                    <label class="text-uppercase">{{$profile->mobile_no}}</label>
                    <p>Mobile Number</p>
                </div>
                <div class="col-md-4">
                    <label class="text-uppercase">{{$profile->telephone_no}}</label>
                    <p>Telephone Number</p>
                </div>
                <div class="col-md-4">
                    <label>{{$profile->email}}</label>
                    <p>Email Address</p>
                </div>

            </div>
            <div class="row underline mb-2">
                <div class="col-md-4">
                    <label class="text-uppercase">{{$profile->capitalization}}</label>
                    <p>Capitalization</p>
                </div>
            </div>
            <h5 class="text-title text-uppercase mt-4">Line of Business</h5>
            <div class="row underline mb-2">
                @foreach ($business_line as $key => $item)
                    <div class="col-md-4">
                        <label class="text-uppercase">{{ $item->name }}</label>
                        <p class="text-title">Business Line</p>
                    </div>
                @endforeach
            </div>
            <div class="row underline mb-2">
                <div class="col-md-3">
                    <label class="text-uppercase">{{$profile->no_of_male_employee}}</label>
                    <p>No. of Male Employee</p>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase">{{$profile->no_of_female_employee}}</label>
                    <p>No. of Female Employee</p>
                </div>
                <div class="col-md-3">
                    <label>{{$profile->male_residing_in_city}}</label>
                    <p>No. of Male Employees Residing In City</p>
                </div>
                <div class="col-md-3">
                    <label>{{$profile->female_residing_in_city}}</label>
                    <p>No. of Female Employees Residing In City</p>
                </div>
            </div>
            <h5 class="text-title text-uppercase mt-4">Business Address Information</h5>
            <div class="row underline mb-2">
                <div class="col-md-4">
                    <label class="text-uppercase">{{$profile->unit_no}}</label>
                    <p>House/Unit No.</p>
                </div>
                <div class="col-md-4">
                    <label class="text-uppercase">{{$profile->street_address}}</label>
                    <p>Street Address</p>
                </div>
                <div class="col-md-4">
                    <label>{{$profile->brgy_name}}</label>
                    <p>Barangay</p>
                </div>

            </div>
            <div class="row underline mb-2">
                <div class="col-md-4">
                    <label class="text-uppercase">{{$profile->zipcode}}</label>
                    <p>Zipcode</p>
                </div>
                <div class="col-md-4">
                    <label class="text-uppercase">{{$profile->town_name}}</label>
                    <p>Town/Municipality</p>
                </div>
                <div class="col-md-4">
                    <label>{{$profile->region_name}}</label>
                    <p>Region</p>
                </div>
            </div>
            <h5 class="text-title text-uppercase mt-4">Business Address Information</h5>
             <div class="row underline mb-2">
                <div class="col-md-6">
                    <label class="text-uppercase">{{$profile->sss_no ?: "-"}}</label>
                    <p>SSS Number</p>
                </div>
                <div class="col-md-6">
                    <label class="text-uppercase">{{$profile->philhealth_no ?: "-"}}</label>
                    <p>Philhealth Number</p>
                </div>

            </div>
             <div class="row underline mb-2">
                <div class="col-md-6">
                    <label class="text-uppercase">{{$profile->tin_no ?: "-" }}</label>
                    <p>TIN Number</p>
                </div>
                <div class="col-md-6">
                    <label class="text-uppercase">{{$profile->pagibig_no ?: "-"}}</label>
                    <p>PAGIBIG Number</p>
                </div>

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
    $(document).ready(function(){
      $('#input_requirements_id').select2({placeholder: "Select Requirements"});
    });//document ready
</script>
@endsection
