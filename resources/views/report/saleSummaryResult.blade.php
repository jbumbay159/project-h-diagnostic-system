<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('public/css/print.css') }}">
		<title></title>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3 class="text-center">COMPANY NAME</h3>
					<h4 class="text-center">Company Address</h4>
					<hr>
					<h3 class="text-center">SUMMARY SALES</h3>
					<h4 class="text-center">Date Covered: {{ \Carbon\Carbon::parse($date_from)->toFormattedDateString() }} - {{ \Carbon\Carbon::parse($date_to)->toFormattedDateString() }}</h4>
				</div>
			</div>
			<div style="margin-top:10px;"></div>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					
				
				<table class="table table-bordered" style="text-transform: uppercase;font-size: 12px;">
					<thead>
						<tr>
							<th class="text-center">Payment Mode</th>
							<th class="text-center">Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Cash</td>
							<td>{{ number_format($summary['cash'],2,'.',',') }}</td>
						</tr>
						<tr>
							<td>Billed</td>
							<td>{{ number_format($summary['credit'],2,'.',',') }}</td>
						</tr>
						<tr>
							<td class="gt" style="text-align:right;"> GRAND TOTAL</td>	
							<td class="gt">{{ number_format($summary['total'],2,'.',',') }}</td>	
						</tr>
					</tbody>
				</table>
				</div>
				
				
			</div>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<p>PREPARED BY: CASHIER NAME HERE</p>
				</div>
			</div>
		</div>
	</body>
</html>