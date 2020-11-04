@extends('system._layouts.main')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('system.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('system.department.index')}}">Department Management</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add New Department</li>
  </ol>
</nav>
@stop

@section('content')
<div class="col-md-8 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Department Create Form</h4>
      <form class="create-form" method="POST" enctype="multipart/form-data">
        @include('system._components.notifications')
        {!!csrf_field()!!}
            <div class="form-group">
              <label>File</label>
              <input type="file" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" name="file" value="{{old('file')}}" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
              @if($errors->first('file'))
              <span class="help-block" style="color: red">{{$errors->first('file')}}</span>
              @endif
            </div>

            <p class="help-block">Please download the <a href="{{asset('template/template.xlsx')}}"><strong>mass upload template(.xls) <i class="fa fa-download"></i> </strong></a> template to upload bulk Department.</p>

        <button type="submit" class="btn btn-primary mr-2">Create Record</button>
        <a href="{{route('system.department.index')}}" class="btn btn-light">Return to Department list</a>
      </form>
    </div>
  </div>
</div>
@stop

