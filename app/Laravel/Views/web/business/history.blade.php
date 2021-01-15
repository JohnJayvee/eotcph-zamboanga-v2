@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
        <div class="row">
            @include('web.business.business_sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-title text-uppercase mt-3">Business Application History</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-wrap" style="table-layout: fixed;">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-title fs-500 ">Application Date</th>
                                        <th class="text-title  fs-500 ">Application Type</th>
                                        <th class="text-title  fs-500 ">Application No.</th>
                                        <th class="text-title  fs-500 ">Amount/Status</th>
                                        <th class="text-title  fs-500 ">Processor/Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($business_history as $history)
                                        <tr class="text-center">
                                            <td>{{$history->created_at}}</td>
                                            <td>{{$history->application_name}} <br> {{$history->code}}</td>
                                            <td>{{$history->application_permit->application_no}}</td>
                                            <td>{{$history->total_amount}}<br>
                                                <div>
                                                    <span class="badge badge-pill badge-{{Helper::status_badge($history->payment_status)}} p-2">{{Str::upper($history->payment_status)}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="badge badge-pill badge-{{Helper::status_badge($history->status)}} p-2">{{Str::upper($history->status)}}</span>
                                                </div>
                                                @if($history->status == 'APPROVED')
                                                    <div class="mt-1"><p>{{ $history->admin ? $history->admin->full_name : '---' }}</p></div>
                                                @endif
                                          </td>
                                        </tr>
                                    @empty

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

@section('page-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


@endsection
