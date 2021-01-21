<!DOCTYPE html>
<html>
<head>
	<title>Business Permit Assessment Details</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<style type="text/css">
    body{
        font-size: 12px;
    }
    @page { size: a4 landscape;}
    .page-break {
        page-break-before: always;
    }
	.text-center{
		text-align: center;
	}
	.text-bold{
		font-weight: bold;
	}
    .head p{
        margin-bottom: 0px;
    }
    .head h1 {
        font-weight: 900;
        font-size: 48px;
        letter-spacing: -1px;
    }
    .border-top {
        border-top:solid 2px #000 !important;
    }
    .border-bottom {
        border-bottom:solid 2px #000 !important;
    }    
    .border-right {
        border-right:solid 2px #000 !important;
    }
    .border-left {
        border-left:solid 2px #000 !important;
    }
</style>
<body>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="head text-center">
                <p>Republic of the Philippines</p>
                <p><b>OFFICE OF THE CITY TREASURER</b></p>
                <p>City of Zamboanga</p>
                <br>
                <p><b>BUSINESS PERMIT ASSESSMENT DETAILS</b></p>
                <p>{{ now()->format('F d, Y') }}</p>
            </div>
        </div>
        <div class="row bg-secondary">
            <div class="col-md-9">
                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-md-3" >Name of Permitee:</div>
                        <div class="col-md-9" style="float: right">{{ strtoupper(Helper::get_owner_name($transaction->business_id)) }}</div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-md-3">Address of Permitee:</div>
                        <div class="col-md-9" style="float: right">{{ strtoupper($transaction->business_info->owner_address) }}</div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-md-3">Business Name:</div>
                        <div class="col-md-9" style="float: right">{{ strtoupper($transaction->business_info->business_name) }}</div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-md-12">
                            Location of Business:<br>
                            <label>{{ strtoupper($transaction->business_info->business_full_address) }}</label></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="float:right">
                <div class="float-right">
                    <div class="form-group mb-0">
                        <div class="row text-center">
                            <div class="col-md-12">Application Number:</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12  text-center">
                                <label style="border: 1px solid; width:100%;">{{ strtoupper($transaction->application_permit->application_no) }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="row text-center">
                            <div class="col-md-12">Bus ID# {{ strtoupper($transaction->business_info->business_id_no) }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12  text-center">
                                <label style="border: 1px solid; width:100%;">RENEWAL</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @php
                $total_to_be_paid = 0;
            @endphp
            <div class="mt-3" style="float:left;width: 100%;">
                <table class="mt-3" style="width: 100%; float:left;">
                    <thead>
                        <tr>
                            <td colspan="2"><label><strong>Regulatory Fees</strong></label></td>
                        </tr>
                        <tr style="text-align:center;">
                            <td width="30%"class="border-top border-bottom border-left">Particulars</td>
                            <td width="30%"class="border-top border-bottom" >Assessed Amount</td>
                            <td width="40%"class="border-top border-bottom border-right" >Remark/s</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $regulatory_total = 0;
                        @endphp
                        @forelse ($regulatory_fees as $rf)
                            <tr>
                                <td colspan="3" class="bg-light p-1"><p class=" mb-0"></p></td>
                            </tr>
                            @php
                                $collection_of_fees = json_decode($rf->collection_of_fees)
                            @endphp
                            @foreach ($collection_of_fees as $fee)
                            <tr>
                                <td><p class="ml-3 mb-0">{{ $fee->Particulars }}</p></td>
                                <td style="text-align: center;">{{ $fee->Amount }}</td>
                            </tr>
                            @php
                                $sub_total = Helper::db_amount($fee->Amount);
                                $regulatory_total += $sub_total;
                            @endphp 
                            @endforeach
                        @empty                            
                        @endforelse
                        @php
                        $total_to_be_paid += $regulatory_total;
                        @endphp 
                        <tr>
                            <td class="text-left pl-4 border-top border-bottom"><b>Total</b></td>
                            <td class="text-right pr-4 border-top border-bottom" colspan="2"><b>{{number_format($regulatory_total,2)}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="page-break"></div>
            <div style="float:left;width: 100%; height:auto">
                <table style="width: 100%; float:left;">
                    <tbody>
                        <tr>
                            <td>
                            <table >
                                <thead>
                                    <tr>
                                        <td colspan="2"><label><strong>Business Tax</strong></label></td>
                                    </tr>
                                    <tr style="border: 2px solid; text-align:center;">
                                        <td width="250" class="border-top border-bottom border-left">Particulars</td>
                                        <td class="border-top border-bottom">Year</td>
                                        <td class="border-top border-bottom" width="150">Gross Sales / Capital / No of Units</td>
                                        <td class="border-top border-bottom">Business Tax</td>
                                        <td class="border-top border-bottom" width="50">Qtr</td>
                                        <td class="border-top border-bottom">Surcharge</td>
                                        <td class="border-top border-bottom">Interest</td>
                                        <td class="border-top border-bottom">Total Amount</td>
                                        <td class="border-top border-bottom border-right">Remarks</td>
                                    </tr>
                                </thead>
                                @if($business_tax)
                                <tbody>
                                    @php
                                        $total_tax = 0;
                                        $collection_of_fees = json_decode($business_tax->collection_of_fees);
                                    @endphp
                                    @foreach ($collection_of_fees as $fee)
                                    
                                        @php  
                                            $surcharge = 0;                
                                            $tax_amount = $fee->Qtr1 == "0" ? Helper::db_amount($fee->TaxAmount1) : 0;
                                            $tax_amount += $fee->Qtr2 == "0" ? Helper::db_amount($fee->TaxAmount2) : 0;
                                            $tax_amount += $fee->Qtr3 == "0" ? Helper::db_amount($fee->TaxAmount3) : 0;
                                            $tax_amount += $fee->Qtr4 == "0" ? Helper::db_amount($fee->TaxAmount4) : 0;
                                            $total_tax += $tax_amount;

                                            if($fee->CYear < Carbon::now()->year){
                                                $surcharge = $tax_amount * 0.25;
                                                $total_tax += $surcharge;
                                            }

                                            $unpaid_quarter_start = 0;
                                                if ($fee->Qtr4 == "0") {
                                                    $unpaid_quarter_start = Carbon::parse($fee->CYear.'-10-01')->floorMonth();
                                                }
                                                if ($fee->Qtr3 == "0") {
                                                    $unpaid_quarter_start = Carbon::parse($fee->CYear.'-07-01')->floorMonth();
                                                }
                                                if ($fee->Qtr2 == "0") {
                                                    $unpaid_quarter_start = Carbon::parse($fee->CYear.'-04-01')->floorMonth();
                                                }
                                                if ($fee->Qtr1 == "0") {
                                                    $unpaid_quarter_start = Carbon::parse($fee->CYear.'-01-01')->floorMonth();
                                                }                                             
                                                $current_month = Carbon::now()->floorMonth(); // returns 2019-06-01
                                                $difference_in_month = $current_month->diffInMonths($unpaid_quarter_start ); 
                                                $interest_percentage = $difference_in_month * 2; 
                                                if ( $interest_percentage < 72){
                                                    $interest_percentage =  $interest_percentage/100;
                                                } else {
                                                    $interest_percentage = 0.72;
                                                }
                                                $interest = $tax_amount*$interest_percentage;
                                                $total_tax += $interest;

                                            $quarter = $fee->Qtr1 == "0" ? "1 " : "";
                                            $quarter .= $fee->Qtr2 == "0" ? "2 " : "";
                                            $quarter .= $fee->Qtr3 == "0" ? "3 " : "";
                                            $quarter .= $fee->Qtr4 == "0" ? "4 " : "";
                                        @endphp
                                        <tr>
                                            <td rowspan="1"><p class="ml-3 mb-0">{{ $fee->Particulars }}</p></td>
                                            <td rowspan="1"><p class="ml-3 mb-0">{{ $fee->CYear }}</p></td>
                                            <td rowspan="1" class="text-right pr-4"><p class="ml-3 mb-0">{{ $fee->GrossSales <= 0 ? $fee->Capital : $fee->GrossSales}}</p></td>
                                            <td rowspan="1" class="text-right pr-4"><p class="ml-3 mb-0">{{ number_format($tax_amount,2) }}</p></td>
                                            <td rowspan="1" class="text-center"><p class="ml-3 mb-0">{{ $quarter }}</p></td>
                                            <td rowspan="1"><p class="text-right ml-3 mb-0">{{number_format($surcharge, 2)}}</p></td>
                                            <td rowspan="1"><p class="ml-3 mb-0">{{number_format($interest,2)}}</td>
                                            <td rowspan="1"><p class="text-right ml-3 mb-0">{{number_format($surcharge + $tax_amount + $interest, 2)}}</td>
                                            <td rowspan="1"><p class="ml-3 mb-0">{{$fee->Remarks}}</td>
                                        </tr>
                                    @endforeach
                                    @php
                                    $total_to_be_paid += $total_tax;
                                    @endphp 
                                    <tr style="text-align:center;">
                                        <td class="text-left pl-4 border-top border-bottom " colspan="7"><b>Total</b></td>
                                        <td class="text-right pr-4 border-top border-bottom "><b>{{number_format($total_tax,2)}}</b></td>
                                        <td class="text-right pr-4 border-top border-bottom "></b></td>
                                    </tr>
                                </tbody>
                                @endif
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="mt-3">
                            <table>
                                <thead>
                                    <tr>
                                        <td colspan="2"><label><strong>Garbage Fee</strong></label></td>
                                    </tr>
                                    <tr style="border: 2px solid; text-align:center;">
                                        <td class="border-top border-bottom border-left">Year</td>
                                        <td class="border-top border-bottom" width="150">Account</td>
                                        <td class="border-top border-bottom">Amount</td>
                                        <td class="border-top border-bottom">Qtr</td>
                                        <td class="border-top border-bottom">Surcharge</td>
                                        <td class="border-top border-bottom border-right">Total Amount</td>
                                    </tr>
                                </thead>
                                @if($garbage_fee)
                                <tbody>
                                    @php
                                        $total_garbage_fee = 0;
                                        $collection_of_fees = json_decode($garbage_fee->collection_of_fees)
                                    @endphp
                                    @foreach ($collection_of_fees as $fee)
                                        @php
                                            $surcharge = 0;
                                            $garbage_amount = $fee->Qtr1 == "0" ? Helper::db_amount($fee->TaxAmount1) : 0;
                                            $garbage_amount += $fee->Qtr2 == "0" ? Helper::db_amount($fee->TaxAmount2) : 0;
                                            $garbage_amount += $fee->Qtr3 == "0" ? Helper::db_amount($fee->TaxAmount3) : 0;
                                            $garbage_amount += $fee->Qtr4 == "0" ? Helper::db_amount($fee->TaxAmount4) : 0;
                                            $total_garbage_fee += $garbage_amount;

                                            if($fee->CYear < Carbon::now()->year){
                                                $surcharge = $garbage_amount * 0.25;
                                                $total_garbage_fee += $surcharge;
                                            }
                                        
                                            $quarter = $fee->Qtr1 == "0" ? "1 " : "";
                                            $quarter .= $fee->Qtr2 == "0" ? "2 " : "";
                                            $quarter .= $fee->Qtr3 == "0" ? "3 " : "";
                                            $quarter .= $fee->Qtr4 == "0" ? "4 " : "";
                                        @endphp
                                        <tr>
                                            <td rowspan="1"><p class="ml-3 mb-0">{{ $fee->CYear }}</p></td>
                                            <td rowspan="1"><p class="ml-3 mb-0">Garbage Fee</p></td>
                                            <td rowspan="1" class="text-right pr-4"><p class="ml-3 mb-0">{{ number_format($garbage_amount,2) }}</p></td>
                                            <td rowspan="1"  class="text-center"><p class="ml-3 mb-0">{{ $quarter }}</p></td>
                                            <td rowspan="1"><p class="ml-3 mb-0 text-right">{{number_format($surcharge,2)}}</p></td>
                                            <td rowspan="1"><p class="ml-3 mb-0 text-right">{{ number_format($surcharge + $garbage_amount,2) }}</td>
                                        </tr>
                                    @endforeach
                                    @php
                                    $total_to_be_paid += $total_garbage_fee;
                                    @endphp 
                                    <tr style="text-align:center;">
                                        <td class="text-left pl-4 border-top border-bottom" colspan="5"><b>Total</b></td>
                                        <td class="text-right pr-4 border-bottom border-top"><b>{{number_format($total_garbage_fee,2)}}</b></td>
                                    </tr>
                                </tbody>
                                @endif
                            </table>
                        </td>
                        </tr>
                        <tr>
                            <td>
                                <h5 class="mt-4">Pay this amount at City Treasurer's Office: <b>P {{number_format($total_to_be_paid,2)}}</b></h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
