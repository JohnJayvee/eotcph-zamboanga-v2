<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mayor's Permit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<style>
    .head p{
        margin-bottom: 0px;
    }
    .head h1 {
        font-weight: 900;
        font-size: 48px;
        letter-spacing: -1px;
    }
    .img-logo{
        width: 92px;
        height: 92px;
    }
    .group p{
        margin-top: 5px;
        margin-bottom: 0px;
        text-align: center;
        font-weight: 600;
        font-size: 23px;
    }
    .text-orange{
        color: orange;
    }
</style>
<body>
    <div class="container mt-3">
        <div class="row d-flex justify-content-between">
            <div class="logo-left">
                <img src="/web/img/business_permit/ZamboSeal.png" alt="" class="img-logo">
                <div class="group">
                    <p class="text-warning">17-23635R</p>
                    <label for="">Permit Number</label>
                </div>
            </div>
            <div class="head text-center">
                <p>Republic of the Philippines</p>
                <p>OFFICE OF THE CITY MAYOR</p>
                <p><b>PERMITS and LICENSES DIVISION</b></p>
                <p>Zamboanga City</p>
                <h1 class="text-danger">MAYOR'S PERMIT</h1>
            </div>
            <div class="logo-right">
                <img src="/web/img/business_permit/izc.jpg" alt="" class="img-logo">
                <img src="/web/img/business_permit/buildzam.jpg" alt="" class="img-logo">
                <div class="group text-center">
                    <p class="text-orange">17-23635R</p>
                    <label for="">Business Plate No.</label>
                </div>
            </div>
        </div>
        <div class="">
            <p class="m-0">This certifies that <b>{{ strtoupper($transaction->business_info->owner->name) }}</b></p>
            <p class="m-0">with registered trade name as <b>{{ strtoupper($transaction->business_info->tradename) }}</b></p>
            <p class="m-0">located at <b>{{ strtoupper($transaction->business_info->business_full_address) }}</b></p>
            <p class="m-0">has been granted the PERMIT TO OPERATE the following business/es pursuant to the Revenue Code and Ordinace of the City of Zamboanga.</p>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead style="background-color: red; color:black;">
                        <tr>
                            <th width="60%">KIND OF BUSINESS/ES</th>
                            <th width="40%" colspan="2">AMOUNT PAID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @foreach ($business_line as $item)
                                <div class="">
                                    <p class="ml-3 mb-0">{{ $item->line_of_business }}</p>
                                </div>
                                @endforeach
                                <div style="text-align:left!important;">
                                    <p class="ml-3 mb-0">Conditions:</p>
                                    <p class="ml-3 mb-0">NON COMPLIANCE TO REGULATORY REQUIREMENTS WILL AUTOMATICALLY REVOKE THIS PERMIT.</p>
                                </div>
                            </td>
                            <td>
                                <table class="table table-bordered text-center">
                                    <tbody>
                                        @foreach ($regulatory_fee as $reg_fee)
                                            @foreach (json_decode($reg_fee->collection_of_fees) as $value)
                                            <tr>
                                                <td rowspan="1"><p class="ml-3 mb-0">{{ $value->BusinessID }}</p></td>

                                                <td rowspan="1"><p class="ml-3 mb-0">PHP {{Helper::money_format($value->Amount)}}</p></td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td rowspan="1"><p class="ml-3 mb-0">Total Paid:</p></td>
                                            <td rowspan="1"><p class="ml-3 mb-0"></p></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>The permittee should keep the surroundings clean and in conditions at all times within a radius of five meters. The
                    permittee should provied trash bins within the business premises. THis Permit should be posted conspicuously at the place where the business is being conducted.</p>
                <p class="fw-500 m-0">Owner: <span>{{ $transaction->business_info->owner->name }}</span></p>
                <div class="row">
                    <div class="col-md-6">
                        <p class="fw-500 m-0">Date Issued: <span class="ml-2">{{ now()->format('F d, Y') }}</span></p>
                        <p class="fw-500 m-0">Valid Until: <span class="ml-2">{{ now()->parse(''.date('Y').'-12-31')->format('F d, Y') }}</span></p>
                        <p class="fw-500 m-0">Business ID No: <span class="ml-2">{{ $transaction->business_info->business_id_no }}</span></p>
                        {{-- <p class="fw-500 m-0">Type: <span>FATIMA SHANNE SAYADI JAJI</span></p> --}}
                    </div>
                    <div class="col-md-6">
                        <p class="fw-500 m-0">No. of Male Employee: <span class="ml-2">{{ $transaction->business_info->no_of_male_employee }}</span></p>
                        <p class="fw-500 m-0">No. of Male Employee: <span class="ml-2">{{ $transaction->business_info->no_of_female_employee }}</span></p>
                        <p class="fw-500 mt-2">Printed By: <span class="ml-2">CLD</span></p>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="group pull-right">
                    <p>MARIA ISABELLE G. CLIMACO</p>
                    <p>City Mayor</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
