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
        <p class="text-dim  float-right">Zamboanga OBOSS / Block List</p>
      </div>
    </div>
  
  </div>

  <div class="col-12 ">
    <form>
      <div class="row">
        <div class="col-md-3 p-2">
          <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control mb-2 mr-sm-2" id="input_keyword" name="keyword" value="{{$keyword}}" placeholder="Keyword">
          </div>
        </div>
        <div class="col-md-3 p-2">
          <button class="btn btn-primary btn-sm p-2" type="submit">Filter</button>
          <a href="{{route('system.block_list.index')}}" class="btn btn-primary btn-sm p-2">Clear</a>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-12">
    <h4 class="pb-4">Record Data
      <span class="float-right">
        <a href="{{route('system.block_list.create')}}" class="btn btn-sm btn-primary">Block Business</a>
      </span>
    </h4>
    <div class="table-responsive shadow-sm fs-15">
      <table class="table table-striped table-wrap" style="table-layout: fixed;">
        <thead>
          <tr class="text-center">
            <th class="text-title p-3">Business ID </th>
            <th class="text-title p-3">Blocked At</th>
            <th class="text-title p-3">Blocked By </th>
            <th class="text-title p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($block_lists as $index => $block_list)
          <tr class="text-center">
            <td>{{ $block_list->business_id}}</td>
            <td>{{ Helper::date_format($block_list->blocked_at)}}</td>
            <td>{{ $block_list->blocked_by ? $block_list->admin->full_name : "---"}}</td>
          </tr>
          @empty
          <tr>
           <td colspan="4" class="text-center"><i>No Records Available.</i></td>
          </tr>
          @endforelse
          
        </tbody>
      </table>
    </div>
    @if($block_lists->total() > 0)
    <nav class="mt-2">
      <p>Showing <strong>{{$block_lists->firstItem()}}</strong> to <strong>{{$block_lists->lastItem()}}</strong> of <strong>{{$block_lists->total()}}</strong> entries</p>
      {!!$block_lists->appends(request()->query())->render()!!}
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
   

    $(".action-delete").on("click",function(){
      var btn = $(this);
      $("#btn-confirm-delete").attr({"href" : btn.data('url')});
    });

  })
</script>
@stop