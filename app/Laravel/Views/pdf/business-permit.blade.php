<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="logo-left">
                <img src="{{ asset('web/img/business_permit/ZamboSeal.png') }}" alt="" class="img-logo">
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
                <img src="{{ asset('web/img/business_permit/izc.jpg') }}" alt="" class="img-logo">
                <img src="{{ asset('web/img/business_permit/buildzam.jpg') }}" alt="" class="img-logo">
                <div class="group text-center">
                    <p class="text-orange">17-23635R</p>
                    <label for="">Business Plate No.</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead style="background-color: red; color:black;">
                        <tr>
                            <td>KIND OF BUSINESS/ES</td>
                            <td>Amount Paid</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="row">
                                    <p></p>
                                </div>
                                <p>NON COMPLIANCE TO REGULATORY REQUIREMENTS WILL AUTOMATICALLY REVOKE THIS PERMIT</p>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p>The permittee should keep the surroundings clean and in conditions at all times within a radius of five meters. The
                    permittee should provied trash bins within the business premises. THis Permit should be posted conspicuously at the place where the business is being conducted.</p>
                <p class="fw-500 m-0">Owner: <span>FATIMA SHANNE SAYADI JAJI</span></p>
                <div class="row">
                    <div class="col-md-4">
                        <p class="fw-500 m-0">Date Issued: <span class="ml-2">{{ now()->parse('2020-07-27')->format('F d, Y') }}</span></p>
                        <p class="fw-500 m-0">Valid Until: <span class="ml-2">{{ now()->parse('2020-12-31')->format('F d, Y') }}</span></p>
                        <p class="fw-500 m-0">Business ID No: <span class="ml-2">2060722</span></p>
                        {{-- <p class="fw-500 m-0">Type: <span>FATIMA SHANNE SAYADI JAJI</span></p> --}}
                    </div>
                    <div class="col-md-4">
                        <p class="fw-500 m-0">No. of Male Employee: <span class="ml-2">4</span></p>
                        <p class="fw-500 m-0">No. of Male Employee: <span class="ml-2">1</span></p>
                        <p class="fw-500 mt-2">Printed By: <span class="ml-2">CLD</span></p>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <p>Signiture</p>
            </div>
        </div>
    </div>
</body>
</html>
