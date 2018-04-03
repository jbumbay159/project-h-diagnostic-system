@php
	use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('public/css/print.css') }}">
		<title>Hyatt System Generated Report</title>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-offset-3 col-md-6">
					<h3 class="text-center">COMPANY NAME</h3>
					<h4 class="text-center">Company Address</h4>
					<hr>
					<h4 class="text-center">Date Covered: {{ $date_from }} - {{ $date_to }}</h4>
				</div>
			</div>
			<div style="margin-top:10px;"></div>
			<div class="row">
				<div class="col-md-offset-4 col-md-4">
					<table class="table">
						@if($packages > 0 )
						<tr>
							<td><b>PACKAGES</b></td>
							<td><b>{{ $packages }}</b></td>
						</tr>
						@endif
						@if($services > 0 )
						<tr>
							<td><b>SERVICES</b></td>
							<td><b>{{ $services }}</b></td>
						</tr>
						@endif
						@if($associations > 0 )
						<tr>
							<td><b>ASSOCIATION</b></td>
							<td><b>{{ $associations }}</b></td>
						</tr>
						@endif
						@if($xray > 0 )
						<tr>
							<td><b>X-RAY</b></td>
							<td><b>{{ $xray }}</b></td>
						</tr>
						@endif
						@if($ecg > 0 )
						<tr>
							<td><b>ECG</b></td>
							<td><b>{{ $ecg }}</b></td>
						</tr>
						@endif
						@if($vaccine > 0 )
						<tr>
							<td><b>VACCINES</b></td>
							<td><b>{{ $vaccine }}</b></td>
						</tr>
						@endif
					</table>
				</div>
			</div>
		</div>
	</body>
</html>