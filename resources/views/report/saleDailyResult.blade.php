<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('public/css/print.css') }}">
		<title> </title>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3 class="text-center">COMPANY NAME</h3>
					<h4 class="text-center">Company Address</h4>
					<hr>
					<h3 class="text-center">DAILY COLLECTIONS</h3>
					<h4 class="text-center">Date Covered: {{ \Carbon\Carbon::parse($date_from)->toFormattedDateString() }} - {{ \Carbon\Carbon::parse($date_to)->toFormattedDateString() }}</h4>
				</div>
			</div>
			<div style="margin-top:10px;"></div>
			<!-- CASH LIST -->
			<h2>Cash</h2>
			<div class="row">
				<table class="table table-bordered" style="text-transform: uppercase;font-size: 12px;">
					<thead>
						<tr>
							<th class="text-center">Transaction ID</th>
							<th class="text-center">Date</th>
							<th class="text-center">Customer Name</th>
							<th class="text-center">Agency</th>
							<th class="text-center">Payment Mode</th>
							<th class="text-center">Amount</th>
						</tr>
					</thead>
					<tbody>
						@php
							$a = 0;
						@endphp
						@foreach( \App\Sale::where('payment_id',1)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->get() as $data)
						<tr>
							<td class="text-center">{{ $data->transcode }}</td>
							<td class="text-center">{{ \Carbon\Carbon::parse($data->created_at)->toFormattedDateString() }}</td>
							<td class="text-center">{{ $data->customer->last_name }}, {{ $data->customer->first_name }} {{ $data->customer->middle_name }} {{ $data->customer->name_extension }}</td>
							<td class="text-center">{{ $data->agency->name }}</td>
							<td class="text-center">{{ ($data->payment_id == 1) ? 'CASH' : 'CREDIT' }}</td>
							<td>{{ number_format($data->total_price,2) }}</td>
							@php 
								$a +=$data->total_price; 
							@endphp
						</tr>
						@endforeach
						<tr>
							<td class="gt" colspan="5" style="text-align:right;"> GRAND TOTAL</td>	
							<td class="gt">{{ number_format($a,2) }}</td>	
						</tr>
					</tbody>
				</table>
			</div>
			<!-- END CASH LIST -->
			<!-- CREDIT LIST -->
			<h2>Billed</h2>
			<div class="row">
				<table class="table table-bordered" style="text-transform: uppercase;font-size: 12px;">
					<thead>
						<tr>
							<th class="text-center">Transaction ID</th>
							<th class="text-center">Date</th>
							<th class="text-center">Customer Name</th>
							<th class="text-center">Agency</th>
							<th class="text-center">Payment Mode</th>
							<th class="text-center">Amount</th>
						</tr>
					</thead>
					<tbody>
						@php
							$a = 0;
						@endphp
						@foreach( \App\Sale::where('payment_id',2)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->get() as $data)
						<tr>
							<td class="text-center">{{ $data->id }}</td>
							<td class="text-center">{{ \Carbon\Carbon::parse($data->created_at)->toFormattedDateString() }}</td>
							<td class="text-center">{{ $data->customer->last_name }}, {{ $data->customer->first_name }} {{ $data->customer->middle_name }} {{ $data->customer->name_extension }}</td>
							<td class="text-center">{{ $data->agency->name }}</td>
							<td class="text-center">{{ ($data->payment_id == 1) ? 'CASH' : 'CREDIT' }}</td>
							<td>{{ number_format($data->total_price,2) }}</td>
							@php 
								$a +=$data->total_price; 
							@endphp
						</tr>
						@endforeach
						<tr>
							<td class="gt" colspan="5" style="text-align:right;"> GRAND TOTAL</td>	
							<td class="gt">{{ number_format($a,2) }}</td>	
						</tr>
					</tbody>
				</table>
			</div>
			<!-- END CREDIT LIST -->
			<div class="row">
				<p>PREPARED BY: CASHIER NAME HERE</p>
			</div>
		</div>
	</body>
</html>