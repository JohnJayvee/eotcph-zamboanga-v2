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
              <div class="table-responsive pt-2">
                <table class="table table-bordered table-wrap" style="table-layout: fixed;font-size: 12px;">
                  <thead>
                    <th>Quarter</th>
                    <th>Amount</th>
                    <th>SurCharge</th>
                  </thead>
                  <tbody>
                    @forelse($business_tax_payment as $value)
                      <tr>
                        <td>{{$value->quarter}}</td>
                        <td>{{$value->amount}}</td>
                        <td>{{$value->surcharge}}</td>
                      </tr>
                    @empty
                    @endforelse
                  </tbody>
                </table>
              </div>
             <!--  <a href="{{route('web.business_payment.payment',[$transaction_id])}}?quarter={{$quarter}}&type={{$fee_type}}" class="btn btn-primary">Proceed to Checkout</a> -->
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
  .btn-quarter{
    line-height: .1;
  }
</style>
@endsection
@section('page-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


@endsection
