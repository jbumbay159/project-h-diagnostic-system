<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="{{ asset('public/css/print.css') }}">
	<title>Vaccine</title>
	<style type="text/css">
		@media print {
		.gcc {
		    font-weight: bold; 
		    color: #f9fd0f;
		    -webkit-print-color-adjust: exact ; 
		}}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p class="text-center h4" style="margin-bottom: 0px;">HYATT DIAGNOSTICE SYSTEM INC.</p>
				<p class="text-center" style="margin-bottom: 0px;">Main Office: Jaltan Bldg. CM Recto Davao city, 8000, Philippines</p>
				<p class="text-center" style="margin-bottom: 0px;">Tel No: +(63)(82) 286-7569</p>
				<p class="text-center">Email Address: <a href="#">hyattdiaginc@gmail.com</a></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<p class="text-center h4 gcc" style="font-weight: bold; color: #f9fd0f !important;">GCC CODE: 03/03/04</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<p class="text-center h4" style="font-weight: bold;">
					MEASLES, MUMPS, RUBELLA (MMR)</br>
					VACCINATION CERTIFICATE
				</p>
			</div>
		</div>
		<div class="row" style="margin-top: 20px;">
			<div class="col-md-offset-1 col-md-10">
				<img src="{{ $vaccine->customer->photos }}" width="150px" style="float: left;margin-right: 35px;">
				<p style="text-align: justify; padding: 25px;line-height: 25px;font-size: 18px;">
					This is to certify the <b> Mr. {{ $vaccine->customer->fullName }} </b> of
					legal age, <b>{{ $vaccine->current_age }} years old</b> has undergone vaccination in <b>LIVE
					ATTENUATED VIRUS VACCINE</b> against Measles, Mumps and Rubella (GERMAN MEASLES).
				</p>
			</div>
		</div>
		<div class="row" style="margin-top: 75px;">
			<div class="col-md-offset-1 col-md-10">
				<table>
					<tr>
						<td width="120px"><b>Brand Name</b></td>
						<td>: {{ $vaccine->brand_name }} </td>
					</tr>
					<tr>
						<td><b>Lot No.</b></td>
						<td>: {{ $vaccine->lot_no }} </td>
					</tr>
					<tr>
						<td><b>Expiry Date</b></td>
						<td>: {{ $vaccine->expiry_date }} </td>
					</tr>
					<tr>
						<td><b>Date Given</b></td>
						<td>: {{ $vaccine->dateGivenName }} </td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row" style="margin-top: 50px;">
			<div class="col-md-offset-1 col-md-10">
				<p class="h5">ADMINISTERED BY:</p>
				<p style="padding-top: 30px;">
					<b>{{ $vaccine->nurse_name }}</b><br>
					LIC. NO. {{ $vaccine->lic_no }}
				</p>
			</div>
		</div>
	</div>

</body>
</html>