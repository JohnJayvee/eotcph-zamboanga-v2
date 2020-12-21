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
            <p class="text-title fw-500">Business Number: <span class="text-black">{{$transaction->business_info->bn_number ?: "-"}}</span></p>
            <p class="text-title fw-500">Business Type: <span class="text-black">{{str::title($transaction->business_info->business_type)}}</span></p>
            <p class="text-title fw-500">Business Scope: <span class="text-black">{{str::title($transaction->business_info->business_scope)}}</span></p>
            <p class="text-title fw-500">Business Mobile No.: <span class="text-black"> +63{{$transaction->business_info->mobile_no}}</span></p>
            <p class="text-title fw-500">Business Tel No.: <span class="text-black"> {{$transaction->business_info->telephone_no}}</span></p>
            <p class="text-title fw-500">Business Email: <span class="text-black">{{$transaction->business_info->email}}</span></p>

            <p class="text-title fw-500">Line of Business :</p>
            <table class="table table-bordered">
                <tbody>
                    @forelse ($business_line as $item)
                    <tr>
                        <td>{{ $item->line_of_business }}</td>
                    </tr>
                    @empty
                    <tr>
                        <tr>--</tr>
                    </tr>
                    @endforelse
                </tbody>
            </table>

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
            <p class="text-title fw-500">Application Status: <span class="badge  badge-{{Helper::status_badge($transaction->status)}} p-2">{{Str::title($transaction->status)}}</span></p>
            <p class="text-title fw-500">Validated By BPLO: <span>{{$transaction->is_validated == 1 ? "Yes" : "No"}}</span></p>
            <!-- <p class="text-title fw-500">Transacation Status: <span class="badge  badge-{{Helper::status_badge($transaction->transaction_status)}} p-2">{{Str::title($transaction->transaction_status)}}</span></p>
            <p class="fw-500" style="color: #DC3C3B;">Processing Fee: Php {{Helper::money_format($transaction->amount) ?: "0" }} [{{$transaction->processing_fee_code}}]</p>
            <p class="text-title fw-500">Payment Status: <span class="badge  badge-{{Helper::status_badge($transaction->payment_status)}} p-2">{{Str::title($transaction->payment_status)}}</span></p> -->
          </div>
          <div class="col-md-6 mt-4">
            <p class="text-title fw-500">Owners Name: <span class="text-black">{{str::title($transaction->owner ? $transaction->owner->full_name : $transaction->customer_name)}}</span></p>
            <p class="text-title fw-500">Owners Email: <span class="text-black">{{$transaction->owner->email}}</span></p>
            <p class="text-title fw-500">Owners Contact No.: <span class="text-black">{{$transaction->owner->contact_number}}</span></p>
          </div>
        </div>
      </div>
    </div>
    
    <div class="card card-rounded shadow-sm mb-2">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 pt-2">
            <h5 class="text-title text-uppercase">Department Remarks</h5>
          </div>
          <div class="col-md-6">
            @if(Auth::user()->type == "processor")
              <a data-url="{{route('system.business_transaction.remarks',[$transaction->id])}}"  class="btn btn-primary btn-remarks border-5 text-white float-right">Add Remarks</a>
            @endif
          </div>
          <div class="table-responsive pt-2">
            <table class="table table-striped table-wrap" style="table-layout: fixed;">
              <thead>
                <tr>
                  <th class="text-title p-3">Processor Name</th>
                  <th class="text-title p-3">Department Name</th>
                  <th class="text-title p-3">Remarks</th>
                </tr>
              </thead>
              <tbody>
                @if($transaction->department_remarks)
                  @forelse(json_decode($transaction->department_remarks) as $value)
                  <tr>
                    <td>{{str::title(Helper::processor_name($value->processor_id))}}</td>
                    <td>{{str::title(Helper::department_name($value->id))}}</td>
                    <td>{{str::title($value->remarks)}}</td>
                  </tr>
                  @empty
                  @endforelse
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    @if(in_array(Auth::user()->type, ['admin', 'super_user']) and in_array($transaction->status, ['PENDING', 'ONGOING']))
      @if($transaction->is_validated == 0)
        <a data-url="{{route('system.business_transaction.validate',[$transaction->id])}}"  class="btn btn-primary mt-4 btn-validate border-5 text-white {{$transaction->status == 'approved' ? "isDisabled" : ""}}"><i class="fa fa-check-circle"></i> Validate Transactions</a>
      @endif
      @if($transaction->for_bplo_approval == 1)
        <a data-url="{{route('system.business_transaction.process',[$transaction->id])}}?status_type=approved&collection_id={{$transaction->collection_id}}"  class="btn btn-primary mt-4 btn-approved border-5 text-white {{$transaction->status == 'approved' ? "isDisabled" : ""}}"><i class="fa fa-check-circle"></i> Approve Transactions</a>
        <a  data-url="{{route('system.business_transaction.process',[$transaction->id])}}?status_type=declined" class="btn btn-danger mt-4 btn-decline border-5 text-white {{$transaction->status == 'approved' ? "isDisabled" : ""}}""><i class="fa fa-times-circle"></i> Decline Transactions</a>
      @endif
    @endif
  </div>

</div>
@stop



@section('page-styles')
<!-- <link rel="stylesheet" href="{{asset('system/vendors/sweet-alert2/sweetalert2.min.css')}}"> -->
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
  textarea.swal2-textarea {
    width: 25em;
  }
</style>
@stop

@section('page-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<!-- <script src="{{asset('system/vendors/sweet-alert2/sweetalert2.min.js')}}"></script> -->
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
    $(".btn-remarks").on('click', function(){
      var url = $(this).data('url');
      var self = $(this)
      Swal.fire({
        title: "If you're one of the involved offices for this specific application, please place your remarks here.",

        icon: 'warning',
        input: 'textarea',
        inputPlaceholder: "Put remarks",
        showCancelButton: true,
        confirmButtonText: 'Add Remarks',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.value === "") {
          alert("You need to write something")
          return false
        }
        if (result.value) {
          window.location.href = url + "?value="+result.value;
        }
      });
    });
    $(".btn-approved").on('click', function(){
      var url = $(this).data('url');
      var self = $(this)
      Swal.fire({
        title: 'Are you sure you want to approved this application ?',
        text: "You will not be able to undo this action, proceed?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: `Proceed`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          window.location.href = url
        }
      });
    });

    $(".btn-validate").on('click', function(){
      var url = $(this).data('url');
      var self = $(this)
      Swal.fire({
        title: "Input Department Code ",
        
        icon: 'warning',
        input: 'text',
        inputPlaceholder: "Put Department Code",
        showCancelButton: true,
        confirmButtonText: 'Proceed',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.value === "") {
          alert("You need to write something")
          return false
        }
        if (result.value) {
          window.location.href = url + "?department_code="+result.value;
        }
      });
    });

    $('#permit_fee_container').hide();
    $('#electrical_fee_container').hide();
    $('#plumbing_fee_container').hide();
    $('#mechanical_fee_container').hide();
    $('#signboard_fee_container').hide();
    $('#zoning_fee_container').hide();
    $('#certification_fee_cvo_container').hide();
    $('#health_certificate_fee_container').hide();
    $('#certification_fee_tetuan_container').hide();
    $('#garbage_fee_container').hide();
    $('#inspection_fee_container').hide();
    $('#sanitary_inspection_fee_container').hide();
    $('#sticker_container').hide();
    $('#total_amount_container').hide();
    $('#garbage_tax_container').hide();
    $('#business_tax_container').hide();




    $('#input_department_id').select2({placeholder: "Select Department"});
  })
  $('#input_collection_id').change(function() {
        $('#garbage_tax_container').show();
            $('#business_tax_container').show();
      var _text = $("#input_application_id option:selected").text();
      $.getJSON('/collection?collection_id='+this.value, function(result){

          if (result.data['permit_fee'] > 0) {
            $("#permit_fee_container").show();
            $('#permit_fee').text("PHP " + result.data['permit_fee']);
          }
          if (result.data['electrical_fee'] > 0) {
            $("#electrical_fee_container").show();
            $('#electrical_fee').text("PHP " + result.data['electrical_fee']);
          }
          if (result.data['plumbing_fee'] > 0) {
            $("#plumbing_fee_container").show();
            $('#plumbing_fee').text("PHP " + result.data['plumbing_fee']);
          }
          if (result.data['mechanical_fee'] > 0) {
            $("#mechanical_fee_container").show();
            $('#mechanical_fee').text("PHP " + result.data['mechanical_fee']);
          }
          if (result.data['signboard_fee'] > 0) {
            $("#signboard_fee_container").show();
            $('#signboard_fee').text("PHP " + result.data['signboard_fee']);
          }
          if (result.data['zoning_fee'] > 0) {
            $("#zoning_fee_container").show();
            $('#zoning_fee').text("PHP " + result.data['zoning_fee']);
          }
          if (result.data['certification_fee_cvo'] > 0) {

            $("#certification_fee_cvo_container").show();
            $('#certification_fee_cvo').text("PHP " + result.data['certification_fee_cvo']);
          }
          if (result.data['health_certificate_fee'] > 0) {
            $("#health_certificate_fee_container").show();
            $('#health_certificate_fee').text("PHP " + result.data['health_certificate_fee']);
          }
          if (result.data['certification_fee_tetuan'] > 0) {
            $("#certification_fee_tetuan_container").show();
            $('#certification_fee_tetuan').text("PHP " + result.data['certification_fee_tetuan']);
          }
          if (result.data['garbage_fee'] > 0) {
            $("#garbage_fee_container").show();
            $('#garbage_fee').text("PHP " + result.data['garbage_fee']);
          }
          if (result.data['inspection_fee'] > 0) {
            $("#inspection_fee_container").show();
            $('#inspection_fee').text("PHP " + result.data['inspection_fee']);
          }
          if (result.data['sanitary_inspection_fee'] > 0) {
            $("#sanitary_inspection_fee_container").show();
            $('#sanitary_inspection_fee').text("PHP " + result.data['sanitary_inspection_fee']);
          }
          if (result.data['sticker'] > 0) {
            $("#sticker_container").show();
            $('#sticker').text("PHP " + result.data['sticker']);
          }
          if (result.data['total_amount'] > 0) {
            $("#total_amount_container").show();
            $('#total_amount').text("PHP " + result.data['total_amount']);
          }
      });

    }).change();
</script>
@stop
