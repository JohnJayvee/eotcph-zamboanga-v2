@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">

        <div class="row">
            @include('web.business.business_sidebar')
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        @include('system._components.notifications')
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-title text-uppercase">Please Select A Business Profile You Want To Display</h5>
                        <p class="text-danger"><b>ATTENTION:</b> One (1) Business ID can be used to one (1) Business CV. Multiple use of Business ID is not allowed.</p>
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
