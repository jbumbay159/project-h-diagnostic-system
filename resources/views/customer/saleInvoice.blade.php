<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/print.css') }}">
		<title> </title>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<h3 class="text-center">COMPANY NAME</h3>
					<h4 class="text-center">Company Address</h4>
					<hr>
				</div>
			</div>
			<div style="margin-top:10px;"></div>
			<!-- CASH LIST -->
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<table class="table table-bordered" style="text-transform: uppercase;font-size: 12px;">
						<tr>
							<td colspan="2"><b>Name:</b> {{ $info->fullName }}</td>
							<td><b>ID:</b> {{ $info->id }}</td>
						</tr>
						<tr>
							<td colspan="2"><b>Agency:</b> {{ $sale->agency->name }} </td>
							<td width="200px"><b>Date:</b> {{ \Carbon\Carbon::parse($sale->created_at)->toFormattedDateString() }} </td>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="3" style="padding: 0px;">
								<table class="table  table-bordered" style="border-color: #fff; margin-bottom: 0px;">
									<tr>
										<td class="text-center"><b>Name</b></td>
										<td class="text-center" width="100px"><b>Qty</b></td>
										<td class="text-center" width="200px"><b>Amount</b></td>
									</tr>
									<tr>
										<td>{{ $sale->name }}</td>
										<td class="text-center">{{ $sale->quantity }}</td>
										<td style="padding-bottom: 50px;" class="text-center">{{ $sale->unit_price }}</td>
									</tr>
									<tr>
										<td colspan="2" class="text-right" ><b>Discount:</b></td>
										<td class="text-center" >-{{ $sale->discount }}</td>
									</tr>
									<tr>
										<td colspan="2" class="text-right" ><b>Total:</b></td>
										<td class="text-center" >{{ $sale->total_price }}</td>
									</tr>
									
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<!-- END CASH LIST -->
			
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<p>PREPARED BY: CASHIER NAME HERE</p>
				</div>
			</div>
		</div>
	</body>
</html>