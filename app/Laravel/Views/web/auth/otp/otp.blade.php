@extends('web._layouts.main')


@section('content')
<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
         <h5 class="text-title pb-3"><i class="fa fa-pencil-alt"></i> CREATE ACCOUNT</h5>
        <div class="card login-signup-form" style="border-radius: 8px;">
            <div class="card-body registration-card py-0">
                <h5 class="text-title text-uppercase pt-5">Verify</h5>
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-success">Register Success!!</h2>
                    </div>
                </div>
                @if (session('register.progress') == 2)
                @include('web.auth.otp.modal')
                @endif
                @if (session('register.progress') == 3)
                @include('web.auth.otp.success')
                @endif
            </div>
        </div>

    </div>

</section>
<!--team section end-->
<div id="gwt-standard-footer"></div>


@stop

@section('page-styles')
@stop
@section('page-scripts')
<script type="text/javascript">
    $(function(){
        $('.otp-modal').modal('show');
    })
    $('.submitOTP').click(function(e){
        // e.preventDefault();
        var _form = $(this).parents("form")
        $(this).prop('disabled', true)
        $(this).html('Validating... <i class="fa fa-circle-o-notch fa-spin"></i>')
        var otpCode='';
        $('input[type=number]').each(function(){
            otpCode+=this.value;
        });
        $('input[name=code]').val(otpCode);
        _form.submit();
    });
    $('.digit-group').find('input').each(function() {
        $(this).attr('maxlength', 1);
        $(this).on('keyup', function(e) {
            var parent = $($(this).parent());
            if(e.keyCode === 8 || e.keyCode === 37) {
                var prev = parent.find('input#' + $(this).data('previous'));

                if(prev.length) {
                    $(prev).select();
                }
            } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                var next = parent.find('input#' + $(this).data('next'));

                if(next.length) {
                    $(next).select();
                } else {
                    if(parent.data('autosubmit')) {
                        parent.submit();
                    }
                }
            }
        });
    });
</script>

@endsection
