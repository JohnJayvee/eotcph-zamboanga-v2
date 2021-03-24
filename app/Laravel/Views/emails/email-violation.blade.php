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
				<th colspan="2"><p style="float: left;text-align: justify;">Hello Customer {{Str::title($full_name)}}, <p>
					<p style="float: left;text-align: justify;">We have your successfully encoded your violation. Below are the details:</p>
				</th>
			</tr>

			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Ticket #:</th>
				<th style="text-align: right;">{{$ticket_no}}</th>
			</tr>
			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Violator's Full Name:</th>
				<th style="text-align: right;">{{Str::title($full_name)}}</th>
			</tr>
			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Violation Committed:</th>
				<th style="text-align: right;">{{Str::title($violation_name)}}</th>
			</tr>

			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Place of Violation:</th>
				<th style="text-align: right;">{{Str::title($violation_place)}}</th>
			</tr>
			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Date of Violation:</th>
				<th style="text-align: right;">{{Helper::date_only($violation_date)}}</th>
			</tr>
			<tr class="text-blue">
				<th style="text-align: left;padding: 10px;">Amount:</th>
				<th style="text-align: right;">{{Helper::money_format($amount)}}</th>
			</tr>
			
			<tr>
				<th colspan="2">
					<p style="float: left;text-align: justify;">Please visit the City Treasurer's Office to pay for the amount indicated.</p>
				</th>
			</tr>
			<tr>
				<th colspan="2">
					<p style="float: left;text-align: justify;">Note: After payment, please present the Online Receipt or Official Receipt to the City Admin for the release of your License.</p>
				</th>
			</tr>

	</table>


</body>
</html>
