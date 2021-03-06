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
        <p class="text-dim  float-right">Zamboanga OBOSS / Transactions</p>
      </div>
    </div>

  </div>

  <div class="col-12 ">
    <form>
      <div class="row pb-2">

        <div class="col-md-4">
          <label>Application Type</label>
         {!!Form::select("application_id",$applications, $selected_application_id, ['id' => "input_application_id", 'class' => "custom-select"])!!}
        </div>
        <div class="col-md-4">
          <label>Payment Status</label>
          {!!Form::select("processing_fee_status", $status, $selected_processing_fee_status, ['id' => "input_processing_fee_status", 'class' => "custom-select"])!!}
        </div>
        <div class="col-md-4">
          <label>Department</label>
          {!!Form::select("department_id", $departments, $selected_department, ['id' => "input_processor", 'class' => "custom-select"])!!}
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 p-2">
          <div class="input-group input-daterange d-flex align-items-center">
            <input type="text" class="form-control mb-2 mr-sm-2" value="{{$start_date}}" readonly="readonly" name="start_date">
            <div class="input-group-addon mx-2">to</div>
            <input type="text" class="form-control mb-2 mr-sm-2" value="{{$end_date}}" readonly="readonly" name="end_date">
          </div>
        </div>
        <div class="col-md-4 p-2">
          <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control mb-2 mr-sm-2" id="input_keyword" name="keyword" value="{{$keyword}}" placeholder="Keyword">
          </div>
        </div>
        <div class="col-md-4 p-2">
          <button class="btn btn-primary btn-sm p-2" type="submit">Filter</button>
          <a href="{{route('system.business_transaction.declined')}}" class="btn btn-primary btn-sm p-2">Clear</a>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-12">
    <div class="shadow-sm fs-15 table-responsive">
      <table class="table table-striped table-wrap" style="table-layout: fixed;" id="data-table">
        <thead>
          <tr class="text-center ">
            <th class="text-title p-3">Transaction Date</th>
            <th class="text-title p-3 no-sort">Business Name/Owner</th>
            <th class="text-title p-3 no-sort">Application Number</th>
            <th class="text-title p-3 no-sort">Application Type</th>
            <th class="text-title p-3 no-sort">Amount</th>
            <th class="text-title p-3 no-sort">Processor/Status</th>
            <th class="text-title p-3 no-sort">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transactions as $transaction)
          @if ($transaction->owner)
          <tr class="text-center">
            <td>{{ Helper::date_format($transaction->created_at)}}</td>
            <td>{{str::title($transaction->business_name)}} /<br>  {{Helper::get_owner_name($transaction->business_id)}}</td>
            <td>{{str::title($transaction->application_permit->application_no)}}</td>
            <td>{{ $transaction->type ? Strtoupper($transaction->type->name) : "N/A"}}<br> {{$transaction->code}}</td>
            <td>
              <div>{{Helper::money_format($transaction->amount) ?: 0 }}</div>
              <div><small><span class="badge badge-pill badge-{{Helper::status_badge($transaction->payment_status)}} p-2">{{Str::upper($transaction->payment_status)}}</span></small></div>
              <div><small><span class="badge badge-pill badge-{{Helper::status_badge($transaction->transaction_status)}} p-2 mt-1">{{Str::upper($transaction->transaction_status)}}</span></small></div>
            </td>
            <td>
              <div>
                <span class="badge badge-pill badge-{{Helper::status_badge($transaction->status)}} p-2">{{Str::upper($transaction->status)}}</span>
              </div>
              @if($transaction->status == 'DECLINED')
                <div class="mt-1"><p>{{ $transaction->admin ? $transaction->admin->full_name : '---' }}</p></div>
                <br>
                {{ $transaction->proccessed_at ? "/".Helper::date_format($transaction->proccessed_at) : " " }}
              @endif
            </td>
            <td >
              <button type="button" class="btn btn-sm p-0" data-toggle="dropdown" style="background-color: transparent;"> <i class="mdi mdi-dots-horizontal" style="font-size: 30px"></i></button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton2">
                <a class="dropdown-item" href="{{route('system.business_transaction.show',[$transaction->id])}}">View transaction</a>
               <!--  <a class="dropdown-item action-delete"  data-url="#" data-toggle="modal" data-target="#confirm-delete">Remove Record</a> -->
              </div>
            </td>
          </tr>
          @endif
          @empty
          <tr>
           <td colspan="8" class="text-center"><i>No transaction Records Available.</i></td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($transactions->total() > 0)
      <nav class="mt-2">
        <!-- <p>Showing <strong>{{$transactions->firstItem()}}</strong> to <strong>{{$transactions->lastItem()}}</strong> of <strong>{{$transactions->total()}}</strong> entries</p> -->
        {!!$transactions->appends(request()->query())->render()!!}
        </ul>
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
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  $.fn.get_application_type = function(department_id,input_purpose,selected){
        $(input_purpose).empty().prop('disabled',true)
        $(input_purpose).append($('<option>', {
                  value: "",
                  text: "Loading Content..."
              }));
        $.getJSON( "{{route('web.get_application_type')}}?department_id="+department_id, function( result ) {
            $(input_purpose).empty().prop('disabled',true)
            $.each(result.data,function(index,value){
              // console.log(index+value)
              $(input_purpose).append($('<option>', {
                  value: index,
                  text: value
              }));
            })

            $(input_purpose).prop('disabled',false)
            $(input_purpose).prepend($('<option>',{value : "",text : "--Choose Application Type--"}))

            if(selected.length > 0){
              $(input_purpose).val($(input_purpose+" option[value="+selected+"]").val());

            }else{
              $(input_purpose).val($(input_purpose+" option:first").val());
              //$(this).get_extra(selected)
            }
        });
        // return result;
    };

  $(function(){
    $('.input-daterange').datepicker({
      format : "yyyy-mm-dd"
    });

    $(".action-delete").on("click",function(){
      var btn = $(this);
      $("#btn-confirm-delete").attr({"href" : btn.data('url')});
    });

    $("#input_department_id").on("change",function(){
      var department_id = $(this).val()
      var _text = $("#input_department_id option:selected").text();
      $(this).get_application_type(department_id,"#input_application_id","")
      $('#input_department_name').val(_text);
    })
    
    $('#data-table').DataTable({
      "searching": false,
      "paging":false,
      "info":false,
      "order": [],
      "columnDefs": [ {
        "targets"  : 'no-sort',
        "orderable": false,
      }]
    });

  })
</script>
@stop
