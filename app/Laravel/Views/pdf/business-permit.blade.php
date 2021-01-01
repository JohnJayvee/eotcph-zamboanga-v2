<!DOCTYPE html>
<html lang="en" style="box-sizing: border-box;font-family: sans-serif;line-height: 1.15;-webkit-text-size-adjust: 100%;-webkit-tap-highlight-color: transparent;">
<head style="box-sizing: border-box;">
    <meta charset="UTF-8" style="box-sizing: border-box;">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" style="box-sizing: border-box;">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" style="box-sizing: border-box;">
    <title style="box-sizing: border-box;">Mayor's Permit</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" style="box-sizing: border-box;">
</head>
<style style="box-sizing: border-box;">
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
<body style="width: 768px!important; height:1024px!important;box-sizing: border-box;margin: 0;font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,&quot;Noto Sans&quot;,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;,&quot;Noto Color Emoji&quot;;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #212529;text-align: left;background-color: #fff;min-width: 992px!important;">
    <div class="container mt-3" style="box-sizing: border-box;width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;margin-top: 1rem!important;min-width: 992px!important;">
        <div class="row d-flex justify-content-between" style="box-sizing: border-box;display: flex!important;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;-ms-flex-pack: justify!important;justify-content: space-between!important;">
            <div class="logo-left" style="box-sizing: border-box;">
                <img src="/web/img/business_permit/ZamboSeal.png" alt="" class="img-logo" style="box-sizing: border-box;vertical-align: middle;border-style: none;page-break-inside: avoid;width: 92px;height: 92px;">
                <div class="group" style="box-sizing: border-box;">
                    <p class="text-warning" style="box-sizing: border-box;margin-top: 5px;margin-bottom: 0px;orphans: 3;widows: 3;text-align: center;font-weight: 600;font-size: 23px;color: #ffc107!important;">17-23635R</p>
                    <label for="" style="box-sizing: border-box;display: inline-block;margin-bottom: .5rem;">Permit Number</label>
                </div>
            </div>
            <div class="head text-center" style="box-sizing: border-box;text-align: center!important;">
                <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 0px;orphans: 3;widows: 3;">Republic of the Philippines</p>
                <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 0px;orphans: 3;widows: 3;">OFFICE OF THE CITY MAYOR</p>
                <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 0px;orphans: 3;widows: 3;"><b style="box-sizing: border-box;font-weight: bolder;">PERMITS and LICENSES DIVISION</b></p>
                <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 0px;orphans: 3;widows: 3;">Zamboanga City</p>
                <h1 class="text-danger" style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 900;line-height: 1.2;font-size: 48px;letter-spacing: -1px;color: #dc3545!important;">MAYOR'S PERMIT</h1>
            </div>
            <div class="logo-right" style="box-sizing: border-box;">
                <img src="/web/img/business_permit/izc.jpg" alt="" class="img-logo" style="box-sizing: border-box;vertical-align: middle;border-style: none;page-break-inside: avoid;width: 92px;height: 92px;">
                <img src="/web/img/business_permit/buildzam.jpg" alt="" class="img-logo" style="box-sizing: border-box;vertical-align: middle;border-style: none;page-break-inside: avoid;width: 92px;height: 92px;">
                <div class="group text-center" style="box-sizing: border-box;text-align: center!important;">
                    <p class="text-orange" style="box-sizing: border-box;margin-top: 5px;margin-bottom: 0px;orphans: 3;widows: 3;color: orange;text-align: center;font-weight: 600;font-size: 23px;">17-23635R</p>
                    <label for="" style="box-sizing: border-box;display: inline-block;margin-bottom: .5rem;">Business Plate No.</label>
                </div>
            </div>
        </div>
        <div class="" style="box-sizing: border-box;">
            <p class="m-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;margin: 0!important;">This certifies that <b style="box-sizing: border-box;font-weight: bolder;">{{ strtoupper($transaction->business_info->owner->name) }}</b></p>
            <p class="m-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;margin: 0!important;">with registered trade name as <b style="box-sizing: border-box;font-weight: bolder;">{{ strtoupper($transaction->business_info->tradename) }}</b></p>
            <p class="m-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;margin: 0!important;">located at <b style="box-sizing: border-box;font-weight: bolder;">{{ strtoupper($transaction->business_info->business_full_address) }}</b></p>
            <p class="m-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;margin: 0!important;">has been granted the PERMIT TO OPERATE the following business/es pursuant to the Revenue Code and Ordinace of the City of Zamboanga.</p>
        </div>
        <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
            <div class="table-responsive" style="box-sizing: border-box;display: block;width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;">
                <table class="table table-bordered text-center" style="box-sizing: border-box;border-collapse: collapse!important;width: 100%;margin-bottom: 1rem;color: #212529;border: 0;text-align: center!important;">
                    <thead style="background-color: red;color: black;box-sizing: border-box;display: table-header-group;">
                        <tr style="box-sizing: border-box;page-break-inside: avoid;">
                            <th width="60%" style="box-sizing: border-box;text-align: inherit;padding: .75rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;border-bottom-width: 2px;background-color: #fff!important;border: 1px solid #dee2e6!important;">KIND OF BUSINESS/ES</th>
                            <th width="40%" colspan="2" style="box-sizing: border-box;text-align: inherit;padding: .75rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;border-bottom-width: 2px;background-color: #fff!important;border: 1px solid #dee2e6!important;">AMOUNT PAID</th>
                        </tr>
                    </thead>
                    <tbody style="box-sizing: border-box;">
                        <tr style="box-sizing: border-box;page-break-inside: avoid;">
                            <td style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;">
                                @foreach ($business_line as $item)
                                <div class="" style="box-sizing: border-box;">
                                    <p class="ml-3 mb-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 0!important;orphans: 3;widows: 3;margin-left: 1rem!important;">{{ $item->line_of_business }}</p>
                                </div>
                                @endforeach
                                <div style="text-align: left!important;box-sizing: border-box;">
                                    <p class="ml-3 mb-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 0!important;orphans: 3;widows: 3;margin-left: 1rem!important;">Conditions:</p>
                                    <p class="ml-3 mb-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 0!important;orphans: 3;widows: 3;margin-left: 1rem!important;">NON COMPLIANCE TO REGULATORY REQUIREMENTS WILL AUTOMATICALLY REVOKE THIS PERMIT.</p>
                                </div>
                            </td>
                            <td style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;">
                                <table class="table table-bordered text-center" style="box-sizing: border-box;border-collapse: collapse!important;width: 100%;margin-bottom: 1rem;color: #212529;border: 1px solid #dee2e6;text-align: center!important;">
                                    <tbody style="box-sizing: border-box;">
                                        @foreach ($regulatory_fee as $reg_fee)
                                            @foreach (json_decode($reg_fee->collection_of_fees) as $value)
                                            <tr style="box-sizing: border-box;page-break-inside: avoid;">
                                                <td rowspan="1" style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;"><p class="ml-3 mb-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 0!important;orphans: 3;widows: 3;margin-left: 1rem!important;">{{ $value->BusinessID }}</p></td>

                                                <td rowspan="1" style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;"><p class="ml-3 mb-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 0!important;orphans: 3;widows: 3;margin-left: 1rem!important;">PHP {{Helper::money_format($value->Amount)}}</p></td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                    <tfoot style="box-sizing: border-box;">
                                        <tr style="box-sizing: border-box;page-break-inside: avoid;">
                                            <td rowspan="1" style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;"><p class="ml-3 mb-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 0!important;orphans: 3;widows: 3;margin-left: 1rem!important;">Total Paid:</p></td>
                                            <td rowspan="1" style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;"><p class="ml-3 mb-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 0!important;orphans: 3;widows: 3;margin-left: 1rem!important;"></p></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
            <div class="col-md-6" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;">
                <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;">The permittee should keep the surroundings clean and in conditions at all times within a radius of five meters. The
                    permittee should provied trash bins within the business premises. THis Permit should be posted conspicuously at the place where the business is being conducted.</p>
                <p class="fw-500 m-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;margin: 0!important;">Owner: <span style="box-sizing: border-box;">{{ $transaction->business_info->owner->name }}</span></p>
                <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
                    <div class="col-md-6" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;">
                        <p class="fw-500 m-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;margin: 0!important;">Date Issued: <span class="ml-2" style="box-sizing: border-box;margin-left: .5rem!important;">{{ now()->format('F d, Y') }}</span></p>
                        <p class="fw-500 m-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;margin: 0!important;">Valid Until: <span class="ml-2" style="box-sizing: border-box;margin-left: .5rem!important;">{{ now()->parse(''.date('Y').'-12-31')->format('F d, Y') }}</span></p>
                        <p class="fw-500 m-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;margin: 0!important;">Business ID No: <span class="ml-2" style="box-sizing: border-box;margin-left: .5rem!important;">{{ $transaction->business_info->business_id_no }}</span></p>
                        {{-- <p class="fw-500 m-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;margin: 0!important;">Type: <span style="box-sizing: border-box;">FATIMA SHANNE SAYADI JAJI</span></p> --}}
                    </div>
                    <div class="col-md-6" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;">
                        <p class="fw-500 m-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;margin: 0!important;">No. of Male Employee: <span class="ml-2" style="box-sizing: border-box;margin-left: .5rem!important;">{{ $transaction->business_info->no_of_male_employee }}</span></p>
                        <p class="fw-500 m-0" style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;margin: 0!important;">No. of Male Employee: <span class="ml-2" style="box-sizing: border-box;margin-left: .5rem!important;">{{ $transaction->business_info->no_of_female_employee }}</span></p>
                        <p class="fw-500 mt-2" style="box-sizing: border-box;margin-top: .5rem!important;margin-bottom: 1rem;orphans: 3;widows: 3;">Printed By: <span class="ml-2" style="box-sizing: border-box;margin-left: .5rem!important;">CLD</span></p>
                    </div>
                </div>

            </div>
            <div class="col-md-6" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;">
                <div class="group pull-right" style="box-sizing: border-box;">
                    <p style="box-sizing: border-box;margin-top: 5px;margin-bottom: 0px;orphans: 3;widows: 3;text-align: center;font-weight: 600;font-size: 23px;">MARIA ISABELLE G. CLIMACO</p>
                    <p style="box-sizing: border-box;margin-top: 5px;margin-bottom: 0px;orphans: 3;widows: 3;text-align: center;font-weight: 600;font-size: 23px;">City Mayor</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
