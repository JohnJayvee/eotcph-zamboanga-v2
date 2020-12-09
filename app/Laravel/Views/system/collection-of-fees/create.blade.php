@extends('system._layouts.main')

@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('system.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{route('system.application.index')}}">Collection of Fees</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add New Collection of Fees</li>
  </ol>
</nav>
@stop

@section('content')
<div class="col-md-8 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Collection of Fees Form</h4>
      <form class="create-form" method="POST" enctype="multipart/form-data">
        @include('system._components.notifications')
        {!!csrf_field()!!}
        <div class="form-group">
            <label for="input_title">Name of Collection</label>
            <input type="text" class="form-control {{$errors->first('collection_name') ? 'is-invalid' : NULL}}" id="input_title"
                name="collection_name" placeholder="Name of Collection" value="{{old('collection_name')}}">
            @if($errors->first('collection_name'))
            <p class="mt-1 text-danger">{!!$errors->first('collection_name')!!}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="input_title">Permit Fee</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="permit_fee" placeholder="Permit Fee" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Electrical Fee</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="electrical_fee" placeholder="Electrical Fee" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Plumbing Fee</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="plumbing_fee" placeholder="Plumbing Fee" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Mechanical Fee</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="mechanical_fee" placeholder="Mechanical Fee" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Sign Board Fee</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="signboard_fee" placeholder="Sign Board Fee" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Zoning Fee / Loc. Clearance Fee</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="zoning_fee" placeholder="Zoning Fee / Loc. Clearance Fee" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Certification Fee (CVO) Fee</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="certification_fee_cvo" placeholder="Certification Fee (CVO) Fee" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Health Certificate Fee</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="health_certificate_fee" placeholder="Health Certificate Fee" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Certification Fee (tetuan)</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="certification_fee_tetuan" placeholder="Certification Fee (tetuan)" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Garbage Fee</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="garbage_fee" placeholder="Garbage Fee" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Inspection Fee</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="inspection_fee" placeholder="Inspection Fee" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Sanitary Inspection Fee</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="sanitary_inspection_fee" placeholder="Sanitary Inspection Fee" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Sticker</label>
            <input type="text" class="form-control {{$errors->first('name') ? 'is-invalid' : NULL}}" id="input_title"
                name="sticker" placeholder="Sticker" value="{{old('name')}}">
            @if($errors->first('name'))
            <p class="mt-1 text-danger">{!!$errors->first('name')!!}</p>
            @endif
        </div>
        <button type="submit" class="btn btn-primary mr-2">Create Record</button>
        <a href="{{route('system.collection_fees.index')}}" class="btn btn-light">Return to Collection of Fees list</a>
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
  span.select2.select2-container{
    width: 100% !important;
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
