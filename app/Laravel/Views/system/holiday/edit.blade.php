@extends('system._layouts.main')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('system.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('system.department.index')}}">Holiday Management</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Holiday</li>
  </ol>
</nav>
@stop

@section('content')
<div class="col-md-8 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Holiday Edit Form</h4>
      <form class="create-form" method="POST" enctype="multipart/form-data">
        @include('system._components.notifications')
        {!!csrf_field()!!}
        <div class="form-group">
          <label for="input_title">Name</label>
          <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title" name="name" placeholder="Department Name" value="{{old('name',$holiday->name)}}">
          @if($errors->first('name'))
          <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
          @endif
        </div>
        <div class="form-group">
          <label for="input_title">Date</label>
          <input type="date" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_date" name="date" value="{{old('date',$holiday->date)}}">
          @if($errors->first('code'))
          <p class="mt-1 text-danger">{!!$errors->first('code')!!}</p>
          @endif
        </div>

        <button type="submit" class="btn btn-primary mr-2">Edit Record</button>
        <a href="{{route('system.holiday.index')}}" class="btn btn-light">Return to Holiday list</a>
      </form>
    </div>
  </div>
</div>
@stop

