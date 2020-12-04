@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
        <div class="row">
            @include('web.business.business_sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body" style="padding: 3em">
                        <h5 class="text-title text-uppercase">Business Information</h5>
                        <div class="row underline mb-2">
                            <div class="col-md-4 mb-2">
                                <label class="text-uppercase">{{str_replace("_"," ",$profile->business_type)}}</label>
                                <p>Business Type</p>
                            </div>
                             <div class="col-md-4">
                                <label class="text-uppercase">{{str_replace("_"," ",$profile->business_scope)}}</label>
                                <p>Business Scope</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->bn_number}}</label>
                                <p>BN Number</p>
                            </div>
                        </div>
                        <div class="row underline mb-2">
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->dominant_name}}</label>
                                <p>Dominant Name</p>
                            </div>
                             <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->business_name}}</label>
                                <p>Business Name</p>
                            </div>

                        </div>
                        <div class="row underline mb-2">
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->mobile_no}}</label>
                                <p>Mobile Number</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->telephone_no}}</label>
                                <p>Telephone Number</p>
                            </div>
                            <div class="col-md-4">
                                <label>{{$profile->email}}</label>
                                <p>Email Address</p>
                            </div>

                        </div>
                        <div class="row underline mb-2">
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->business_line}}</label>
                                <p>Line of Business</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->capitalization}}</label>
                                <p>Capitalization</p>
                            </div>
                            <div class="col-md-4">
                                <label>{{$profile->no_of_employee}}</label>
                                <p>No. of Employee</p>
                            </div>

                        </div>
                        <h5 class="text-title text-uppercase mt-4">Business Address Information</h5>
                        <div class="row underline mb-2">
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->unit_no}}</label>
                                <p>House/Unit No.</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->street_address}}</label>
                                <p>Street Address</p>
                            </div>
                            <div class="col-md-4">
                                <label>{{$profile->brgy_name}}</label>
                                <p>Barangay</p>
                            </div>

                        </div>
                        <div class="row underline mb-2">
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->zipcode}}</label>
                                <p>Zipcode</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->town_name}}</label>
                                <p>Town/Municipality</p>
                            </div>
                            <div class="col-md-4">
                                <label>{{$profile->region_name}}</label>
                                <p>Region</p>
                            </div>
                        </div>
                        <h5 class="text-title text-uppercase mt-4">Business Address Information</h5>
                         <div class="row underline mb-2">
                            <div class="col-md-6">
                                <label class="text-uppercase">{{$profile->sss_no ?: "-"}}</label>
                                <p>SSS Number</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-uppercase">{{$profile->philhealth_no ?: "-"}}</label>
                                <p>Philhealth Number</p>
                            </div>

                        </div>
                         <div class="row underline mb-2">
                            <div class="col-md-6">
                                <label class="text-uppercase">{{$profile->tin_no ?: "-" }}</label>
                                <p>TIN Number</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-uppercase">{{$profile->pagibig_no ?: "-"}}</label>
                                <p>PAGIBIG Number</p>
                            </div>

                        </div>
                    </div>

                </div>
                <a href="{{route('web.business.index')}}" class="btn badge-default-2 mt-2" style="float: right;">Return to Dashboard</a>
                <a href="{{route('web.business.application.create')}}" class="btn badge-primary-2 mt-2">Apply New Permit</a>

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
