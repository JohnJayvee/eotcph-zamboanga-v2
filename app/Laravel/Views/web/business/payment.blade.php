@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
  <div class="container">
    <div class="row">
      @include('web.business.business_sidebar')
      <div class="col-md-9">
        <div class="row">
            @include('system._components.notifications')
        </div>
        <div class="card">
            <div class="card-body">
              <div class="row">              <div class="col-md-6">
                  <h5 class="pt-3">Payment Method for {{str::title($profile->business_name)}}</h5>
              </div>
              <div class="col-md-6">
                <div class="btn-group float-right" role="group" aria-label="Basic example">
                  <a href="{{route('web.business_payment.index',[$profile->id])}}?type=regulatory_fee" class="btn btn-primary btn-sm {{$payment_type == "regulatory_fee" ? "active" :""}}">Regulatory Fee</a>
                  <a href="{{route('web.business_payment.index',[$profile->id])}}?type=business_tax" class="btn btn-primary btn-sm {{$payment_type == "business_tax" ? "active" :""}}">Business Tax</a>

                </div>
              </div>
              </div>
            	@if($payment_type == "regulatory_fee")
                <div class="table-responsive pt-2">
                  <table class="table table-bordered table-wrap" style="table-layout: fixed;font-size: 12px;">
                    <thead>
                      <tr class="text-center">
                        <th class="text-title" rowspan="2" style="vertical-align: middle;">Department Name</th>
                        <th class="text-title" rowspan="2" style="vertical-align: middle;">Total Amount</th>
                        <th class="text-title p-3" colspan="2">Breakdown</th>
                      </tr>
                      <tr class="text-center">
                        <th class="text-title p-3">Account Name</th>
                        <th class="text-title p-3">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($regulatory_fee as $fee)
                        <tr class="text-center">
                          <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">{{$fee->department->name}} </td>
                          <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">PHP {{Helper::money_format($fee->amount)}} </td>
                        </tr>
                        @foreach(json_decode($fee->collection_of_fees) as $collection)
                          <tr >
                            <td style="font-size: 12px;" class="p-2">{{$collection->BusinessID}}</td>
                            <td style="font-size: 12px;" class="p-2">PHP {{Helper::money_format($collection->Amount)}}</td>
                          </tr>
                        @endforeach
                      @empty
                        <tr>
                          <td colspan="4" class="text-center"> No Assessment Records Available </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
                @if($transaction)
                  <a href="{{route('web.business_payment.regulatory_payment',[$transaction->id])}}" class="btn btn-primary ">Proceed to Payment</a >
                    <div class="float-right">
                        <a href="{{ route('system.business_transaction.download_assessment', ['id' => $profile->id]) }}" class="btn btn-danger ">Download Assessment Details</a >
                    </div>
                @endif
              @endif
              @if($payment_type == "business_tax")
                <div class="table-responsive pt-2">
                  <table class="table table-bordered table-wrap" style="table-layout: fixed;font-size: 12px;">
                    <thead>
                      <tr class="text-center">
                        <th class="text-title" rowspan="2" style="vertical-align: middle;">Department Name</th>
                        <th class="text-title" rowspan="2" style="vertical-align: middle;">Total Amount</th>
                        <th class="text-title p-3" colspan="2">Breakdown</th>
                      </tr>
                      <tr class="text-center">
                        <th class="text-title p-3">Account Name</th>
                        <th class="text-title p-3">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($business_tax as $fee)
                        <tr class="text-center">
                          <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">{{$fee->department->name}} </td>
                          <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">PHP {{Helper::money_format($fee->amount)}} </td>
                        </tr>
                        @foreach(json_decode($fee->collection_of_fees) as $collection)
                          <tr >
                            <td style="font-size: 12px;" class="p-2">{{$collection->BusinessID}}</td>
                            <td style="font-size: 12px;" class="p-2">PHP {{Helper::money_format($collection->Amount)}}</td>
                          </tr>
                        @endforeach
                      @empty
                        <tr>
                          <td colspan="4" class="text-center"> No Assessment Records Available </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
                <a href="" class="btn btn-primary ">Proceed to Payment</a >

              @endif
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
    .underline {
        border-bottom: solid 1px;
    }
</style>
@endsection
@section('page-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


@endsection
