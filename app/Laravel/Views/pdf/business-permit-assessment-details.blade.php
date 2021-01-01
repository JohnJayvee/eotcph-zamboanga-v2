<!DOCTYPE html>
<html>
<head>
	<title>Business Permit Assessment Details</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<style type="text/css">
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
</style>
<body>
    <div class="container mt-3">
        <div class="row d-flex justify-content-center">
            <div class="head text-center">
                <p>Republic of the Philippines</p>
                <p><b>OFFICE OF THE CITY TREASURER</b></p>
                <p>City of Zamboanga</p>
                <br>
                <p><b>BUSINESS PERMIT ASSESSMENT DETAILS</b></p>
                <p>{{ now()->format('F d, Y') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-md-4">Name of Permitee:</div>
                        <div class="col-md-8">{{ strtoupper($transaction->business_info->owner->name) }}</div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-md-4">Address of Permitee:</div>
                        <div class="col-md-8">{{ strtoupper($transaction->business_info->owner->owner_full_address) }}</div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-md-4">Business Name:</div>
                        <div class="col-md-8">{{ strtoupper($transaction->business_info->business_name) }}</div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-md-4">Location of Business:</div>
                        <div class="col-md-8">{{ strtoupper($transaction->business_info->business_full_address) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
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
            <table style="width: 100%">
                <th>
                    <tr style="border: 2px solid; text-align:center;">
                        <td>Particulars</td>
                        <td>Year</td>
                        <td>Previous Gross Sales</td>
                        <td>Gross Sales / Capital / No of Units</td>
                        <td>Permit Fee</td>
                        <td>Business Tax</td>
                        <td>Qtr</td>
                        <td>Surcharge</td>
                        <td>Interest</td>
                        <td>Remarks</td>
                    </tr>
                </th>
                <tbody>
                    @foreach ($business_activity as $businessactivity)
                        <tr>
                            <td rowspan="1"><p class="ml-3 mb-0">{{ $businessactivity->line_of_business }}</p></td>
                            <td rowspan="1"><p class="ml-3 mb-0">2021</p></td>
                            <td rowspan="1"><p class="ml-3 mb-0">{{ $businessactivity->bGross }}</p></td>
                            <td rowspan="1"><p class="ml-3 mb-0">{{ $businessactivity->gross_sales }}</p></td>
                        </tr>
                        @endforeach
                </tbody>
                <th>
                    <tr style="border-bottom: 2px solid;border-top: 2px solid; text-align:center;">
                        <td colspan="2"><b>Total</b></td>
                        <td colspan="8" style="text-align:right;">Year</td>
                    </tr>
                </th>
            </table>
        </div>
    </div>
</body>
</html>
