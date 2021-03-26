<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Application from </title>

	<style>
		th.primary{
			background-color: #D4EDDA;
		}
		table, th, td {
		  border-collapse: collapse;
		  padding-left: 20px;
		  padding-right: 20px;
		}

		table.center {
			margin-left:auto;
			margin-right:auto;
			border-bottom: solid 1px #F0F0F0;
			border-right: solid 1px #F0F0F0;
			border-left: solid 1px #F0F0F0;
		}
		.text-white{
			color:#fff;
		}
		.bold{
			font-weight: bolder;
		}
		.text-blue{
			color: #27437D;
		}
		.text-gray{
			color: #848484;
		}
		.bg-white{
			background-color: #fff;
		}
		hr.new2 {
		  border-top: 3px dashed #848484;
		  border-bottom: none;
		  border-left: none;
		  border-right: none;
		}
		#pageElement{display:flex; flex-wrap: nowrap; align-items: center}
	</style>

</head>
<body style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;  font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; margin: 0;">

	<table class="center bg-white" width="55%">

			<tr>
				<th colspan="2" class="primary" style="padding: 25px;">
					<div id="pageElement">
						<div style="float: left;color: #000;padding-left: 30px;">Thank You for using &nbsp;</div>
					  	<div style="padding-right: 30px;"> <img src="{{asset('web/img/oBOSS.png')}}" alt="" style="width: 130px;"> </div>
					</div>
				</th>
			</tr>

			<tr>
				<th colspan="2" class="text-gray" style="padding: 10px;">Date: {{Helper::date_only(Carbon::now())}} | {{Helper::time_only(Carbon::now())}}</th>
			</tr>
			<tr>
				<th colspan="2">
					<p style="float: left;text-align: justify;">Hello {{Str::title($full_name)}}, <p>
				</th>
			</tr>
			<tr>
				<th colspan="2">
					<p style="float: left;">Good day, your application for Community Tax Certificate is now ready for payment.</p>
				</th>
			</tr>

			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Cedula #:</th>
				<th style="text-align: right;">{{$tin_no}}</th>
			</tr>
			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Full Name:</th>
				<th style="text-align: right;">{{Str::title($full_name)}}</th>
			</tr>
			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Tax Certificate Type:</th>
				<th style="text-align: right;">{{Str::title($tax_type)}}</th>
			</tr>

			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Community Tax Due:</th>
				<th style="text-align: right;">{{Helper::money_format($basic_community)}}</th>
			</tr>
			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Additional Community Tax:</th>
				<th style="text-align: right;">{{Helper::money_format($additional_tax)}}</th>
			</tr>
			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Sub Total:</th>
				<th style="text-align: right;">{{Helper::money_format($subtotal)}}</th>
			</tr>
			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Total Amount to Pay:</th>
				<th style="text-align: right;">{{Helper::money_format($total_amount)}}</th>
			</tr>
			
			<tr>
				<th colspan="2">
					<p style="float: left;text-align: justify;">Please visit the City Treasurer's Office to pay for the amount indicated.</p>
				</th>
			</tr>
			<tr>
				<th colspan="2">
					<p style="float: left;text-align: justify;">Thank you!</p>
				</th>
			</tr>

	</table>


</body>
</html>
