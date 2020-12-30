<!DOCTYPE html>
<html>
<head>
	<title>Document Reference Number</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<style type="text/css">
	.text-center{
		text-align: center;
	}
	.text-bold{
		font-weight: bold;
	}
</style>
<body>
<table width="100%" style="margin-bottom: 5em;">
	<tr class="text-center">
		<td style="background-color: #8FAADC;font-size: 25px;font-weight: bold;padding: .5em;border: solid 1px black;">DOCUMENT REFERENCE NUMBER</td>
    </tr>
    <tr>
        <td>Please paste this Document Reference Number on the Landing Page of the ZCBOSS Web Application.</td>
    </tr>
</table>
<table width="100%">
	<tr >
		<td style="border: dashed #0070C0;padding: 1.5em">
			<p class="text-bold" style="font-size: 25px;">Reference #: {{$ref_num}}</p><br><br><br>
			<p style="font-size: 25px;"><b>Application Name:</b> {{Str::title($application_name)}}</p>
			<p style="font-size: 25px;"><b>Remarks:</b> {{Str::title($remarks)}}</p><br><br><br>
			{{-- <p style="font-size: 25px;"><b>Date Generated:</b> {{Helper::date_only($modified_at)}}</p> --}}
			{{-- <p style="font-size: 20px;">List of Declined Requirements:</p> --}}
			{{-- @forelse($attachments as $index)
			<p style="font-size: 20px;">{{$index->original_name}}</p>
			@empty
            @endforelse --}}
<p style="font-size: 25px;">Thank you for choosing <b>ZCBOSS!</b></p>
		</td>
	</tr>
</table>
</body>
</html>
