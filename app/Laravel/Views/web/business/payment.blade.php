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
                    	
                    	
                        		<h5 class="">Payment Method for {{str::title($profile->business_name)}}</h5>
                    	
                    	<div class="table-responsive pt-2">
            <table class="table table-bordered table-wrap" style="table-layout: fixed;">
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
                    <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">PHP {{Helper::money_format($fee->total_amount)}} </td>
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
