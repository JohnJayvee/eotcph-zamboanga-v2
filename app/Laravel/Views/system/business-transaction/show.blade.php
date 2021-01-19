@extends('system._layouts.main')

@section('content')
<div class="row px-5 py-4">
  <div class="col-12">
    @include('system._components.notifications')
    <div class="row ">
      <div class="col-md-6">
        <h5 class="text-title text-uppercase">{{$page_title}}</h5>
      </div>
      <div class="col-md-6 ">
        <p class="text-dim  float-right">EOR-PHP Processor Portal / Transactions / Transaction Details</p>
      </div>
    </div>
  </div>
  <div class="col-12 pt-4">
    <div class="card card-rounded shadow-sm mb-4">
      <div class="card-body" style="border-bottom: 3px dashed #E3E3E3;">
        <div class="row">
          <div class="col-md-1 text-center">
            <img src="{{asset('system/images/default.jpg')}}" class="rounded-circle" width="100%">
          </div>
          <div class="col-md-8 d-flex">
            <p class="text-title fw-500 pt-3">Application by: <span class="text-black">{{Str::title($transaction->customer ? $transaction->customer->full_name : $transaction->customer_name)}}</span></p>
            <p class="text-title fw-500 pl-3" style="padding-top: 15px;">|</p>
            <p class="text-title fw-500 pt-3 pl-3">Application Sent: <span class="text-black">{{ Helper::date_format($transaction->created_at)}}</span></p>
          </div>
          <div class="col-md-3 d-flex align-items-end flex-column">
            <p class="pull-right badge badge-danger">Checked the I Agree Checkbox</p>
            <!-- <a href="{{ route('system.business_transaction.digital_cerficate', ['id' => $transaction->id]) }}" class="badge badge-info" target="_blank">Release Digital Certificate</a> -->
            @if($transaction->digital_certificate_released == "0" and $transaction->payment_status == "PAID")
              <a class="badge badge-info " href="{{route('system.business_transaction.release',[$transaction->id])}}">Release Digital Certificate</a>
            @endif
            @if($transaction->digital_certificate_released == "1" and $transaction->payment_status == "PAID")
              <a class="badge badge-info " href="{{route('web.e_permit_view',[$transaction->id])}}" target="_blank">View Digital Certificate</a>
            @endif
            @if (!$transaction->business_info)
            <h6 class="text-danger mt-3">BUSINESS CV HAS BEEN DELETED</h6>
            {{-- @if (!empty($transaction->admin_delete))
                <span class="text-muted"> <small>Deleted by: {{ $transaction->admin_delete }}</small></span>
            @endif --}}
            @endif
          </div>
        </div>
      </div>
      <div class="card-body" style="border-bottom: 3px dashed #E3E3E3;">
        @if (in_array(Auth::user()->type, ['admin', 'super_user']))
            <div class="row">
                <a class="btn btn-primary mb-2 border-5 text-white" href="{{ route('system.business_transaction.edit', $transaction->id) }}"><i class="fas fa-info-circle"></i> Edit Information</a>
            </div>
        @endif
        <div class="row">
          <div class="col-md-6">
            <p class="text-title fw-500" style="font-size: 1.2rem;">Application Number: <span class="text-black">{{str::title($transaction->application_permit->application_no)}}</span></p>
            <p class="text-title fw-500">Business Name: <span class="text-black">{{str::title($transaction->business_name)}}</span></p>
            @if ($transaction->business_info)
                <p class="text-title fw-500">Business ID Number: <span class="text-black">{{str::title($transaction->business_info->business_id_no)}}</span></p>
                <p class="text-title fw-500">Dominant Name: <span class="text-black">{{str::title($transaction->business_info->dominant_name)}}</span></p>
                <p class="text-title fw-500">Business Number: <span class="text-black">{{$transaction->business_info->dti_sec_cda_registration_no ?: "-"}}</span></p>
                <p class="text-title fw-500">Cedula Number: <span class="text-black">{{str::title($transaction->business_info->ctc_no)}}</span></p>
                <p class="text-title fw-500">Business Type: <span class="text-black">{{str::title($transaction->business_info->business_type)}}</span></p>
                <p class="text-title fw-500">Business Scope: <span class="text-black">{{str::title($transaction->business_info->business_scope)}}</span></p>
                <p class="text-title fw-500">Business Mobile No.: <span class="text-black"> +63{{$transaction->business_info->mobile_no}}</span></p>
                <p class="text-title fw-500">Business Tel No.: <span class="text-black"> {{$transaction->business_info->telephone_no}}</span></p>
                <p class="text-title fw-500">Business Email: <span class="text-black">{{$transaction->business_info->email}}</span></p>
                <p class="text-title fw-500">Business TIN: <span class="text-black">{{$transaction->business_info->business_tin}}</span></p>
                <p class="text-title fw-500">Is enjoying Tax Incentive from any Government? : <span class="text-black">{{$transaction->business_info->tax_incentive_display}}</span></p>
                <p class="text-title fw-500 mt-3"> OTHER INFORMATION FORM (GOVERNMENT OWNED OR CONTROLLED CORPORATIONS):</p>
                <p class="text-title fw-500">TIN No: <span class="text-black">{{$transaction->business_info->tin_no}}</span></p>
                <p class="text-title fw-500">SSS No: <span class="text-black">{{$transaction->business_info->sss_no}}</span></p>
                <p class="text-title fw-500">Philhealth No: <span class="text-black">{{$transaction->business_info->philhealth_no}}</span></p>
                <p class="text-title fw-500">PAGIBIG No: <span class="text-black">{{$transaction->business_info->pagibig_no}}</span></p>
            @endif

            <p class="text-title fw-500 mt-3">Line of Business :</p>
            <table class="table table-bordered">
              <tr>
                <th>Particulars</th>
                <th>Gross Sales/ Capitalization</th>
               </tr>
                <tbody>
                    @forelse ($business_line as $item)
                    <tr>
                        <td>{{ $item->line_of_business }}</td>
                        <td>{{ number_format($item->gross_sales,2,'.','') > 0 ?  number_format($item->gross_sales,2) : number_format($item->capitalization,2)}}</td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>

          </div>
          @if ($transaction->business_info)
            <div class="col-md-6">
                <p class="text-title fw-500">Trade Name / Franchise: <span class="text-black"> {{$transaction->business_info->tradename}}</span></p>
                <p class="text-title fw-500">DTI/SEC/CDA Registration Date (MM/DD/YYYY): <span class="text-black">{{$transaction->business_info->dti_sec_cda_registration_date}}</span></p>
                <p class="text-title fw-500">Business Capitalization: <span class="text-black">{{$transaction->business_info->capitalization}}</span></p>
                <p class="text-title fw-500">No. of Male Employees: <span class="text-black"> {{$transaction->business_info->no_of_male_employee}}</span></p>
                <p class="text-title fw-500">No. of Male Employees residing in city: <span class="text-black"> {{$transaction->business_info->male_residing_in_city}}</span></p>
                <p class="text-title fw-500">No. of Female Employees: <span class="text-black"> {{$transaction->business_info->no_of_female_employee}}</span></p>
                <p class="text-title fw-500">No. of Female Employees residing in city: <span class="text-black"> {{$transaction->business_info->female_residing_in_city}}</span></p>
                <p class="text-title fw-500">Business Area (Sq. m): <span class="text-black"> {{$transaction->business_info->business_area}}</span></p>
                <p class="text-title fw-500">Business Unit No / Street: <span class="text-black">{{$transaction->business_info->business_address}}</span></p>
                <p class="text-title fw-500">Business Barangay: <span class="text-black"> {{$transaction->business_info->brgy_name}}</span></p>
                <p class="text-title fw-500">Business Province/Town: <span class="text-black"> {{$transaction->business_info->town_name}}</span></p>
                <p class="text-title fw-500">Business Region: <span class="text-black">{{str::title($transaction->business_info->region_name)}}</span></p>
            </div>
          @endif
          <div class="col-md-6 mt-4">
            <p class="text-title fw-500">Transaction Details:</p>
            <p class="text-title fw-500">Application : <span class="text-black">{{str::title($transaction->application_name)}}</span></p>
            <p class="text-title fw-500">Application Status: <span class="badge  badge-{{Helper::status_badge($transaction->status)}} p-2">{{Str::title($transaction->status)}}</span></p>
            <p class="text-title fw-500">Validated By BPLO: <span>{{$transaction->is_validated == 1 ? "Yes" : "No"}}</span></p>
            <!-- <p class="text-title fw-500">Transacation Status: <span class="badge  badge-{{Helper::status_badge($transaction->transaction_status)}} p-2">{{Str::title($transaction->transaction_status)}}</span></p>
            <p class="fw-500" style="color: #DC3C3B;">Processing Fee: Php {{Helper::money_format($transaction->amount) ?: "0" }} [{{$transaction->processing_fee_code}}]</p>
            <p class="text-title fw-500">Payment Status: <span class="badge  badge-{{Helper::status_badge($transaction->payment_status)}} p-2">{{Str::title($transaction->payment_status)}}</span></p> -->
          </div>
          <div class="col-md-6 mt-4">
           <!--  <p class="text-title fw-500">Owners Name: <span class="text-black">{{str::title($transaction->owner ? $transaction->owner->full_name : $transaction->customer_name)}}</span></p>
            <p class="text-title fw-500">Owners Email: <span class="text-black">{{$transaction->owner->email}}</span></p>
            <p class="text-title fw-500">Owners Contact No.: <span class="text-black">{{$transaction->owner->contact_number}}</span></p> -->
            <p class="text-title fw-500">Owners Name: <span class="text-black">{{ strlen($transaction->business_info->owner_name) > 2 ? $transaction->business_info->owner_name : $transaction->business_info->rep_full_name }}</span></p>
            <p class="text-title fw-500">Owners Email: <span class="text-black">{{$transaction->business_info->owner_email ?: $transaction->owner->email }}</span></p>
            <p class="text-title fw-500">Owners Contact No.: <span class="text-black">{{$transaction->business_info->mobile_number ?: $transaction->owner->contact_number}}</span></p>
          </div>
          @if ($transaction->business_info)
            <div class="col-md-6 mt-4">
                <p class="text-title fw-500">Authorize Representative:</p>
                <p class="text-title fw-500">Representative Name: <span class="text-black">{{str::title($transaction->business_info->rep_firstname .' '. $transaction->business_info->rep_middlename .' '. $transaction->business_info->rep_lastname  )}}</span></p>
                <p class="text-title fw-500">Representative Gender: <span class="text-black">{{$transaction->business_info->rep_gender}}</span></p>
                <p class="text-title fw-500">Representative Position: <span class="text-black">{{$transaction->business_info->rep_position}}</span></p>
            </div>
          @endif
        </div>
        @if ($transaction->business_info)
        <div class="row">
            <div class="col-md-6 mt-4">
                <p class="text-title fw-500">Lessor Details:</p>
                <p class="text-title fw-500">Lessor Name: <span class="text-black">{{$transaction->business_info->lessor_fullname}}</span></p>
                <p class="text-title fw-500">Lessor Gender: <span class="text-black">{{ucfirst($transaction->business_info->lessor_gender)}}</span></p>
                <p class="text-title fw-500">Lessor Monthly Rental: <span class="text-black">{{$transaction->business_info->lessor_monthly_rental}}</span></p>
                <p class="text-title fw-500">Lessor Rental Date: <span class="text-black">{{$transaction->business_info->lessor_rental_date}}</span></p>
                <p class="text-title fw-500">Lessor Email: <span class="text-black">{{$transaction->business_info->lessor_email}}</span></p>
                <p class="text-title fw-500">Lessor Mobile #: <span class="text-black">{{$transaction->business_info->lessor_mobile_no}}</span></p>
                <p class="text-title fw-500">Lessor Tel #: <span class="text-black">{{$transaction->business_info->lessor_tel_no ?? '-'}}</span></p>
            </div>
            <div class="col-md-6 mt-4">
                <p class="text-title fw-500">Lessor Details:</p>
                <p class="text-title fw-500">Lessor Unit No / Street: <span class="text-black">{{$transaction->business_info->lessor_unit_no}}</span></p>
                <p class="text-title fw-500">Lessor Barangay: <span class="text-black"> {{$transaction->business_info->lessor_brgy_name}}</span></p>
                <p class="text-title fw-500">Lessor Province/Town: <span class="text-black"> {{$transaction->business_info->lessor_town_name}}</span></p>
                <p class="text-title fw-500">Lessor Region: <span class="text-black">{{str::title($transaction->business_info->lessor_region_name)}}</span></p>
              </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-4">
                <p class="text-title fw-500">Emergency Contact:</p>
                <p class="text-title fw-500">Name: <span class="text-black">{{$transaction->business_info->emergency_contact_fullname}}</span></p>
                <p class="text-title fw-500">Email: <span class="text-black">{{ucfirst($transaction->business_info->emergency_contact_email)}}</span></p>
                <p class="text-title fw-500">Mobile #: <span class="text-black">{{$transaction->business_info->emergency_contact_mobile_no}}</span></p>
                <p class="text-title fw-500">Tel #: <span class="text-black">{{$transaction->business_info->emergency_contact_tel_no}}</span></p>
            </div>
        </div>
        @endif
      </div>
    </div>
    <div class="card card-rounded shadow-sm mb-4">
      <div class="card-body" style="border-bottom: 3px dashed #E3E3E3;">
          <h5 class="text-title text-uppercase">Uploaded Documents</h5>
          <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                      <div class="table-responsive">
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      <td>Uploaded Document</td>
                                      <td>Type</td>
                                      <td>Date Uploaded</td>
                                  </tr>
                              </thead>
                              <tbody>
                                  @forelse ($app_business_permit_file as $file)
                                  <tr>
                                      <td>
                                          <div><strong>{{ strtoupper(str_replace('-', ' ', Helper::resolve_file_name($file->type))) }}</strong></div>
                                          <div><small>File: <strong><a href="{{"{$file->directory}/{$file->filename}"}}" target="_blank">{{$file->filename}}</a></strong></small></div>
                                      </td>
                                      <td>
                                          {{ $file->source }}
                                      </td>
                                      <td>
                                          {{ Helper::date_format($file->created_at)}}
                                      </td>
                                  </tr>
                                  @empty
                                  <tr>
                                      <td class="text-center" colspan="3">
                                          <p>No Document Uploaded.</p>
                                      </td>
                                  </tr>
                                  @endforelse
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <div class="card card-rounded shadow-sm mb-2">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 pt-2">
              <h5 class="text-title text-uppercase">Involved Departments</h5>
            </div>
            <div class="col-md-6">
            @if(in_array(Auth::user()->type , ["admin","super_user"]))
              @if($transaction->department_remarks == NULL and $transaction->department_involved)
                <a data-url="{{route('system.business_transaction.update_department',[$transaction->id])}}"  class="btn btn-primary btn-involved border-5 text-white float-right">Update Department</a>
              @endif
            @endif
            </div>
            <div class="table-responsive pt-2">
              <table class="table table-bordered table-wrap" style="table-layout: fixed;">
                <thead>
                  <tr>
                    <th class="text-title p-3">Department ID</th>
                    <th class="text-title p-3">Department Name</th>
                  </tr>
                </thead>
                <tbody>
                  @if($transaction->department_involved)
                    @foreach(json_decode($transaction->department_involved) as $value)
                    <tr>
                      <td>{{str::title($value)}}</td>
                      <td>{{str::title(Helper::department_name($value))}}</td>
                    </tr>
                    @endforeach
                  @else
                    <tr class="text-center">
                      <td colspan="2">No Remarks Records Available</td>
                    </tr>
                  @endif

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    <div class="card card-rounded shadow-sm mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 pt-2">
            <h5 class="text-title text-uppercase">Assessment Details</h5>
          </div>
          <div class="col-md-6">
            @if(Auth::user()->type == "processor" and $transaction->department_involved)
              @if(in_array(Auth::user()->department->code, json_decode($transaction->department_involved)))
              <a href="{{route('system.business_transaction.assessment',[$transaction->id])}}"  class="btn btn-primary border-5 text-white float-right">Get Assessment Details</a>
              @endif
            @endif
          </div>

          <div class="table-responsive pt-2">
            <p class="text-title text-bold">Regulatory Fee <!-- <span class="badge  badge-{{Helper::status_badge(Helper::check_regulatory($transaction->id))}} p-2">{{Helper::check_regulatory($transaction->id)}}</span> --></p>
            <table class="table table-bordered table-wrap" style="table-layout: fixed;">
              <thead>
                <tr class="text-center">
                  <th class="text-title" rowspan="2" style="vertical-align: middle;">Department Name</th>
                  <th class="text-title" rowspan="2" style="vertical-align: middle;">Total Amount</th>
                  <th class="text-title" rowspan="2" style="vertical-align: middle;">Fee Type</th>

                  <th class="text-title p-3" colspan="3">Breakdown</th>
                </tr>
                <tr class="text-center">
                  <th class="text-title p-3">Office Code</th>
                  <th class="text-title p-3">Account Name</th>
                  <th class="text-title p-3">Amount</th>
                </tr>
              </thead>
              <tbody>
                @forelse($regulatory_fee as $fee)
                  <tr class="text-center">

                    <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">{{$fee->department->name}} </td>
                    <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">PHP {{Helper::money_format($fee->amount)}} </td>
                    <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">{{ Helper::fee_type($fee->fee_type)}} </td>
                  </tr>
                  @foreach(json_decode($fee->collection_of_fees) as $collection)
                    <tr >
                      <td style="font-size: 12px;" class="p-2">{{$collection->OfficeCode}}</td>
                      <td style="font-size: 12px;" class="p-2">{{$collection->BusinessID}}</td>
                      <td style="font-size: 12px;" class="p-2">PHP {{Helper::money_format($collection->Amount)}}</td>
                    </tr>
                  @endforeach
                @empty
                  <tr>
                    <td colspan="5" class="text-center"> No Assessment Records Available </td>
                  </tr>
                @endforelse

              </tbody>
            </table>
          </div>
          <div class="table-responsive pt-3">
            <p class="text-title text-bold">Business Tax Fee</p>
            <table class="table table-bordered table-wrap" style="table-layout: fixed;">
              <thead>
                <tr class="text-center">
                  <th class="text-title" rowspan="2" style="vertical-align: middle;">Department Name</th>
                  <th class="text-title" rowspan="2" style="vertical-align: middle;">Total Amount</th>
                  <th class="text-title" rowspan="2" style="vertical-align: middle;">Fee Type</th>

                  <th class="text-title p-3" colspan="3">Breakdown</th>
                </tr>
                <tr class="text-center">
                  <th class="text-title p-3">Office Code</th>
                  <th class="text-title p-3">Account Name</th>
                  <th class="text-title p-3">Amount</th>
                </tr>
              </thead>
              <tbody>
                @forelse($business_tax as $fee)
                  <tr class="text-center">

                    <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">{{$fee->department->name}} </td>
                    <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">PHP {{Helper::money_format($fee->amount)}} </td>
                    <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">{{ Helper::fee_type($fee->fee_type)}} </td>
                  </tr>
                  @foreach(json_decode($fee->collection_of_fees) as $collection)
                    <tr >
                      <td style="font-size: 12px;" class="p-2">{{$collection->OfficeCode}}</td>
                      <td style="font-size: 12px;" class="p-2">{{$collection->BusinessID}}</td>
                      <td style="font-size: 12px;" class="p-2">PHP {{Helper::money_format($collection->Amount)}}</td>
                    </tr>
                  @endforeach
                @empty
                  <tr>
                    <td colspan="5" class="text-center"> No Business Tax Records Available </td>
                  </tr>
                @endforelse

              </tbody>
            </table>
          </div>
           <div class="table-responsive pt-3">
            <p class="text-title text-bold">Garbage Fee</p>
            <table class="table table-bordered table-wrap" style="table-layout: fixed;">
              <thead>
                <tr class="text-center">
                  <th class="text-title" rowspan="2" style="vertical-align: middle;">Department Name</th>
                  <th class="text-title" rowspan="2" style="vertical-align: middle;">Total Amount</th>
                  <th class="text-title" rowspan="2" style="vertical-align: middle;">Fee Type</th>

                  <th class="text-title p-3" colspan="3">Breakdown</th>
                </tr>
                <tr class="text-center">
                  <th class="text-title p-3">Office Code</th>
                  <th class="text-title p-3">Account Name</th>
                  <th class="text-title p-3">Amount</th>
                </tr>
              </thead>
              <tbody>
                @forelse($garbage_fee as $fee)
                  <tr class="text-center">
                    <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">{{$fee->department->name}} </td>
                    <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">PHP {{Helper::money_format($fee->amount)}} </td>
                    <td rowspan="{{count(json_decode($fee->collection_of_fees)) + 1}}">{{ Helper::fee_type($fee->fee_type)}} </td>
                  </tr>
                  @foreach(json_decode($fee->collection_of_fees) as $collection)
                    <tr >
                      <td style="font-size: 12px;" class="p-2">{{$collection->OfficeCode}}</td>
                      <td style="font-size: 12px;" class="p-2">{{$collection->BusinessID}}</td>
                      <td style="font-size: 12px;" class="p-2">PHP {{Helper::money_format($collection->Amount)}}</td>
                    </tr>
                  @endforeach
                @empty
                  <tr>
                    <td colspan="5" class="text-center"> No Garbage Fee Records Available </td>
                  </tr>
                @endforelse

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-rounded shadow-sm mb-2">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 pt-2">
            <h5 class="text-title text-uppercase">Department Remarks</h5>
          </div>
          <div class="col-md-6">
            @if(Auth::user()->type == "processor" and $transaction->department_involved)
              @if(in_array(Auth::user()->department->code, json_decode($transaction->department_involved)))
                <a data-url="{{route('system.business_transaction.remarks',[$transaction->id])}}"  class="btn btn-primary btn-remarks border-5 text-white float-right">Add Remarks</a>
              @endif
            @endif
          </div>
          <div class="table-responsive pt-2">
            <table class="table table-bordered table-wrap" style="table-layout: fixed;">
              <thead>
                <tr>
                  <th class="text-title p-3">Processor Name</th>
                  <th class="text-title p-3">Department Name</th>
                  <th class="text-title p-3">Remarks</th>
                </tr>
              </thead>
              <tbody>
                @if($transaction->department_remarks)
                  @foreach(json_decode($transaction->department_remarks) as $value)
                  <tr>
                    <td>{{str::title(Helper::processor_name($value->processor_id))}}</td>
                    <td>{{str::title(Helper::department_name($value->id))}}</td>
                    <td>{{str::title($value->remarks)}}</td>
                  </tr>
                  @endforeach
                @else
                  <tr class="text-center">
                    <td colspan="3">No Remarks Records Available</td>
                  </tr>
                @endif

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    @if(in_array(Auth::user()->type, ['admin', 'super_user']) and in_array($transaction->status, ['PENDING', 'ONGOING']))
      @if($transaction->is_validated == 0)
        <a data-url="{{route('system.business_transaction.validate',[$transaction->id])}}?status_type=validate&"  class="btn btn-primary mt-4 btn-validate border-5 text-white {{$transaction->status == 'approved' ? "isDisabled" : ""}}"><i class="fa fa-check-circle"></i> Validate Transactions</a>
        <a data-url="{{route('system.business_transaction.validate',[$transaction->id])}}?status_type=declined&"  class="btn btn-danger mt-4 btn-decline-bplo border-5 text-white {{$transaction->status == 'approved' ? "isDisabled" : ""}}"><i class="fa fa-times-circle"></i> Decline Transactions</a>
      @endif
      @if($transaction->for_bplo_approval == 1)
        <a data-url="{{route('system.business_transaction.process',[$transaction->id])}}?status_type=approved&collection_id={{$transaction->collection_id}}"  class="btn btn-primary mt-4 btn-approved border-5 text-white {{$transaction->status == 'approved' ? "isDisabled" : ""}}"><i class="fa fa-check-circle"></i> Approve Transactions</a>
        <a  data-url="{{route('system.business_transaction.process',[$transaction->id])}}?status_type=declined" class="btn btn-danger mt-4 btn-decline border-5 text-white {{$transaction->status == 'approved' ? "isDisabled" : ""}}""><i class="fa fa-times-circle"></i> Decline Transactions</a>
      @endif
    @endif
  </div>

</div>
@stop



@section('page-styles')
<!-- <link rel="stylesheet" href="{{asset('system/vendors/sweet-alert2/sweetalert2.min.css')}}"> -->
<link rel="stylesheet" href="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('system/vendors/select2/select2.min.css')}}"/>
<style type="text/css" >
  .input-daterange input{ background: #fff!important; }
  .isDisabled{
    color: currentColor;
    display: inline-block;  /* For IE11/ MS Edge bug */
    pointer-events: none;
    text-decoration: none;
    cursor: not-allowed;
    opacity: 0.5;
  }
  .is-invalid{
    border: solid 2px;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice{
    font-size: 18px;
  }
  span.select2.select2-container{
    width: 100% !important;
  }
  textarea.swal2-textarea {
    width: 25em;
  }
</style>
@stop

@section('page-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<!-- <script src="{{asset('system/vendors/sweet-alert2/sweetalert2.min.js')}}"></script> -->
<script src="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('system/vendors/select2/select2.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
  $(function(){
    $('.input-daterange').datepicker({
      format : "yyyy-mm-dd"
    });
    $(".btn-certificate").on('click', function(){
      Swal.fire(
        'COMING SOON',
        'Digital Certificate',
        'info'
      )
    });
    $(".btn-decline").on('click', function(){
      var url = $(this).data('url');
      var self = $(this)
      Swal.fire({
        title: "Please put Remarks in the field below. Are you sure you want to disapprove this application? You can't undo this action.?",
        icon: 'warning',
        input: 'text',
        inputPlaceholder: "Put remarks",
        showCancelButton: true,
        confirmButtonText: 'Decline',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.value === "") {
          alert("You need to write something")
          return false
        }
        if (result.value) {
          window.location.href = url + "&remarks="+result.value;
        }
      });
    });

    $(".btn-decline-bplo").on('click', function(){
      var url = $(this).data('url');
      var self = $(this)
      Swal.fire({
        title: "Please put Remarks in the field below. Are you sure you want to disapprove this application? You can't undo this action.?",
        icon: 'warning',
        input: 'text',
        inputPlaceholder: "Put remarks",
        showCancelButton: true,
        confirmButtonText: 'Decline',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.value === "") {
          alert("You need to write something")
          return false
        }
        if (result.value) {
          window.location.href = url + "&remarks="+result.value;
        }
      });
    });
    $(".btn-remarks").on('click', function(){
      var url = $(this).data('url');
      var self = $(this)
      Swal.fire({
        title: "If you're one of the involved offices for this specific application, please place your remarks here.",
        icon: 'warning',
        input: 'textarea',
        inputPlaceholder: "Put remarks",
        showCancelButton: true,
        confirmButtonText: 'Add Remarks',
        cancelButtonColor: '#d33',
        inputValue: 'Approved',
      }).then((result) => {
        if (result.value === "") {
          alert("You need to write something")
          return false
        }
        if (result.value) {
          window.location.href = url + "?value="+result.value;
        }
      });
    });
    $(".btn-approved").on('click', function(){
      var url = $(this).data('url');
      var btn = $(this)
      Swal.fire({
        title: 'Are you sure you want to approve this application?',
        text: "You will not be able to undo this action, proceed?",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      })
    });
    $(".btn-validate").on('click', function(){
      var url = $(this).data('url');
      var self = $(this)
      Swal.fire({
        title: 'Input Department Code',
        text: 'Use comma(,) as separator',
        content: '<span>test</span>',
        icon: 'warning',
        input: 'text',
        inputPlaceholder: "E.g. 01,02,03,99",
        showCancelButton: true,
        confirmButtonText: 'Proceed',
        cancelButtonColor: '#d33',
      }).then((result) => {
        if (result.value === "") {
          alert("You need to write something")
          return false
        }
        if (result.value) {
          window.location.href = url + "department_code="+result.value;
        }
      });
    });

    $(".btn-involved").on('click', function(){
      var url = $(this).data('url');
      var self = $(this)
      Swal.fire({
        title: 'Input Department Code',
        text: 'Use comma(,) as separator',
        content: '<span>test</span>',
        icon: 'warning',
        input: 'text',
        inputPlaceholder: "E.g. 01,02,03,99",
        showCancelButton: true,
        confirmButtonText: 'Proceed',
        cancelButtonColor: '#d33',
      }).then((result) => {
        if (result.value === "") {
          alert("You need to write something")
          return false
        }
        if (result.value) {
          window.location.href = url + "?department_code="+result.value;
        }
      });
    });
  });

</script>
@stop
