@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
         
         <div class="row flex-row items-center px-4">
            <h5 class="text-title pb-3"><i class="fa fa-file"></i> E<span class="text-title-two"> Community Tax Certificate</span></h5>
            <a href="{{route('web.transaction.create')}}" class="custom-btn badge-primary-2 text-white " style="float: right;margin-left: auto;">E-Community Tax Certificate</a>
         </div>
          
    <div class="card card-rounded shadow-sm">
      <div class="card-body" style="border-bottom: 3px dashed #E3E3E3;">
        <div class="row">
          <div class="col-md-11 d-flex">
            <p class="text-title fw-600 pt-3">Application By: <span class="text-black">{{Str::title($transaction->customer->full_name)}}</span></p>
            <p class="text-title fw-500 pl-3" style="padding-top: 15px;">|</p>
            <p class="text-title fw-600 pt-3 pl-3">Application Sent: <span class="text-black">{{ Helper::date_format($transaction->created_at)}}</span></p>
          </div>
        </div> 
      </div>
     
      <div class="card-body" style="border-bottom: 3px dashed #E3E3E3;">
        <div class="row">
          <div class="col-md-6">
  
            <p class="text-title fw-600 m-1">Applying For: <span class="text-black">{{$transaction->transac_type ? Str::title($transaction->transac_type->name) : "N/A"}} [{{$transaction->code}}] </span></p>
            <p class="text-title fw-600 m-1">Email Address: <span class="text-black">{{$transaction->email}}</span></p>
            <p class="ext-title fw-600 m-1" style="color: #DC3C3B;">Amount: Php {{Helper::money_format($transaction->amount)}}  [{{$transaction->processing_fee_code}}]</p>
            <p class="text-title fw-600 m-1">Application Status:  <span class="badge  badge-{{Helper::status_badge($transaction->status)}} p-1">{{Str::title($transaction->status)}}</span></p>
           
          </div>
          <div class="col-md-6">
            <p class="text-title fw-600 m-1">Contact Number: <span class="text-black">+63{{$transaction->contact_number}}</span></p>
              <p class="text-title fw-600 m-1">Payment Status:  <span class="badge  badge-{{Helper::status_badge($transaction->payment_status)}} p-1">{{Str::title($transaction->payment_status)}}</span></p>
              <p class="text-title fw-600 m-1">Transaction Status:  <span class="badge  badge-{{Helper::status_badge($transaction->transaction_status)}} p-1">{{Str::title($transaction->transaction_status)}}</span></p>
            
          </div>
         
        </div> 
       
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <p class="text-title fw-600 m-1">Community Tax Certificate Type: <span class="text-black">{{ $ctc ? Helper::tax($ctc->tax_type) : ""}}</span></p>
            <p class="text-title fw-600 m-1">Additional Community tax: <span class="text-black">Php {{Helper::money_format($ctc->additional_tax)}}</span></p>
            <p class="text-title fw-600 m-1">Subtotal: <span class="text-black">Php {{Helper::money_format($ctc->subtotal)}}</span></p>
            <p class="text-title fw-600 m-1">Total Amount to Pay: <span class="text-black">Php {{Helper::money_format($ctc->total_amount)}}</span></p>
          </div>
          <div class="col-md-6">
            <p class="text-title fw-600 m-1">Community Tax Due: <span class="text-black">PHP 5.00</span></p>
            <p class="text-title fw-600 m-1">Declared Amount: <span class="text-black">Php {{Helper::money_format(Helper::tax_amount($ctc->transaction_id))}}</span></p>
            <p class="text-title fw-600 m-1">Interest: <span class="text-black">Php {{Helper::money_format($ctc->interest) ?: "0.00"}}</p>
          </div>
         
        </div> 
      </div>
    </div>
    </div>

</section>
<!--team section end-->


@stop
@section('page-styles')
<style type="text/css">
    .custom-btn{
        padding: 5px 10px;
        border-radius: 10px;
        height: 37px;
    }
    .custom-btn:hover{
        background-color: #7093DC !important;
        color: #fff !important;
    }
    .btn-status{
        text-align: center;
        border-radius: 10px;
    }
    .table-font th{
        font-size: 16px;
        font-weight: bold;
    }
    .table-font td{
        font-size: 13px;
        font-weight: bold;
    }
</style>
@endsection
