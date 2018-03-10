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
					<h3 class="text-center">DAILY COLLECTIONS PER AGENCY</h3>
					<h4 class="text-center">Date Covered: {{ \Carbon\Carbon::parse($date_from)->toFormattedDateString() }} - {{ \Carbon\Carbon::parse($date_to)->toFormattedDateString() }}</h4>
				</div>
			</div>
			<div style="margin-top:10px;"></div>
			<div class="row">
				
				@foreach($agency as $agencyData )
				<!-- All Cash list  -->
				@php
					$a = 0;
				@endphp
				@if($agencyData->sales()->where('payment_id',1)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->count() > 0 )
				<hr>
				<h4 style="text-transform: uppercase;">{{ $agencyData->name.' - Cash' }}</h4>
				<hr>
				<table class="table table-bordered" style="text-transform: uppercase;font-size: 12px;">
					<thead>
						<tr>
							<th class="text-center">Transaction ID</th>
							<th class="text-center">Date</th>
							<th class="text-center">Customer Name</th>
							<th class="text-center">Payment Mode</th>
							<th class="text-center">Amount</th>
						</tr>
					</thead>
					<tbody>
						@foreach($agencyData->sales()->where('payment_id',1)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->get() as $data)
						<tr>
							<td>{{ $data->id }}</td>
							<td>{{ \Carbon\Carbon::parse($data->created_at)->toFormattedDateString() }}</td>
							<td>{{ $data->customer->last_name }}, {{ $data->customer->first_name }} {{ $data->customer->middle_name }} {{ $data->customer->name_extension }}</td>
							<td>{{ ($data->payment_id == 1) ? 'CASH' : 'CREDIT' }}</td>
							<td>{{ number_format($data->total_price,2) }}</td>
							<?php $a +=$data->total_price; ?>
						</tr>
						@endforeach
						<tr>
							<td class="gt" colspan="4" style="text-align:right;"> GRAND TOTAL</td>	
							<td class="gt">{{ number_format($a,2) }}</td>	
						</tr>
					</tbody>
				</table>
				@endif
				<!-- End All Cash list  -->
				
				<!-- All Credits list  -->
				@php
					$a = 0;
				@endphp
				@if($agencyData->sales()->where('payment_id',2)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->count() > 0 )
				<hr>
				<h4 style="text-transform: uppercase;">{{ $agencyData->name.' - Billed' }}</h4>
				<hr>
				<table class="table table-bordered" style="text-transform: uppercase;font-size: 12px;">
					<thead>
						<tr>
							<th class="text-center">Transaction ID</th>
							<th class="text-center">Date</th>
							<th class="text-center">Customer Name</th>
							<th class="text-center">Payment Mode</th>
							<th class="text-center">Amount</th>
						</tr>
					</thead>
					<tbody>
						@foreach($agencyData->sales()->where('payment_id',2)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->get() as $data)
						<tr>
							<td>{{ $data->id }}</td>
							<td>{{ \Carbon\Carbon::parse($data->created_at)->toFormattedDateString() }}</td>
							<td>{{ $data->customer->last_name }}, {{ $data->customer->first_name }} {{ $data->customer->middle_name }} {{ $data->customer->name_extension }}</td>
							<td>{{ ($data->payment_id == 1) ? 'CASH' : 'CREDIT' }}</td>
							<td>{{ number_format($data->total_price,2) }}</td>
							<?php $a +=$data->total_price; ?>
						</tr>
						@endforeach
						<tr>
							<td class="gt" colspan="4" style="text-align:right;"> GRAND TOTAL</td>	
							<td class="gt">{{ number_format($a,2) }}</td>	
						</tr>
					</tbody>
				</table>
				@endif
				<!-- End All Credit list  -->
				
				@endforeach
			</div>
			<div class="row">
				<p>PREPARED BY: CASHIER NAME HERE</p>
			</div>
		</div>
	</body>
</html>