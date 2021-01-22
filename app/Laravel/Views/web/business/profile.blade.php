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
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <h5 class="text-title text-uppercase mt-3">Business Information
                                    <a href="{{route('web.business.edit')}}" title=""><i class="fas fa-pencil-alt"></i></a>
                                </h5>
                            </div>
                            <div class="col-md-8 d-flex flex-row">
                                <a data-removable="{{ $profile->for_removal ? 'true' : 'false' }}" data-url="{{route('web.business.delete',[$profile->id])}}" class="custom-btn-danger btn-delete btn-danger text-white ml-auto mr-2" >Delete Business CV</a>
                                <a href="{{route('web.business.history',[$profile->id])}}" class="custom-btn badge-primary-2 text-white mr-2" >Application History</a>
                                @if($business_transaction)
                                    @if($business_transaction->status == "APPROVED" )
                                        <a href="{{route('web.business_payment.index',[$profile->id])}}" class="mr-2 custom-btn badge-primary-2 text-white">Business Payment</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="row underline mb-2">
                            <div class="col-md-4 mb-2">
                                <label class="text-uppercase">{{str_replace("_"," ",$profile->business_type)}}</label>
                                <p>Business Type</p>
                            </div>
                             <div class="col-md-3">
                                <label class="text-uppercase">{{str_replace("_"," ",$profile->business_scope)}}</label>
                                <p>Business Scope</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-uppercase">{{$profile->dti_sec_cda_registration_no}}</label>
                                <p>DTI/SEC/CDA registration No</p>
                            </div>
                            <div class="col-md-2">
                                <label class="text-uppercase">{{$profile->business_id_no}}</label>
                                <p>Business ID</p>
                            </div>
                        </div>
                        <div class="row underline mb-2">
                            <div class="col-md-4 mb-2">
                                <label class="text-uppercase">{{$profile->ctc_no}}</label>
                                <p>CTC Number</p>
                            </div>
                             <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->business_tin}}</label>
                                <p>Business TIN</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{now()->parse($profile->dti_sec_cda_registration_date)->format('F d, Y')}}</label>
                                <p>DTI/SEC/CDA Registration Date</p>
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
                            <div class="col-md-4">
                                <label class="text-uppercase"><a href="{{$profile->website_url}}">{{$profile->website_url}}</a></label>
                                <p>Website (URL)</p>
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
                                <label class="text-uppercase">{{$profile->capitalization}}</label>
                                <p>Capitalization</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->business_area}}</label>
                                <p>Business Area</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->tax_incentive}}</label>
                                <p>Tax Incetive</p>
                            </div>
                        </div>
                        <h5 class="text-title text-uppercase mt-4">Owner Details</h5>
                        <div class="row underline mb-2">
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->owner_name}}</label>
                                <p>Name</p>
                            </div>
                            {{-- <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->owner_gender}}</label>
                                <p>Gender</p>
                            </div> --}}
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->owner_email}}</label>
                                <p>Email</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->owner_tin}}</label>
                                <p>TIN</p>
                            </div>
                        </div>
                        <div class="row underline mb-2">
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->owner_brgy_name}}</label>
                                <p>Barangay</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->owner_street ?? "Morning Breeze"}}</label>
                                <p>Street</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->owner_unit_no}}</label>
                                <p>House/Bldg No</p>
                            </div>
                        </div>
                        <h5 class="text-title text-uppercase mt-4">Authorize Representative</h5>
                        <div class="row underline mb-2">
                            <div class="col-md-3">
                                <label class="text-uppercase">{{$profile->rep_full_name}}</label>
                                <p>Name</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-uppercase">{{$profile->rep_gender}}</label>
                                <p>Gender</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-uppercase">{{$profile->rep_position}}</label>
                                <p>Position</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-uppercase">{{$profile->rep_tin}}</label>
                                <p>TIN</p>
                            </div>
                        </div>
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
                        <h5 class="text-title text-uppercase mt-4">Line of Business</h5>
                        <div class="row underline mb-2">
                            @foreach ($business_line as $key => $item)
                                <div class="col-md-4">
                                    <label class="text-uppercase">{{ $item->name }}
                                        @if(!empty($item->particulars) && $item->particulars != "")
                                            <small>({{ $item->particulars }})</small>
                                        @endif
                                    </label>
                                    <p class="text-title">Business Line</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="row underline mb-2">
                            <div class="col-md-3">
                                <label class="text-uppercase">{{$profile->no_of_male_employee}}</label>
                                <p>No. of Male Employee</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-uppercase">{{$profile->no_of_female_employee}}</label>
                                <p>No. of Female Employee</p>
                            </div>
                            <div class="col-md-3">
                                <label>{{$profile->male_residing_in_city}}</label>
                                <p>No. of Male Employees Residing In City</p>
                            </div>
                            <div class="col-md-3">
                                <label>{{$profile->female_residing_in_city}}</label>
                                <p>No. of Female Employees Residing In City</p>
                            </div>
                        </div>
                        <h5 class="text-title text-uppercase mt-4">IF PLACE OF BUSINESS IS RENTED (LESSOR DETAIL)</h5>
                        <div class="row underline mb-2">
                            <div class="col-md-3">
                                <label class="text-uppercase">{{$profile->lessor_fullname}}</label>
                                <p>Name</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-uppercase">{{$profile->lessor_gender}}</label>
                                <p>Gender</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-uppercase">{{$profile->lessor_monthly_rental}}</label>
                                <p>Montly Rental</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-uppercase">{{ now()->parse($profile->lessor_rental_date)->format('F d, Y') }}</label>
                                <p>Rental Date</p>
                            </div>
                        </div>
                        <div class="row underline mb-2">
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->lessor_email}}</label>
                                <p>Email</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->lessor_mobile_no}}</label>
                                <p>Mobile No.</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->lessor_tel_no}}</label>
                                <p>Tel No.</p>
                            </div>
                        </div>
                        <div class="row underline mb-2">
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->lessor_unit_no}}</label>
                                <p>House/Unit No.</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->lessor_street_address}}</label>
                                <p>Street Address</p>
                            </div>
                            <div class="col-md-4">
                                <label>{{$profile->lessor_brgy_name}}</label>
                                <p>Barangay</p>
                            </div>
                        </div>
                        <div class="row underline mb-2">
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->lessor_zipcode}}</label>
                                <p>Zipcode</p>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase">{{$profile->lessor_town_name}}</label>
                                <p>Town/Municipality</p>
                            </div>
                            <div class="col-md-4">
                                <label>{{$profile->lessor_region_name}}</label>
                                <p>Region</p>
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
                        <h5 class="text-title text-uppercase mt-4">Other Information Form (Government Owned Or Controlled Corporations)</h5>
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
                        <h5 class="text-title text-uppercase mt-4">Emergency Contact</h5>
                         <div class="row underline mb-2">
                            <div class="col-md-6">
                                <label class="text-uppercase">{{$profile->emergency_contact_fullname ?: "-"}}</label>
                                <p>Name</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-uppercase">{{$profile->emergency_contact_email ?: "-"}}</label>
                                <p>Email</p>
                            </div>
                        </div>
                         <div class="row underline mb-2">
                            <div class="col-md-6">
                                <label class="text-uppercase">{{$profile->emergency_contact_mobile_no ?: "-" }}</label>
                                <p>Mobile No.</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-uppercase">{{$profile->emergency_contact_tel_no ?: "-"}}</label>
                                <p>Tel No.</p>
                            </div>
                        </div>
                    </div>

                </div>
                <a  href="{{route('web.business.index')}}" class="btn badge-default-2 mt-2" style="float: right;">Return to Dashboard</a>
                <a data-ready="{{ $profile->renewal_ready['flag'] ? 'true' : 'false' }}" data-info="{{  $profile->renewal_ready['last_data'] }}" data-url="{{route('web.business.application.create')}}"  class="btn btn-renew badge-primary-2 mt-2 text-white">Submit For Renewal</a>

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
<script src="{{asset('system/vendors/swal/sweetalert.min.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $(function(){
        $(".btn-delete").on('click', function(){
            var url = $(this).data('url');
            var is_removable = $(this).data('removable');
            var btn = $(this)
            if(is_removable === true){
                Swal.fire({
                    title: 'Are you sure you want to delete this Business CV?',
                    text: "You can't undo this action.",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location.href = url;
                        }
                    })
            }else{
                Swal.fire(
                    'Oops, sorry!',
                    ' You are not allowed to delete this Business CV. There is an existing application connected to this.',
                    'error'
                );
            }
        });

        $(".btn-renew").on('click', function(){
            var url = $(this).data('url');
            var ready = $(this).data('ready');
            var info = $(this).data('info');
            var message = '';
            var title = '';
            switch (info) {
                case "PENDING":
                    message = 'Sorry, you still have a Pending application for approval. Please wait for BPLO Admin\'s Feedback.';
                    title = 'Oops, sorry!';
                    break;
                case "APPROVED":
                    message = 'You still have an active and approved business permit application. You can\'t apply multiple applications in one (1) Business ID. ';
                    title = 'Oops, sorry!';
                    break;
                default:
                    break;
            }
            var btn = $(this)
            if(ready === true){
                window.location.href = url;
            }else{
                Swal.fire(
                    title,
                    message,
                    'error'
                );
            }
        });
    });
</script>

@endsection
