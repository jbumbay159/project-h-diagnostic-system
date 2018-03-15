@php
	use App\SaleDiscount;
@endphp

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
							$totalCash = 0;
						@endphp
						@foreach( $salesPayment as $transcode => $sales)
							@php
								$saleDiscount = SaleDiscount::where('transcode',$transcode)->first();
								if( $saleDiscount != NULL ){
									$totalDiscount = $saleDiscount->amount;
								}else{
									$totalDiscount = 0;
								}	
								$totalPrice = 0;
							@endphp
							@foreach($sales as $data)
								@php
									$date = $data->created_at;
									$fullName = $data->customer->fullName;
									$agency = $data->agency->name;
									$payment_id = $data->payment_id;
									$totalPrice += $data->total_price
								@endphp
							@endforeach
						<tr>
							<td class="text-center">{{ $transcode }}</td>
							<td class="text-center">{{ \Carbon\Carbon::parse($date)->toFormattedDateString() }}</td>
							<td class="text-center">{{ $fullName }}</td>
							<td class="text-center">{{ $agency }}</td>
							<td class="text-center">{{ ($payment_id == 1) ? 'CASH' : 'BILLED' }}</td>
							<td class="text-right">{{ number_format($totalPrice - $totalDiscount,2) }}</td>
							@php 

								$totalCash +=($totalPrice - $totalDiscount ); 
							@endphp
						</tr>
						@endforeach
						<tr>
							<td class="gt" colspan="5" style="text-align:right;"> TOTAL</td>	
							<td class="gt text-right"><b>{{ number_format($totalCash,2) }}</b></td>	
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
							$totalBilled = 0;
						@endphp
						@foreach( $billedPayment as $data)
							@php
								$saleDiscount = SaleDiscount::where('transcode',$transcode)->first();
								if( $saleDiscount != NULL ){
									$totalDiscount = $saleDiscount->amount;
								}else{
									$totalDiscount = 0;
								}	
								$totalPrice = 0;
							@endphp
							@foreach($sales as $data)
								@php
									$date = $data->created_at;
									$fullName = $data->customer->fullName;
									$agency = $data->agency->name;
									$payment_id = $data->payment_id;
									$totalPrice += $data->total_price
								@endphp
							@endforeach
						<tr>
							<td class="text-center">{{ $transcode }}</td>
							<td class="text-center">{{ \Carbon\Carbon::parse($date)->toFormattedDateString() }}</td>
							<td class="text-center">{{ $fullName }}</td>
							<td class="text-center">{{ $agency }}</td>
							<td class="text-center">{{ ($payment_id == 1) ? 'CASH' : 'BILLED' }}</td>
							<td class="text-right">{{ number_format($totalPrice - $totalDiscount,2) }}</td>
							@php 
								$totalBilled +=($totalPrice - $totalDiscount ); 
							@endphp
						</tr>
						@endforeach
						<tr>
							<td class="gt" colspan="5" style="text-align:right;"> TOTAL</td>	
							<td class="gt text-right">{{ number_format($totalBilled,2) }}</td>	
						</tr>
					</tbody>
				</table>
			</div>
			<!-- END CREDIT LIST -->
			<div class="row">
				<p class="text-right" style="font-weight: bold;font-size: 20px;">GRAND TOTAL: <u>{{ number_format($totalCash + $totalBilled,2) }}</u></p>
			</div>
			<div class="row">
				<p>PREPARED BY: CASHIER NAME HERE</p>
			</div>
		</div>
	</body>
</html>