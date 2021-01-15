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
<div class="col-md-10 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form class="create-form" method="POST" enctype="multipart/form-data">
                @include('system._components.notifications')
                {!!csrf_field()!!}

                <h5 class="text-title text-uppercase ">Account Details</h5>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="text-title">Account Status</label>
                            {!!Form::select("status", $status_type, old('status'), ['id' => "input_status", 'class' => "custom-select mb-2 mr-sm-2 ".($errors->first('status') ? 'is-invalid' : NULL), $customer->status == 'pending' ?: 'disabled'])!!}
                            <small class="text-danger">{{ $customer->otp_verified ? '' : 'The registrant is not OTP verified' }}</small>
                            @if($errors->first('status'))
                              <p class="mt-1 text-danger">{!!$errors->first('status')!!}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6" id="remarks_container">
                        <div class="form-group">
                          <label for="input_email">Remarks</label>
                          <textarea class="form-control" id="input_email" name="remarks" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6 ">
                        <div class="form-group">
                          <label for="input_email">Email</label>
                          <input type="text" class="form-control" id="input_email" value="{{ $customer->email ?: '-' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="input_contact_number">Contact Number</label>
                            <input type="text" class="form-control" id="input_contact_number" value="{{ $customer->contact_number ?: '-' }}" readonly>
                        </div>
                    </div>
                </div>

                <hr class="form pt-0">

                <h5 class="text-title text-uppercase ">Account Information</h5>
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="input_lname">Last Name</label>
                          <input type="text" class="form-control" id="input_lname" value="{{ $customer->lname ?: '-' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="input_fname">First Name</label>
                          <input type="text" class="form-control" id="input_fname" value="{{ $customer->fname ?: '-' }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="input_mname">Middle Name</label>
                          <input type="text" class="form-control" id="input_mname" value="{{ $customer->mname ?: '-' }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="input_region_name">Region</label>
                            <input type="text" class="form-control" id="input_region_name" value="{{ $customer->region_name ?: '-' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="input_town_name">City Municipality</label>
                            <input type="text" class="form-control" id="input_town_name" value="{{ $customer->town_name ?: '-' }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="input_barangay_name">Barangay</label>
                          <input type="text" class="form-control" id="input_barangay_name" value="{{ $customer->barangay_name ?: '-' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                          <label for="input_street_name">Street Name</label>
                          <input type="text" class="form-control" id="input_street_name" value="{{ $customer->street_name ?: '-' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="input_unit_number">BLDG/ Unit Number</label>
                            <input type="text" class="form-control" id="input_unit_number" value="{{ $customer->unit_number ?: '-' }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="input_zipcode">Zipcode</label>
                            <input type="text" class="form-control" id="input_zipcode" value="{{ $customer->zipcode ?: '-' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="input_birthdate">Birthdate</label>
                            <input type="text" class="form-control" id="input_birthdate" value="{{ $customer->birthdate ?: '-' }}" readonly>
                        </div>
                    </div>
                </div>

                <h5 class="text-title text-uppercase ">Account Requirements</h5>

                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="input_tin_no">TIN No.</label>
                            <input type="text" class="form-control" id="input_tin_no" value="{{ $customer->tin_no ?: '-' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="input_sss_no">SSS No.</label>
                            <input type="text" class="form-control" id="input_sss_no" value="{{ $customer->sss_no ?: '-' }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="input_phic_no">PHIC No.</label>
                            <input type="text" class="form-control" id="input_phic_no" value="{{ $customer->phic_no ?: '-' }}" readonly>
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
                                            <td>Date Uploaded</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($customer_file as $file)
                                        <tr>
                                            <td>
                                                <div><strong>{{ strtoupper(str_replace('-', ' ', $file->type)) }}</strong></div>
                                                <div><small>File: <strong><a href="{{"{$file->directory}/{$file->filename}"}}" target="_blank">{{$file->filename}}</a></strong></small></div>
                                            </td>
                                            <td>
                                                {{ $file->source }}
                                            </td>
                                            <td>
                                                {{ Helper::date_format($file->created_at)}}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-center" colspan="3">
                                                <p>No Document Uploaded.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-2" {{ $customer->status == 'pending' ?: 'disabled' }}>Update Record</button>
            </form>
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
</style>
@endsection

@section('page-scripts')
<script src="{{asset('system/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $('#input_status').on('change', function(){
        var val = $(this).val();

        if (val == "approved") {
            $('#remarks_container').hide();
        }else if (val == "declined") {
            $('#remarks_container').show();
        }else{
            $('#remarks_container').hide();
        }
      }).change();
    });//document ready
</script>
@endsection
