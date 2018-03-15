@php
	use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('public/css/print.css') }}">
		<title></title>
		<style type="text/css">
			body{
				font-size: 12px;
			}
			p{
				margin-bottom: 5px !important;
			}

			.items{
				border: 0px !important;
				padding: 2px !important;
			}

			.img-custom{
				max-width: 100%;
				max-height: 250px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<center>
						<p  class="h4">HYATT DIAGNOSTIC SYSTEM INC.</p>
						<p>Main Office: Jaltan Bldg., CM Recto, Davao City, 8000, Philippines</p>
						<p>Tel no: +(63)(82)286-7569 / Email add: hyattdiaginc@gmail.com</p>
					</center>
				</div>
			</div>
			<div class="row">
				<center>
					<p class="h4"><b>RADIOGRAPHY SECTION</b></p>	
				</center>
			</div>
			<div class="row">
				<div class="col-md-8 col-md-offset-1">
					<table class="table" style="margin-top: 80px;">
						<tr>
							<td class="items">File No.</td>
							<td class="items"><b>{{ $xrayResult->file_no }}</b></td>
							<td class="items">Date.</td>
							<td class="items"><b>{{ $xrayResult->date }}</b></td>
						</tr>
						<tr>
							<td class="items">Name: </td>
                        	<td class="items"><b>{{ $xrayResult->customer->fullName }}</b></td>
                        	<td class="items">Age.</td>
							<td class="items"><b>{{ $xrayResult->customer->age }} years old</b></td>
						</tr>
						<tr>
							<td class="items">Examination:</td>
                        	<td class="items"><b>{{ $xrayResult->labResult->name }}</b></td>
                        	<td class="items">Sex:</td>
                        	<td class="items"><b>{{ $xrayResult->customer->gender }}</b></td>
						</tr>
						<tr>
							<td class="items">File No:</td>
                        	<td class="items"><b>{{ $xrayResult->clinical_data }}</b></td>
						</tr>
					</table>
				</div>
				<div class="col-md-2">
					<img src="{{ $xrayResult->customer->photos }}" class="img img-custom">
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<p>
						<span style="padding-left: 50px;"></span>THIS REPORT IS BASED ON RADIOGRAPHIC FINDINGS AND SHOULD BE CORRELATED WITH CLINICAL DATA.<br><br>
						{{ $xrayResult->remarks }}
					</p>

					<p style="margin-top: 30px;">IMPRESSION: <br><br>
						{{ $xrayResult->impression }}
					</p>
				</div>
			</div>
			<div class="row" style="margin-top: 100px;">
				<div class="col-md-offset-1 col-md-5">
					<p class="text-center">
						<b>{{ $xrayResult->radiologistUser->fullName }}</b>
						<br>Radiologist
					</p>
				</div>
				<div class="col-md-5">
					<p class="text-center">
						<b>{{ $xrayResult->preparedUser->fullName }}</b>
						<br>Prepared by
					</p>
				</div>
			</div>
		</div>

	</body>
</html>

