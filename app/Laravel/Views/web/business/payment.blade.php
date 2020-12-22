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
                    <div class="card-body" style="padding: 3em">
                    	<div class="row">
                    		<div class="col-md-6">
                        		<h5 class="pt-3">Payment Method for {{str::title($profile->business_name)}}</h5>
                    		</div>
                    		<div class="col-md-6">
                    			<div class="btn-group float-right" role="group" aria-label="Basic example">
									<a href="{{route('web.business_payment.index',[$profile->id])}}?type=annually" class="btn btn-primary btn-sm {{$payment_type == "anually" ? "active" :""}}">Annually</a>
									<a href="{{route('web.business_payment.index',[$profile->id])}}?type=semi_annually" class="btn btn-primary btn-sm {{$payment_type == "semi_annually" ? "active" :""}}">Semi Annually</a>
									<a href="{{route('web.business_payment.index',[$profile->id])}}?type=quarterly" class="btn btn-primary btn-sm {{$payment_type == "quarterly" ? "active" :""}}">Quarterly</a>
								</div>
                    		</div>
                    		<div class="table-responsive mt-2">
                    			@if($payment_type == "annually")
		                    		<table class="table table-striped table-wrap" style="table-layout: fixed;">
		                    			<thead>
		                    				<tr class="text-center">
		                    					<th class="text-title fs-15 fs-500 p-3" width="25%">Payment</th>
		                    					<th class="text-title fs-15 fs-500 p-3" width="25%">Amount</th>
		                    					<th class="text-title fs-15 fs-500 p-3" width="25%">Status</th>
		                    					<th class="text-title fs-15 fs-500 p-3" width="25%">Action</th>

		                    				</tr>
		                    			</thead>
		                    			<tbody>
		                    				@if($total_amount > 0)
			                    				@foreach(range(1,1) as $index)
			                    					<tr class="text-center">
				                    					<td>Yearly</td>
				                    					<td>PHP {{Helper::money_format($total_amount)}}</td>
				                    					<td>UNPAID</td>
				                    					<td><a href="{{route('web.business_payment.payment',[$id])}}?type=annually&amount={{$total_amount}}" class="btn-sm btn-primary">PAY NOW</a></td>
			                    					</tr>
			                    				@endforeach
			                    			@else
			                    				<tr>
			                    					<td colspan="4">No Record Found</td>
			                    				</tr>
			                    			@endif
		                    			</tbody>
		                    		</table>
	                    		@endif
	                    		@if($payment_type == "semi_annually")
		                    		<table class="table table-striped table-wrap" style="table-layout: fixed;">
		                    			<thead>
		                    				<tr class="text-center">
		                    					<th class="text-title fs-15 fs-500 p-3" width="25%">Payment</th>
		                    					<th class="text-title fs-15 fs-500 p-3" width="25%">Amount</th>
		                    					<th class="text-title fs-15 fs-500 p-3" width="25%">Status</th>
		                    					<th class="text-title fs-15 fs-500 p-3" width="25%">Action</th>

		                    				</tr>
		                    			</thead>
		                    			<tbody>
		                    				@if($total_amount > 0)
			                    				@foreach(range(1,2) as $index)
			                    					<tr class="text-center">
				                    					<td>Q {{$index}}</td>
				                    					<td>PHP {{Helper::money_format($total_amount)}}</td>
				                    					<td>UNPAID</td>
				                    					<td><a href="{{route('web.business_payment.payment',[$id])}}?type=semi_annually&amount={{$total_amount}}" class="btn-sm btn-primary">PAY NOW</a></td>
			                    					</tr>
			                    				@endforeach
		                    				@else
			                    				<tr>
			                    					<td colspan="4">No Record Found</td>
			                    				</tr>
			                    			@endif
		                    			</tbody>
		                    		</table>
	                    		@endif
	                    		@if($payment_type == "quarterly")
		                    		<table class="table table-striped table-wrap" style="table-layout: fixed;">
		                    			<thead>
		                    				<tr class="text-center">
		                    					<th class="text-title fs-15 fs-500 p-3" width="25%">Payment</th>
		                    					<th class="text-title fs-15 fs-500 p-3" width="25%">Amount</th>
		                    					<th class="text-title fs-15 fs-500 p-3" width="25%">Status</th>
		                    					<th class="text-title fs-15 fs-500 p-3" width="25%">Action</th>

		                    				</tr>
		                    			</thead>
		                    			<tbody>
		                    				@if($total_amount > 0)
			                    				@foreach(range(1,4) as $index)
			                    					<tr class="text-center">
				                    					<td>Q {{$index}}</td>
				                    					<td>PHP {{Helper::money_format($total_amount)}}</td>
				                    					<td>UNPAID</td>
				                    					<td><a href="{{route('web.business_payment.payment',[$id])}}?type=quarterly&amount={{$total_amount}}" class="btn-sm btn-primary">PAY NOW</a></td>
			                    					</tr>
			                    				@endforeach
		                    				@else
			                    				<tr>
			                    					<td colspan="4">No Record Found</td>
			                    				</tr>
			                    			@endif
		                    			</tbody>
		                    		</table>
	                    		@endif
                    		</div>
                    	</div>
                    	
                        
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
