@extends('web._layouts.main')

@section('content')
<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    @include('system._components.notifications')
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Change Password Form</h4>
                        <p class="card-description">
                            Fill up the <strong class="text-danger">* required</strong> fields.
                        </p>
                        <form class="create-form" method="POST">
                            @include('web._components.notifications')
                            {!!csrf_field()!!}
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="input_password">New Password</label>
                                        <input type="password"
                                            class="form-control {{$errors->first('password') ? 'is-invalid' : NULL}}"
                                            id="input_password" name="password" placeholder="" value="">
                                        @if($errors->first('password'))
                                        <p class="mt-1 text-danger">{!!$errors->first('password')!!}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="input_password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control" id="input_password_confirmation"
                                            name="password_confirmation" placeholder="" value="">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Update Password</button>
                            <a href="{{route('web.business.index')}}" class="btn btn-light">Return to Business</a>
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
    .underline {
        border-bottom: solid 1px;
    }
</style>
@endsection
@section('page-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


@endsection
