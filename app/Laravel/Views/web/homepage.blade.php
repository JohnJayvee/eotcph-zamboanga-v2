@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="team-section ptb-120 home-bg ">
    <div class="container">
        @include('web._components.notifications')
        <div class="row ">
            <div class="col-md-4 col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <h5 style="letter-spacing: 3px;"><i class="fa fa-file"></i> E<span class="font-weight-lighter">SUBMISSION</span></h5>
                        </div>
                        <div class="col-lg-12">
                            <a href="{{ route('web.business.index') }}" data-url="" class="btn btn-white btn-submission"> <i class="fa fa-laptop"></i> Submit</a>
                        </div>
                    </div>

                    <div class="col-lg-12">

                        <form method="GET" action={{ route('web.upload') }} class="mb-3">
                            <div class="col-lg-12 pt-2">
                               <input type="text" name="code" class="form-control input-transparent" placeholder="Enter Document Reference Code">
                            </div>
                            <div class="col-lg-12 pt-2">
                               <button class="btn btn-white" type="submit"><i class="fa fa-money-bill"></i> RESUBMISSION</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-12">
                         <div class="col-lg-12 pt-4">
                            <h5 style="letter-spacing: 3px;"><i class="fa fa-calculator"></i> E<span class="font-weight-lighter">PAYMENT</span></h5>
                        </div>
                        <form method="GET" action={{ route('web.pay') }}>
                            <div class="col-lg-12 pt-2">
                               <input type="text" name="code" class="form-control input-transparent" placeholder="Enter Transaction Code">
                            </div>
                            <div class="col-lg-12 pt-2">
                               <button class="btn btn-white" type="submit"><i class="fa fa-money-bill"></i> Pay</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-12">
                        <div class="col-lg-12 pt-4">
                            <h5 style="letter-spacing: 3px;"><i class="fa fa-th-large"></i> REQUEST<span class="font-weight-lighter"> EOR</span></h5>
                        </div>
                        <form method="GET" action={{ route('web.request-eor') }}>
                            <div class="col-lg-12 pt-2">
                               <input type="text" name="code" class="form-control input-transparent" placeholder="Enter Transaction Code">
                            </div>
                            <div class="col-lg-12 pt-2">
                               <input type="email" name="email" class="form-control input-transparent" placeholder="Enter Email Address">
                            </div>
                            <div class="col-lg-12 pt-4">
                                <button class="btn btn-white" type="submit"><i class="fa fa-file"></i> Request </button>
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
@section('page-styles')
<style type="text/css">
    .input-transparent{
        color:#fff;
    }
    body{
        padding: 0px !important;
    }
</style>
@endsection
@section('page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{asset('system/vendors/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script type="text/javascript">

    // $(".btn-submission").on('click', function(){
    //     var url = $(this).data('url');
    //     var self = $(this);

    //     (async () => {

    //     const {value: type} = await Swal.fire({
    //         title: 'Please choose a transaction',
    //         text: 'Are you applying for?',
    //         input: 'select',
    //         inputOptions: {
    //             'e_submission': 'E-Submissions',
    //             'ctc': 'Community Tax Certificate'
    //         },
    //         inputPlaceholder: 'Select Type',
    //         showCancelButton: true,

    //     })
    //     if (type) {
    //         window.location.href = url + "?type="+type;
    //     }
    //     })()

    // });

    </script>
@stop
