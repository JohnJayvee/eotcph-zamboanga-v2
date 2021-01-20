@extends('system._layouts.main')

@section('content')
<div class="row px-5 py-4">
  <div class="col-12">
    @include('system._components.notifications')
    <div class="row ">
      <div class="col-md-6">
        <h5 class="text-title text-uppercase">{{$page_title}}</h5>
      </div>
      <div class="col-md-6 ">
        <p class="text-dim  float-right">EOR-PHP Processor Portal / Transactions / Transaction Details</p>
      </div>
    </div>
  </div>
  <div class="col-12 pt-4">
    <div class="card card-rounded shadow-sm mb-4">
      <div class="card-body" style="border-bottom: 3px dashed #E3E3E3;">
        <div class="row">
          <div class="col-md-1 text-center">
            <img src="{{asset('system/images/default.jpg')}}" class="rounded-circle" width="100%">
          </div>
          <div class="col-md-11 d-flex">
            <p class="text-title fw-500 pt-3">Application by: <span class="text-black">{{Str::title($transaction->customer ? $transaction->customer->full_name : $transaction->customer_name)}}</span></p>
            <p class="text-title fw-500 pl-3" style="padding-top: 15px;">|</p>
            <p class="text-title fw-500 pt-3 pl-3">Application Sent: <span class="text-black">{{ Helper::date_format($transaction->created_at)}}</span></p>
          </div>
        </div>
      </div>
      <div class="card-body" style="border-bottom: 3px dashed #E3E3E3;">
        <div class="row">
          <div class="col-md-6">
            <p class="text-title fw-500">Business Name: <span class="text-black">{{str::title($transaction->business_name)}}</span></p>
            <p class="text-title fw-500">Dominant Name: <span class="text-black">{{str::title($transaction->business_info->dominant_name)}}</span></p>
            <p class="text-title fw-500">DTI/SEC/CDA registration No.: <span class="text-black">{{$transaction->business_info->bn_number ?: "-"}}</span></p>
            <p class="text-title fw-500">Business Type: <span class="text-black">{{str::title($transaction->business_info->business_type)}}</span></p>
            <p class="text-title fw-500">Business Scope: <span class="text-black">{{str::title($transaction->business_info->business_scope)}}</span></p>
            <p class="text-title fw-500">Business Mobile No.: <span class="text-black"> +63{{$transaction->business_info->mobile_no}}</span></p>
            <p class="text-title fw-500">Business Mobile No.: <span class="text-black"> {{$transaction->business_info->telephone_no}}</span></p>
            <p class="text-title fw-500">Business Email: <span class="text-black">{{$transaction->business_info->email}}</span></p>
          </div>
          <div class="col-md-6">
            <p class="text-title fw-500">Business Unit No / Street: <span class="text-black">{{$transaction->business_info->business_address}}</span></p>
            <p class="text-title fw-500">Business Barangay: <span class="text-black"> {{$transaction->business_info->brgy_name}}</span></p>
            <p class="text-title fw-500">Business Province/Town: <span class="text-black"> {{$transaction->business_info->town_name}}</span></p>
            <p class="text-title fw-500">Business Region: <span class="text-black">{{str::title($transaction->business_info->region_name)}}</span></p>
          </div>
          <div class="col-md-6 mt-4">
            <p class="text-title fw-500">Transaction Details:</p>
            <p class="text-title fw-500">Application : <span class="text-black">{{str::title($transaction->application_name)}}</span></p>
            <p class="text-title fw-500">Status: <span class="badge  badge-{{Helper::status_badge($transaction->transaction_status)}} p-2">{{Str::title($transaction->transaction_status)}}</span></p>
            <p class="fw-500" style="color: #DC3C3B;">Processing Fee: Php {{Helper::money_format($transaction->processing_fee) ?: "0" }} [{{$transaction->processing_fee_code}}]</p>
            <p class="text-title fw-500">Payment Status: <span class="badge  badge-{{Helper::status_badge($transaction->payment_status)}} p-2">{{Str::title($transaction->payment_status)}}</span></p>
            <p class="text-title fw-500">Approved Department:
            <span class="text-black">
              @if($transaction->approved_department)
                @foreach(explode(",", $transaction->approved_department) as $department)
                  {{Helper::department_name($department)}}
                @endforeach
              @endif
            </span></p>
          </div>
          <div class="col-md-6 mt-4">
            <p class="text-title fw-500">Owners Name: <span class="text-black">{{str::title($transaction->owner ? $transaction->owner->full_name : $transaction->customer_name)}}</span></p>
            <p class="text-title fw-500">Owners Email: <span class="text-black">{{$transaction->owner->email}}</span></p>
            <p class="text-title fw-500">Owners Contact No.: <span class="text-black">{{$transaction->owner->contact_number}}</span></p>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-rounded shadow-sm">
      <div class="card-body" style="border-bottom: 3px dashed #E3E3E3;">
        <h5 class="text-title text-uppercase">Collection Breakdown</h5>
        <div class="row mt-4">
          @if($breakdown_collection->permit_fee > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Permit Fee: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->permit_fee) ?:"0.00"}}</span></p>
          </div>
          @endif
          @if($breakdown_collection->electrical_fee > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Electrical Fee: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->electrical_fee) ?:"0.00"}}</span></p>
          </div>
          @endif
          @if($breakdown_collection->plumbing_fee > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Plumbing Fee: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->plumbing_fee) ?:"0.00"}}</span></p>
          </div>
          @endif
          @if($breakdown_collection->mechanical_fee > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Mechanical Fee: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->mechanical_fee) ?:"0.00"}}</span></p>
          </div>
          @endif
          @if($breakdown_collection->signboard_fee > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Signboard Fee: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->signboard_fee) ?:"0.00"}}</span></p>
          </div>
          @endif
          @if($breakdown_collection->zoning_fee > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Zoning Fee: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->zoning_fee) ?:"0.00"}}</span></p>
          </div>
          @endif
          @if($breakdown_collection->certification_fee_cvo > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Certification Fee CVO: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->certification_fee_cvo) ?:"0.00"}}</span></p>
          </div>
          @endif
          @if($breakdown_collection->health_certificate_fee > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Health Certificate Fee: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->health_certificate_fee) ?:"0.00"}}</span></p>
          </div>
          @endif
          @if($breakdown_collection->certification_fee_tetuan > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Certificate Fee Tetuan: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->certification_fee_tetuan) ?:"0.00"}}</span></p>
          </div>
          @endif
          @if($breakdown_collection->garbage_fee > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Garbage Fee: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->garbage_fee) ?:"0.00"}}</span></p>
          </div>
          @endif
          @if($breakdown_collection->garbage_fee > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Inspection Fee: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->inspection_fee) ?:"0.00"}}</span></p>
          </div>
          @endif
          @if($breakdown_collection->sanitary_inspection_fee > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Sanitary Inspection Fee: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->sanitary_inspection_fee) ?:"0.00"}}</span></p>
          </div>
          @endif
          @if($breakdown_collection->sticker > 0)
          <div class="col-md-3 p-1">
            <p class="text-title fw-500">Sticker Fee: <span class="text-black"> PHP {{Helper::money_format($breakdown_collection->sticker) ?:"0.00"}}</span></p>
          </div>
          @endif
        </div>
        <div class="row mt-2">
          <div class="col-md-6 p-1">
            <p class="text-title fw-500">Total Collection Breakdown <span class="text-black"> PHP {{ Helper::money_format(Helper::total_breakdown($breakdown_collection->id))}}</span></p>
          </div>
        </div>
      </div>
    </div>
    <a data-url="{{route('system.transaction.process',[$transaction->id])}}?status_type=approved"  class="btn btn-primary mt-4 btn-approved border-5 text-white {{$transaction->status == 'approved' ? "isDisabled" : ""}}"><i class="fa fa-check-circle"></i> Approve Transactions</a>
    <a  data-url="{{route('system.transaction.process',[$transaction->id])}}?status_type=declined" class="btn btn-danger mt-4 btn-decline border-5 text-white {{$transaction->status == 'approved' ? "isDisabled" : ""}}""><i class="fa fa-times-circle"></i> Decline Transactions</a>
  </div>
</div>
@stop



@section('page-styles')
<link rel="stylesheet" href="{{asset('system/vendors/sweet-alert2/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('system/vendors/select2/select2.min.css')}}"/>
<style type="text/css" >
  .input-daterange input{ background: #fff!important; }
  .isDisabled{
    color: currentColor;
    display: inline-block;  /* For IE11/ MS Edge bug */
    pointer-events: none;
    text-decoration: none;
    cursor: not-allowed;
    opacity: 0.5;
  }
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
@stop

@section('page-scripts')
<script src="{{asset('system/vendors/swal/sweetalert.min.js')}}"></script>
<script src="{{asset('system/vendors/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('system/vendors/select2/select2.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
  $(function(){
    $('.input-daterange').datepicker({
      format : "yyyy-mm-dd"
    });
    $(".btn-decline").on('click', function(){
      var url = $(this).data('url');
      var self = $(this)
      Swal.fire({
        title: "All the submitted requirements will be marked as declined. Are you sure you want to declined this application?",

        icon: 'warning',
        input: 'text',
        inputPlaceholder: "Put remarks",
        showCancelButton: true,
        confirmButtonText: 'Decline',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.value === "") {
          alert("You need to write something")
          return false
        }
        if (result.value) {
          window.location.href = url + "&remarks="+result.value;
        }
      });
    });
    $(".btn-approved").on('click', function(){
      var url = $(this).data('url');
      var self = $(this)
      Swal.fire({
        title: "All the submitted requirements will be marked as approved. Are you sure you want to approve this application?",

        icon: 'info',
        input: 'text',
        inputPlaceholder: "Put Amount",
        showCancelButton: true,
        confirmButtonText: 'Approved!',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.value === "") {
          alert("You need to write something")
          return false
        }
        if (result.value) {
          window.location.href = url + "&amount="+result.value;
        }
      });
    });



    $('#input_department_id').select2({placeholder: "Select Department"});
  })
</script>
@stop
