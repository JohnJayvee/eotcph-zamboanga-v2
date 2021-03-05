@extends('system._layouts.main')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('system.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('system.department.index')}}">Business Management</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add New Business</li>
  </ol>
</nav>
@stop

@section('content')
<div class="col-md-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Business Create Form</h4>
      <form class="create-form" method="POST" enctype="multipart/form-data">
        @include('system._components.notifications')
        {!!csrf_field()!!}
        <div class="form-group">
          <label for="input_title">Business ID</label>
          <input type="text" class="form-control {{$errors->first('business_id') ? 'is-invalid' : NULL}}" id="input_title" name="business_id" placeholder="Business ID" value="{{old('business_id')}}">
          @if($errors->first('business_id'))
          <p class="mt-1 text-danger">{!!$errors->first('business_id')!!}</p>
          @endif
        </div>

        <button type="submit" class="btn btn-primary mr-2">Proceed</button>
        <a href="{{route('system.department.index')}}" class="btn btn-light">Return to Block List</a>
      </form>
    </div>
  </div>
</div>
@stop

