@extends('system._layouts.main')
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('system.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('system.department.index')}}">Assessment Management</a></li>
    <li class="breadcrumb-item active" aria-current="page">Get Assessment Details</li>
  </ol>
</nav>
@stop

@section('content')
<div class="row">
  
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Assessment Form</h4>
        <form class="create-form" method="POST" enctype="multipart/form-data">
          @include('system._components.notifications')
          {!!csrf_field()!!}
          <div class="form-group">
            <label for="input_title">Business ID</label>
            <input type="text" class="form-control {{$errors->first('business_id') ? 'is-invalid' : NULL}}" id="input_business_id" name="business_id" value="{{old('business_id',$transaction->business_info->business_id_no)}}" readonly>
            @if($errors->first('business_id'))
            <p class="mt-1 text-danger">{!!$errors->first('business_id')!!}</p>
            @endif
          </div>
          <div class="form-group">
            <label for="input_title">E-BRIU Application No.</label>
            <input type="text" class="form-control {{$errors->first('application_no') ? 'is-invalid' : NULL}}" id="input_title" name="application_no" value="{{old('application_no',strtoupper($transaction->application_permit->application_no))}}" readonly>
            @if($errors->first('application_no'))
            <p class="mt-1 text-danger">{!!$errors->first('application_no')!!}</p>
            @endif
          </div>
          <div class="form-group">
            <label for="input_title">Office Code</label>
          <input type="text" class="form-control {{$errors->first('office_code') ? 'is-invalid' : NULL}}" id="input_title" name="office_code" value="{{old('office_code',Auth::user()->department->code)}}" readonly>
            @if($errors->first('office_code'))
            <p class="mt-1 text-danger">{!!$errors->first('office_code')!!}</p>
            @endif
          </div>
          <button type="submit" class="btn btn-primary mr-2">Proceed</button>
          <a href="{{route('system.business_transaction.show',[$transaction->id])}}" class="btn btn-light">Return </a>
        </form>
      </div>
    </div>
  </div>
  
</div>
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Assessment Details</h4>
        <div class="table-responsive shadow-sm fs-15 mb-3">
           <table class="table table-bordered table-wrap" style="table-layout: fixed;">
            <thead>
              <tr class="text-center">
                  <th class="text-title" rowspan="2" style="vertical-align: middle;"></th>
                  <th class="text-title" rowspan="2" style="vertical-align: middle;">Fee Type</th>
                  <th class="text-title" rowspan="2" style="vertical-align: middle;">Status</th>
                  <th class="text-title p-3" colspan="3">Breakdown</th>
                </tr>
                <tr class="text-center">
                  <th class="text-title p-3">Office Code</th>
                  <th class="text-title p-3">Account Name</th>
                  <th class="text-title p-3">Amount</th>
                </tr>
            </thead>
            <tbody>
              @if($business_fees)
              @foreach($business_fees as $business_fee)
                <tr>
                  <td rowspan="{{count(json_decode($business_fee->collection_of_fees)) + 1}}"><a href="{{route('system.business_transaction.approved_assessment',[$business_fee->id])}}" class="btn btn-primary btn-assessment">Approve</a></td>
                  <td rowspan="{{count(json_decode($business_fee->collection_of_fees)) + 1}}">{{
                    $business_fee->fee_type == 1 ? "Business Tax" : "Regulatory Fee"}}</td>
                  <td rowspan="{{count(json_decode($business_fee->collection_of_fees)) + 1}}">{{$business_fee->status}}</td>
                @foreach(json_decode($business_fee->collection_of_fees) as $collection)
                  <tr>
                    <td style="font-size: 12px">{{$collection->OfficeCode}}</td>
                    <td style="font-size: 12px">{{$collection->BusinessID}}</td>
                    <td style="font-size: 12px">{{$collection->Amount}}</td>
                  </tr>
                @endforeach
              @endforeach
              @else
                <tr>
                  <td colspan="2" class="tex-center">No Record Available</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
        
      </div>
    </div>
  </div>
</div>
@stop

@section('page-styles')
<style type="text/css">
  .btn-assessment{
    height: 10px;
    line-height: 1px;
    text-decoration: none;
    font-size: 12px;
  }
</style>
@endsection