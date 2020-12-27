@extends('web._layouts.main')

@section('content')
<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card login-signup-form" style="border-radius: 8px;">
                    <div class="card-body">
                        <h4 class="card-title">Change Password Form</h4>
                        <p class="card-description">
                            Fill up the <strong class="text-danger">* required</strong> fields.
                        </p>
                        <form class="create-form" method="POST">
                            @include('web._components.notifications')
                            {!!csrf_field()!!}
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Password</label>
                                        <input type="password" class="form-control {{ $errors->first('password') ? 'is-invalid': NULL  }} form-control-sm" name="password" placeholder="Password" id="password-field" value="{{ session('register.password_uncrypt') }}">
                                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        @if($errors->first('password'))
                                            <small class="form-text pl-1" style="color:red;">{{$errors->first('password')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="text-form pb-2">Confirm Password</label>
                                        <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" value="{{ session('register.password_uncrypt') }}">
                                        <span toggle="#password_confirmation" class="fa fa-fw fa-eye field-icon toggle-password"></span>
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
