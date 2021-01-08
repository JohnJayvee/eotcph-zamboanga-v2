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
        <p class="text-dim  float-right">EOR-PHP Processor Portal / Registrants</p>
      </div>
    </div>
  </div>
  <div class="col-12 ">
    <form>
      <div class="row">
        <div class="col-md-4">
          <label>Status</label>
          {!!Form::select("status", $status_type, $selected_status, ['id' => "input_status", 'class' => "custom-select"])!!}
        </div>
        <div class="col-md-4">
          <label>OTP Verified</label>
          {!!Form::select("otp_verified", $verified, $selected_otp_verified, ['id' => "input_otp_verified", 'class' => "custom-select"])!!}
        </div>
        <div class="col-md-4">
          <label>Date Range</label>
          <div class="input-group input-daterange d-flex align-items-center">
            <input type="text" class="form-control mb-2 mr-sm-2" value="{{$start_date}}" readonly="readonly"
                name="start_date">
            <div class="input-group-addon mx-2">to</div>
            <input type="text" class="form-control mb-2 mr-sm-2" value="{{$end_date}}" readonly="readonly"
                name="end_date">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <label>Keywords</label>
          <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control mb-2 mr-sm-2" id="input_keyword" name="keyword" value="{{ $keyword }}" placeholder="Keyword">
          </div>
        </div>
        <div class="col-md-6 mt-4 p-1">
          <button class="btn btn-primary btn-sm p-2" type="submit">Filter</button>
          <a href="{{route('system.bplo.index')}}" class="btn btn-primary btn-sm p-2">Clear</a>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-12">
    <div class="shadow-sm fs-15 table-responsive ">
      <table class="table table-striped table-wrap" style="table-layout: fixed;">
        <thead>
          <tr>
            <th width="25%" class="text-title p-3">Date Registered</th>
            <th width="25%" class="text-title p-3">Registrant Name</th>
            <th width="25%" class="text-title p-3">Status</th>
            <th width="10%" class="text-title p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($customer as $customers)
          <tr>
            <td>{{ Helper::date_format($customers->created_at)}}</td>
            <td>{{ $customers->name}}</td>
            <td><span class="badge badge-{{ Helper::status_badge($customers->status)}}">{{ ucfirst($customers->status)}}</span></th>
            <td >
              <button type="button" class="btn btn-sm p-0" data-toggle="dropdown" style="background-color: transparent;"> <i class="mdi mdi-dots-horizontal" style="font-size: 30px"></i></button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton2">
                <a class="dropdown-item" href="{{route('system.bplo.edit',[$customers->id])}}">Edit registrant</a>
                <a class="dropdown-item action-delete"  data-url="{{route('system.bplo.destroy',[$customers->id])}}" data-toggle="modal" data-target="#confirm-delete">Remove Record</a>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center"><i>No Registrant Records Available.</i></td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
      <nav class="mt-2">
        {!!$customer->appends(['status' => $selected_status , 'otp_verified' => $selected_otp_verified , 'keyword' => $keyword , 'start_date' => $start_date , 'end_date' => $end_date])->render()!!}
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
    $('.input-daterange').datepicker({
      format : "yyyy-mm-dd"
    });
    $(".action-delete").on("click",function(){
      var btn = $(this);
      $("#btn-confirm-delete").attr({"href" : btn.data('url')});
    });

  })
</script>
@stop
