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
                        <h3>{{ $profile->business_name }} (Sole Proprietorship)</h3>
                        <form method="POST">
                            @include('system._components.notifications')
                            {!!csrf_field()!!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="">Application Forms</label>
                                        <select class="form-control" id="input_application_type" name="application_type">
                                            <option value="" selected="selected">-Choose Business Type-</option>
                                            <option value="business_permit">Business/Mayor's Permit</option>
                                            {{-- <option value="locational_clearance">Locational Clearance</option>
                                            <option value="sanitary_permit">Sanitary Permit</option>
                                            <option value="occupancy_permit">Occupancy Permit</option>
                                            <option value="building_permit">Building Permit</option>
                                            <option value="electrical_permit">Electrical Permit</option>
                                            <option value="mechanical_permit">Mechanical Permit</option>
                                            <option value="anti_fencing_certificate">Anti-Fencing Certificate</option> --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="float-left">
                                        <div class="form-group">
                                            <a href="{{route('web.business.index')}}" class="btn badge-default">Return to Dashboard</a>
                                        </div>
                                    </span>
                                    <div class="float-right">
                                        <div class="form-group">
                                            <button type="submit" class="btn badge-primary-2">Next <i  class="fa fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
