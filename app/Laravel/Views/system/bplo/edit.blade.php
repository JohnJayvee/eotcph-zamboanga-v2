@extends('system._layouts.main')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('system.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('system.application.index')}}">Registrants</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit {{ $customer->collection_name?? '-' }}</li>
  </ol>
</nav>
@stop

@section('content')
<div class="col-md-8 grid-margin stretch-card">
    <div class="card">
        <form class="create-form" method="POST" enctype="multipart/form-data">
            @include('system._components.notifications')
            {!!csrf_field()!!}
            <div class="card-body registration-card py-0">
                <h5 class="text-title text-uppercase pt-5">Account Details</h5>
                <div class="row">
                    <div class="col-md-6 col-lg-6 ">
                        <div class="form-group">
                            <label class="text-form pb-2">Email</label>
                            <p class="text-form text-success">{{ $customer->email?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="text-title pb-2">Account Status</label>
                            <select name="status" class="form-control">
                                <option value="approved">Approved</option>
                                <option value="declined">Declined</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="form pt-0">
            <div class="card-body registration-card">
                <h5 class="text-title text-uppercase ">Account Information</h5>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="text-form pb-2">First Name</label>
                            <p class="text-form text-success">{{ $customer->fname?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group mb-0">
                            <label class="text-form pb-2">Last Name</label>
                            <p class="text-form text-success">{{ $customer->lname?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group ">
                            <label class="text-form pb-2">Middle Name</label>
                            <p class="text-form text-success">{{ $customer->mname?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="text-form pb-2">Contact Number</label>
                            <p class="text-form text-success">{{ $customer->contact_number?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-form pb-2">Region</label>
                            <p class="text-form text-success">{{ $customer->region_name?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-form pb-2">City Municipality</label>
                            <p class="text-form text-success">{{ $customer->town_name?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="text-form pb-2">Barangay</label>
                            <p class="text-form text-success">{{ $customer->barangay_name?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="text-form pb-2">Street Name</label>
                            <p class="text-form text-success">{{ $customer->street_name?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="text-form pb-2">BLDG/ Unit Number</label>
                            <p class="text-form text-success">{{ $customer->unit_number?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="input_zipcode" class="text-form pb-2">Zipcode</label>
                            <<p class="text-form text-success">{{ $customer->zipcode?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="text-form pb-2">Birthdate</label>
                            <p class="text-form text-success">{{ $customer->birthdate?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <h5 class="text-title text-uppercase ">Account Requirements</h5>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="text-form pb-2">TIN No.</label>
                            <p class="text-form text-success">{{ $customer->tin_no?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="text-form pb-2">SSS No.</label>
                            <p class="text-form text-success">{{ $customer->sss_no?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="text-form pb-2">PHIC No.</label>
                            <p class="text-form text-success">{{ $customer->phic_no ?? '-'}}</p>
                        </div>
                    </div>
                </div>
                <h5 class="text-title text-uppercase ">Uploaded Government ID</h5>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>Uploaded Document</td>
                                            <td>Type</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Government ID 1</td>
                                            <td>image</td>
                                        </tr>
                                        <tr>
                                            <td>Government ID 2</td>
                                            <td>image</td>
                                        </tr>
                                        <tr>
                                            <td>Business Permit</td>
                                            <td>pdf</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Create Record</button>
            </div>
        </form>
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
