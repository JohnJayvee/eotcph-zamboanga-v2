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
            <input type="text" class="form-control {{$errors->first('permit_fee') ? 'is-invalid' : NULL}}" id="input_permit_fee" name="permit_fee" placeholder="Permit Fee" value="{{old('permit_fee')}}">
            @if($errors->first('permit_fee'))
            <p class="mt-1 text-danger">{!!$errors->first('permit_fee')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Electrical Fee</label>
            <input type="text" class="form-control {{$errors->first('electrical_fee') ? 'is-invalid' : NULL}}" id="input_electrical_fee" name="electrical_fee" placeholder="Electrical Fee" value="{{old('name')}}">
            @if($errors->first('electrical_fee'))
            <p class="mt-1 text-danger">{!!$errors->first('electrical_fee')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Plumbing Fee</label>
            <input type="text" class="form-control {{$errors->first('plumbing_fee') ? 'is-invalid' : NULL}}" id="input_plumbing_fee" name="plumbing_fee" placeholder="Plumbing Fee" value="{{old('plumbing_fee')}}">
            @if($errors->first('plumbing_fee'))
            <p class="mt-1 text-danger">{!!$errors->first('plumbing_fee')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Mechanical Fee</label>
            <input type="text" class="form-control {{$errors->first('mechanical_fee') ? 'is-invalid' : NULL}}" id="input_mechanical_fee" name="mechanical_fee" placeholder="Mechanical Fee" value="{{old('mechanical_fee')}}">
            @if($errors->first('mechanical_fee'))
            <p class="mt-1 text-danger">{!!$errors->first('mechanical_fee')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Sign Board Fee</label>
            <input type="text" class="form-control {{$errors->first('signboard_fee') ? 'is-invalid' : NULL}}" id="input_signboard_fee" name="signboard_fee" placeholder="Sign Board Fee" value="{{old('signboard_fee')}}">
            @if($errors->first('signboard_fee'))
            <p class="mt-1 text-danger">{!!$errors->first('signboard_fee')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Zoning Fee / Loc. Clearance Fee</label>
            <input type="text" class="form-control {{$errors->first('zoning_fee') ? 'is-invalid' : NULL}}" id="input_zoning_fee" name="zoning_fee" placeholder="Zoning Fee / Loc. Clearance Fee" value="{{old('zoning_fee')}}">
            @if($errors->first('zoning_fee'))
            <p class="mt-1 text-danger">{!!$errors->first('zoning_fee')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Certification Fee (CVO) Fee</label>
            <input type="text" class="form-control {{$errors->first('certification_fee_cvo') ? 'is-invalid' : NULL}}" id="input_certification_fee_cvo" name="certification_fee_cvo" placeholder="Certification Fee (CVO) Fee" value="{{old('certification_fee_cvo')}}">
            @if($errors->first('certification_fee_cvo'))
            <p class="mt-1 text-danger">{!!$errors->first('certification_fee_cvo')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Health Certificate Fee</label>
            <input type="text" class="form-control {{$errors->first('health_certificate_fee') ? 'is-invalid' : NULL}}" id="input_health_certificate_fee" name="health_certificate_fee" placeholder="Health Certificate Fee" value="{{old('health_certificate_fee')}}">
            @if($errors->first('health_certificate_fee'))
            <p class="mt-1 text-danger">{!!$errors->first('health_certificate_fee')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Certification Fee (tetuan)</label>
            <input type="text" class="form-control {{$errors->first('certification_fee_tetuan') ? 'is-invalid' : NULL}}" id="input_certification_fee_tetuan" name="certification_fee_tetuan" placeholder="Certification Fee (tetuan)" value="{{old('certification_fee_tetuan')}}">
            @if($errors->first('certification_fee_tetuan'))
            <p class="mt-1 text-danger">{!!$errors->first('certification_fee_tetuan')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Garbage Fee</label>
            <input type="text" class="form-control {{$errors->first('garbage_fee') ? 'is-invalid' : NULL}}" id="input_garbage_fee" name="garbage_fee" placeholder="Garbage Fee" value="{{old('garbage_fee')}}">
            @if($errors->first('garbage_fee'))
            <p class="mt-1 text-danger">{!!$errors->first('garbage_fee')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Inspection Fee</label>
            <input type="text" class="form-control {{$errors->first('inspection_fee') ? 'is-invalid' : NULL}}" id="input_inspection_fee" name="inspection_fee" placeholder="Inspection Fee" value="{{old('inspection_fee')}}">
            @if($errors->first('inspection_fee'))
            <p class="mt-1 text-danger">{!!$errors->first('inspection_fee')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Sanitary Inspection Fee</label>
            <input type="text" class="form-control {{$errors->first('sanitary_inspection_fee') ? 'is-invalid' : NULL}}" id="input_sanitary_inspection_fee" name="sanitary_inspection_fee" placeholder="Sanitary Inspection Fee" value="{{old('sanitary_inspection_fee')}}">
            @if($errors->first('sanitary_inspection_fee'))
            <p class="mt-1 text-danger">{!!$errors->first('sanitary_inspection_fee')!!}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="input_title">Sticker</label>
            <input type="text" class="form-control {{$errors->first('sticker') ? 'is-invalid' : NULL}}" id="input_sticker" name="sticker" placeholder="Sticker" value="{{old('sticker')}}">
            @if($errors->first('sticker'))
            <p class="mt-1 text-danger">{!!$errors->first('sticker')!!}</p>
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
