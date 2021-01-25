<!DOCTYPE html>
<html>
<head>
	<title>Mayor's Permit</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css">
		.text-uppercase{
			text-transform: uppercase;
		}
		.text-center{
			text-align: center;
		}
		.lh1{
			line-height: 2px;
		}
		.fs14{
			font-size: 14px;
		}
	</style>
</head>
<body>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td width="10%" class="text-center"><img src="{{ public_path('web/img/zamboanga-official-seal.jpg') }}" width="70%"></td>
			<td width="10%"></td>
			<td width="60%" class="text-center">Republic of the Philippines<br>OFFICE OF THE CITY MAYOR <br><b>PERMITS and LICENSES DIVISION</b> <br> Zamboanga City</td>
			<td width="10%"><img src="{{ public_path('web/img/zbpic2.jpg') }}" width="55%" style="float: right;"></td>
			<td width="10%" class="text-center"><img src="{{ public_path('web/img/zbpic1.jpg') }}" width="60%"></td>
		</tr>
		<tr>
			<td width="10%" class="text-center"><b>{{$business->permit_no}}</b> <br> {{$business->permit_no ? "Permit Number" : ""}}</td>
			<td width="10%"></td>
			<td width="60%" class="text-center"><h1 style="color:#AC314C;">MAYOR'S PERMIT</h1></td>
			<td width="10%"></td>
			<td width="10%" class="text-center"><b>{{$business->business_plate_no}}</b><br> {{$business->business_plate_no ? "Business Plate Number" : ""}} </td>
		</tr>
	</tbody>
</table>
<p class="lh1 fs14">This certifies that <b class="text-uppercase">&nbsp;&nbsp; {{ Helper::get_owner_name($business->id) }}</b></p>
<p class="lh1 fs14">with registered trade name as <b class="text-uppercase">&nbsp;&nbsp;  {{$business->business_name}}</b></p>
<p class="lh1 fs14">located at <b class="text-uppercase">&nbsp;&nbsp;  {{$business->business_full_address}}</b></p>
<p class="lh1 fs14">has granted the PERMIT TO OPERATE the following business/es pursuant to the Revenue Code and Ordinances of the City of Zamboanga.</p>

<table width="100%" border="1" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<td class="text-center text-uppercase" style="background: #AB2D43;color: #ffff;">Kind of Business/es</td>
		</tr>
	</thead>
	<tbody>
		@forelse($business_lines as $business_line)
			<tr>
				<td class="text-center text-uppercase" style="border: none;padding: 5px;">{{$business_line->line_of_business}}</td>
			</tr>
		@empty
		@endforelse
		<tr>
			<td style="border: none;padding: 10px">Conditions: <br>NON-COMPLIANCE TO REGULATORY REQUIREMENTS WILL AUTOMATICALLY REVOKE THIS PERMIT.</td>
		</tr>
	</tbody>
</table>
<p>The Permittee should keep the surroundings clean and in condition at all times within a radius of five meters. The permitee should provide trash bins within the business premises. This Permit should be posted conspicously at the place where the business is being conducted. This is non transferable and is only privilage and not a right. Any Violation of existing laws and ordinances subjects the permit to revocation.</p>

<table width="100%" border="0" cellspacing="0" cellspacing="0" class="fs14">
<tr>
  <td width="60%"> 
  	<table width="100%" border="0" cellspacing="0" cellspacing="0" class="fs14">
			<tbody>
				<tr>
					<td>Owner</td>
					<td class="text-uppercase">{{ Helper::get_owner_name($business->id) }}</td>
				</tr>
				<tr>
					<td>Date Issued</td>
					<td>{{Carbon::parse($business_transaction->or_date)->format('F j, Y')}}</td>
					<td>No. of Male Employee : {{$business->no_of_male_employee}}</td>
				</tr>
				<tr>
					<td>Valid Until</td>
					<td>{{ $d1->format('F j, ').Carbon::now()->year }}</td>
					<td>No. of Female Employee : {{$business->no_of_female_employee}}</td>
				</tr>
				<tr>
					<td>Business ID No.</td>
					<td >{{$business->business_id_no}}</td>
					<td class=""></td>
				</tr>
				<tr>
					<td>Type</td>
					<td>{{$business->permit->type == "renew" ? "Renewal" : "New"}}</td>
				</tr>
			</tbody>
		</table>
	</td>
  	<td width="40%"> 
  		<table width="100%" border="0" cellspacing="0" cellspacing="0" class="fs14">
			<tbody>
				<tr>
					<td class="text-center"><img src="{{ public_path('web/img/e-signature.jpg') }}" width="80%"></td>
				</tr>
				<tr>
					<td class="text-center">MARIA ISABELLE G. CLIMACO </td>
				</tr>
				<tr>
					<td class="text-center">City Mayor</td>
				</tr>
			</tbody>
		</table> 
	</td>
</tr>
</table>

</body>
</html>