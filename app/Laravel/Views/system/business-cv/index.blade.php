@extends('system._layouts.main')

@section('content')
<div class="row p-3">
  <div class="col-12">
    @include('system._components.notifications')
    <div class="row ">
      <div class="col-md-6">
        <h5 class="text-title text-uppercase">{{$page_title}}</h5>
      </div>
      <div class="col-md-6 ">
        <p class="text-dim  float-right">EOR-PHP Processor Portal / Business CV</p>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    {{-- <a href="{{route('system.business_cv.create')}}" class="btn btn-sm btn-primary float-right">Add New</a> --}}
  </div>
  <div class="col-md-12">
    <div class="shadow-sm fs-15 table-responsive ">
      <table class="table table-striped table-wrap" style="table-layout: fixed;">
        <thead>
          <tr>
            <th width="25%" class="text-title p-3">Business Name</th>
            <th width="25%" class="text-title p-3">Created At</th>
            <th width="10%" class="text-title p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($business as $business_cv)
          <tr>
              @if ($business_cv->isNew == 1)
                <td><a href="{{ route('system.business_cv.show', ['id' => $business_cv->id]) }}">{{ $business_cv->business_name .' / '. $business_cv->owner->name}}</a></a> <span class="ml-2 badge badge-success">New</span></td>
              @else
                <td><a href="{{ route('system.business_cv.show', ['id' => $business_cv->id]) }}">{{ $business_cv->business_name .' / '. $business_cv->owner->name}}</a></td>
              @endif
            <td>{{ Helper::date_format($business_cv->created_at)}}</th>
            <td >
              <button type="button" class="btn btn-sm p-0" data-toggle="dropdown" style="background-color: transparent;"> <i class="mdi mdi-dots-horizontal" style="font-size: 30px"></i></button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton2">
                <a class="dropdown-item" href="{{route('system.business_cv.edit',[$business_cv->id])}}">Edit Application</a>
                <a class="dropdown-item action-delete"  data-url="{{route('system.business_cv.destroy',[$business_cv->id])}}" data-toggle="modal" data-target="#confirm-delete">Remove Record</a>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center"><i>No Application Types Records Available.</i></td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
      <nav class="mt-2">
        {!!$business->render()!!}
        </ul>
      </nav>
  </div>
</div>
@stop

@section('page-modals')
<div id="confirm-delete" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm your action</h5>
      </div>

      <div class="modal-body">
        <h6 class="text-semibold">Deleting Record...</h6>
        <p>You are about to delete a record, this action can no longer be undone, are you sure you want to proceed?</p>

        <hr>

        <h6 class="text-semibold">What is this message?</h6>
        <p>This dialog appears everytime when the chosen action could hardly affect the system. Usually, it occurs when the system is issued a delete command.</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
        <a href="#" class="btn btn-sm btn-danger" id="btn-confirm-delete">Delete</a>
      </div>
    </div>
  </div>
</div>
@stop
@section('page-styles')
<style type="text/css" >
  .btn-sm{
    border-radius: 10px;
  }
</style>

@stop

@section('page-scripts')
<script src="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
  $(function(){

    $(".action-delete").on("click",function(){
      var btn = $(this);
      $("#btn-confirm-delete").attr({"href" : btn.data('url')});
    });

  })
</script>
@stop
