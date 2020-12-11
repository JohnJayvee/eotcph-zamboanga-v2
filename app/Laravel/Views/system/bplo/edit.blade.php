@extends('system._layouts.main')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('system.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('system.application.index')}}">Registrants</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit {{ $customer->collection_name }}</li>
  </ol>
</nav>
@stop

@section('content')
<div class="col-md-8 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Registrants</h4>
        <form class="create-form" method="POST" enctype="multipart/form-data">
          @include('system._components.notifications')
          {!!csrf_field()!!}
          <div class="form-group">
              <label for="input_title">Registrant Name</label>
              <p class="text-title">{{ $customer->name }}</p>
          </div>

          <div class="form-group">
            <label for="input_title">Status</label>
            <select name="status" class="form-control" >
                <option value="approved">Approved</option>
                <option value="pending">Pending</option>
                <option value="declined">Declined</option>
            </select>
        </div>

          <button type="submit" class="btn btn-primary mr-2">Update Record</button>
          <a href="{{route('system.bplo.index')}}" class="btn btn-light">Return to Registrants list</a>
        </form>
      </div>
    </div>
  </div>
@stop

@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('system/vendors/select2/select2.min.css')}}"/>
<style type="text/css">
  .is-invalid{
    border: solid 2px;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice{
    font-size: 18px;
  }
</style>
@endsection

@section('page-scripts')
<script src="{{asset('system/vendors/select2/select2.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $('#input_requirements_id').select2({placeholder: "Select Requirements"});
    });//document ready
</script>
@endsection
