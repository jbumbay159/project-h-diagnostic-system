@php 
	$grandTotal = 0;
	use App\SaleDiscount;
@endphp

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
						@foreach($agencyData->sales()->where('payment_id',1)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->get()->groupBy('transcode') as $transcode => $sales)
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
							<td class="text-center">{{ ($payment_id == 1) ? 'CASH' : 'BILLED' }}</td>
							<td class="text-right"><b>{{ number_format($totalPrice - $totalDiscount,2) }}</b></td>
							<?php $a +=($totalPrice - $totalDiscount ); ?>
						</tr>
						@endforeach
						<tr>
							<td class="gt" colspan="4" style="text-align:right;"> TOTAL</td>	
							<td class="gt text-right"><b>{{ number_format($a,2) }}</b></td>	
						</tr>
						@php 
							$grandTotal += $a;
						@endphp
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
						@foreach($agencyData->sales()->where('payment_id',2)->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->get()->groupBy('transcode') as $transcode => $sales)
						
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
									$totalPrice += $data->total_price;
								@endphp
							@endforeach

						<tr>
							<td class="text-center">{{ $transcode }}</td>
							<td class="text-center">{{ \Carbon\Carbon::parse($date)->toFormattedDateString() }}</td>
							<td class="text-center">{{ $fullName }}</td>
							<td class="text-center">{{ ($payment_id == 1) ? 'CASH' : 'BILLED' }}</td>
							<td class="text-right"><b>{{ number_format($data->total_price - $totalDiscount,2) }}</b></td>
							<?php $a +=$totalPrice - $totalDiscount; ?>
						</tr>
						@endforeach
						<tr>
							<td class="gt" colspan="4" style="text-align:right;"> TOTAL</td>	
							<td class="gt text-right">{{ number_format($a,2) }}</td>	
						</tr>
						@php 
							$grandTotal += $a;
						@endphp
					</tbody>
				</table>
				@endif
				<!-- End All Credit list  -->
				
				@endforeach
			</div>
			<div class="row">
				<p class="text-right" style="font-weight: bold;font-size: 20px;">GRAND TOTAL: <u>{{ number_format($grandTotal,2) }}</u></p>
			</div>
			<div class="row">
				<p>PREPARED BY: CASHIER NAME HERE</p>
			</div>
		</div>
	</body>
</html>