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
  
  <div class="col-md-6 grid-margin stretch-card">
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
          <button type="submit" class="btn btn-primary mr-2">Send Assesment Request</button>
          <a href="{{route('system.business_transaction.show',[$transaction->id])}}" class="btn btn-light">Return </a>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Assessment Details</h4>
        <div class="table-responsive shadow-sm fs-15 mb-3">
          <table class="table table-striped">
            <thead>
              <th class="text-title p-2">Account Name</th>
              <th class="text-title p-2">Amount</th>
            </thead>
            <tbody>
              @if($regulatory_fee)
              @foreach($breakdown_collection as $collection)
                <tr>
                  <td>{{$collection->BusinessID}}</td>
                  <td>{{$collection->Amount}}</td>
                </tr>
              @endforeach
              @else
                <tr>
                  <td colspan="2" class="tex-center">No Record Available</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
        <div class="form-group">
          <label for="input_title">Total Amount</label>
          <input type="text" class="form-control" id="input_business_id" name="total_amount" value="{{old('total_amount',$regulatory_fee ? $regulatory_fee->total_amount : 0 )}}" readonly>
        </div>
        @if($regulatory_fee)
          <div class="form-group">
            <p class="text-title fw-500">Assessment Status: <span class="badge  badge-{{Helper::status_badge($regulatory_fee->status)}} p-2">{{Str::title($regulatory_fee->status)}}</span></p>
          </div>
          @if($regulatory_fee->status == "PENDING")
            <a href="{{route('system.business_transaction.approved_assessment',[$transaction->id])}}" class="btn btn-primary" type="button">Approve</a>
          @endif
        @endif
        
      </div>
    </div>
  </div>
</div>
@stop

