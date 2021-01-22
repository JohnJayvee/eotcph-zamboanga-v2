@extends('system._layouts.main')

@section('content')
<div class="row p-3">
  <div class="col-12">
    @include('system._components.notifications')
    <div class="row ">
      <div class="col-md-6">
        <h5 class="text-title text-uppercase">{{$page_title}}</h5>
      </div>
      <div class="col-md-6 ">
        <p class="text-dim  float-right">EOR-PHP Processor Portal / Transactions</p>
      </div>
    </div>

  </div>

  <div class="col-12 ">
    <form>
      <div class="row pb-2">

        <div class="col-md-3">
          <label>Application Type</label>
         {!!Form::select("application_id",$applications, $selected_application_id, ['id' => "input_application_id", 'class' => "custom-select"])!!}
        </div>
        <div class="col-md-2">
          <label>Payment Status</label>
          {!!Form::select("processing_fee_status", $status, $selected_processing_fee_status, ['id' => "input_processing_fee_status", 'class' => "custom-select"])!!}
        </div>
        <div class="col-md-2">
          <label>For BPLO Approval</label>
          {!!Form::select("bplo_approval", $approval, $selected_bplo_approval, ['id' => "input_bplo_approval", 'class' => "custom-select"])!!}
        </div>
        <div class="col-md-2">
          <label>Validation</label>
          {!!Form::select("processor", $processor, $selected_processor, ['id' => "input_processor", 'class' => "custom-select"])!!}
        </div>
        <div class="col-md-3">
          <label>Department</label>
          {!!Form::select("department_id", $departments, $selected_department, ['id' => "input_processor", 'class' => "custom-select"])!!}
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 p-2">
          {!!Form::select("attachment_count", $attachment_counts, $selected_attachment_count, ['id' => "input_processor", 'class' => "custom-select"])!!}
        </div>
        <div class="col-md-3 p-2">
          <div class="input-group input-daterange d-flex align-items-center">
            <input type="text" class="form-control mb-2 mr-sm-2" value="{{$start_date}}" readonly="readonly" name="start_date">
            <div class="input-group-addon mx-2">to</div>
            <input type="text" class="form-control mb-2 mr-sm-2" value="{{$end_date}}" readonly="readonly" name="end_date">
          </div>
        </div>
        <div class="col-md-3 p-2">
          <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control mb-2 mr-sm-2" id="input_keyword" name="keyword" value="{{$keyword}}" placeholder="Keyword">
          </div>
        </div>
        <div class="col-md-3 p-2">
          <button class="btn btn-primary btn-sm p-2" type="submit">Filter</button>
          <a href="{{route('system.business_transaction.pending')}}" class="btn btn-primary btn-sm p-2">Clear</a>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-12">
     <a data-url="{{route('system.business_transaction.bulk_assessment')}}"  class="btn btn-primary mb-2 mr-2 btn-assessment border-5 text-white float-right"> Bulk Assessment</a>
     @if(in_array(Auth::user()->type, ['admin', 'super_user']))
      <a data-url="{{route('system.business_transaction.bulk_decline')}}"  class="btn btn-primary mb-2 mr-2 btn-declined border-5 text-white float-right"> Bulk Decline</a>
     @endif
    <div class="shadow-sm fs-15">
      <table class="table table-responsive table-striped table-wrap" style="table-layout: fixed;">
        <thead>
          <tr class="text-center ">
            <th class="text-title p-3" width="15%">Transaction Date</th>
            <th class="text-title p-3" width="15%">Business Name/Owner</th>
            <th class="text-title p-3" width="15%">Application Number</th>
            <th class="text-title p-3" width="30%">Application Type</th>
            <th class="text-title p-3" width="10%">Amount</th>
            <th class="text-title p-3" width="10%">Validation</th>
            <th class="text-title p-3" width="10%">For BPLO Approval</th>
            <th class="text-title p-3" width="10%">Processor/Status</th>
            <th class="text-title p-3" width="10%">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transactions as $transaction)
          @if ($transaction->owner)
            <tr class="text-center">
                <td>{{ Helper::date_format($transaction->created_at)}}</td>
                <td>{{str::title($transaction->business_name)}} /<br>  {{Helper::get_owner_name($transaction->business_id)}}</td>
                <td>{{str::title($transaction->application_permit->application_no)}}</td>
                <td>{{ $transaction->type ? Strtoupper($transaction->type->name) : "N/A"}}<br> {{$transaction->code}}</td>
                <td>
                <div>{{Helper::money_format($transaction->amount) ?: '---'}}</div>
                <div><small><span class="badge badge-pill badge-{{Helper::status_badge($transaction->application_payment_status)}} p-2">{{Str::upper($transaction->application_payment_status)}}</span></small></div>
                <div><small><span class="badge badge-pill badge-{{Helper::status_badge($transaction->application_transaction_status)}} p-2 mt-1">{{Str::upper($transaction->application_transaction_status)}}</span></small></div>
                </td>
                <td>
                <div>
                    <span class="badge badge-pill badge-{{Helper::status_badge($transaction->is_validated == 1 ? "approved" : "pending")}} p-2">{{Str::upper($transaction->is_validated == 1 ? "validated" : 'pending')}} </span>
                    <br>  
                    {{ $transaction->validated_at ? "/".Helper::date_format($transaction->validated_at) : " " }}
                </div>
                </td>
                <td>{{ $transaction->for_bplo_approval == 1 ? "Yes" : "No" }} <br>  {{ $transaction->bplo_approved_at ? "/".Helper::date_format($transaction->bplo_approved_at) : " " }}</td>
                <td>
                <div>
                    <span class="badge badge-pill badge-{{Helper::status_badge($transaction->status)}} p-2">{{Helper::business_transaction_status($transaction->is_validated , $transaction->for_bplo_approval)}}</span>
                </div>
                @if($transaction->status == 'APPROVED')
                    <div class="mt-1"><p>{{ $transaction->admin ? $transaction->admin->full_name : '---' }}</p></div>
                @endif
                </td>
                <td >
                <button type="button" class="btn btn-sm p-0" data-toggle="dropdown" style="background-color: transparent;"> <i class="mdi mdi-dots-horizontal" style="font-size: 30px"></i></button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton2">
                    <a class="dropdown-item" href="{{route('system.business_transaction.show',[$transaction->id])}}">View transaction</a>
                <!--  <a class="dropdown-item action-delete"  data-url="#" data-toggle="modal" data-target="#confirm-delete">Remove Record</a> -->
                </div>
                </td>
            </tr>
          @endif
          @empty
          <tr>
           <td colspan="8" class="text-center"><i>No Transaction Records Available.</i></td>
          </tr>
          @endforelse


        </tbody>
      </table>
    </div>
    @if($transactions->total() > 0)
      <nav class="mt-2">
        <!-- <p>Showing <strong>{{$transactions->firstItem()}}</strong> to <strong>{{$transactions->lastItem()}}</strong> of <strong>{{$transactions->total()}}</strong> entries</p> -->
        {!!$transactions->appends(request()->query())->render()!!}
        </ul>
      </nav>
    @endif
  </div>
</div>
@stop


@section('page-styles')
<link rel="stylesheet" href="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('system/vendors/select2/select2.min.css')}}"/>
<style type="text/css" >
  .input-daterange input{ background: #fff!important; }
  .btn-sm{
    border-radius: 10px;
  }
</style>

@stop

@section('page-scripts')
<script src="{{asset('system/vendors/swal/sweetalert.min.js')}}"></script>
<!-- <script src="{{asset('system/vendors/sweet-alert2/sweetalert2.min.js')}}"></script> -->
<script src="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('system/vendors/select2/select2.min.js')}}" type="text/javascript"></script><script type="text/javascript">


  $(function(){
    $('.input-daterange').datepicker({
      format : "yyyy-mm-dd"
    });

    $(".action-delete").on("click",function(){
      var btn = $(this);
      $("#btn-confirm-delete").attr({"href" : btn.data('url')});
    });


    $(".btn-assessment").on('click', function(){
      var url = $(this).data('url');
      var self = $(this)
      Swal.fire({
        title: 'Input Application Number',
        text: 'Use comma(,) as separator',
        content: '<span>test</span>',
        icon: 'warning',
        input: 'text',
        inputPlaceholder: "E.g. 21-00001-E , 21-00002-E",
        showCancelButton: true,
        confirmButtonText: 'Proceed',
        cancelButtonColor: '#d33',
      }).then((result) => {
        if (result.value === "") {
          alert("You need to write something")
          return false
        }
        if (result.value) {
          window.location.href = url + "?application_no="+result.value;
        }
      });
    });
    $(".btn-declined").on('click', function(){
      var url = $(this).data('url');
      var self = $(this)
      Swal.fire({
            title: 'Input Application Number and Remarks',
            text: 'Use comma(,) as separator',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Proceed',
            cancelButtonColor: '#d33',
            html:
                '<label class="text-title fs-15">Application Number</label><input id="swal-input1" class="swal2-input" placeholder="Application Number: E.g. 21-00001-E , 21-00002-E">' +
                '<label class="text-title fs-15">Remarks</label><textarea id="swal-input2" class="swal2-textarea" row="5"></textarea>',
            preConfirm: function () {
                return new Promise(function (resolve) {
                    // Validate input
                    if ($('#swal-input1').val() == '' || $('#swal-input2').val() == '') {
                        swal.showValidationMessage("Enter a value in both fields"); // Show error when validation fails.
                        swal.enableButtons() // Enable the confirm button again.
                    }else {
                        swal.resetValidationMessage(); // Reset the validation message.
                        resolve([
                            $('#swal-input1').val(),
                            $('#swal-input2').val()
                        ]);
                    }
                })
            },
            onOpen: function () {
                $('#swal-input1').focus()
            }
        }).then(function (result) {
            // If validation fails, the value is undefined. Break out here.
            if (typeof(result.value) == 'undefined') {
                return false;
            }
            if (result.value) {
              window.location.href = url + "?application_no="+result.value[0]+"&remarks="+result.value[1];
            }
        }).catch(swal.noop)
    });

  })
</script>
@stop
