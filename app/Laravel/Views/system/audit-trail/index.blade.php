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
        <p class="text-dim  float-right">Zamboanga OBOSS / Audit Logs</p>
      </div>
    </div>
  
  </div>

  <div class="col-12 ">
    <form>
      <div class="row">
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
        <div class="col-md-3 p-2 mt-3">
          <button class="btn btn-primary btn-sm p-2 " type="submit">Filter</button>
          <a href="{{route('system.audit_trail.index')}}" class="btn btn-primary btn-sm p-2">Clear</a>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-12">
    <h4 class="pb-4">Record Data</h4>
    <div class="shadow-sm fs-15 table-responsive">
      <table class="table table-striped table-wrap" style="table-layout: fixed;">
        <thead>
          <tr class="text-center">
            <th class="text-title p-3">#</th>
            <th class="text-title p-3">IP</th>
            <th class="text-title p-3">Description</th>
              <th class="text-title p-3">Process</th>
            <th class="text-title p-3">Created At</th>
          </tr>
        </thead>
        <tbody>
          @forelse($logs as $index)
          <tr class="text-center">
            <td><p class="mb-0">{{$index->id}}</p></td>
            <td><p class="mb-0"><i>{{$index->ip}}</i></p></td>
            <td><p class="mb-0"><i>{{$index->remarks}}</i></p></td>
            <td><p class="mb-0">{{str_replace("_", " ", $index->process)}}</p></td>
            <td><p class="mb-0">{{Helper::date_format($index->created_at)}}</p></td>
          </tr>
          @empty
          <tr>
           <td colspan="5" class="text-center"><i>No Logs Records Available.</i></td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($logs->total() > 0)
    <nav class="mt-2">
      <p>Showing <strong>{{$logs->firstItem()}}</strong> to <strong>{{$logs->lastItem()}}</strong> of <strong>{{$logs->total()}}</strong> entries</p>
      {!!$logs->appends(request()->query())->render()!!}
    </nav>
    @endif
  </div>
</div>
@stop


@section('page-styles')
<link rel="stylesheet" href="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
<style type="text/css" >
  .input-daterange input{ background: #fff!important; }  
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

  })
</script>
@stop
