<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="{{ asset('public/css/print.css') }}">
	<title></title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<p class="text-center h4" style="margin-bottom: 0px;">HYATT DIAGNOSTICE SYSTEM INC.</p>
				<p class="text-center" style="margin-bottom: 0px;">Main Office: Jaltan Bldg. CM Recto Davao city, 8000, Philippines</p>
				<p class="text-center" style="margin-bottom: 0px;">Tel No: +(63)(82) 286-7569</p>
				<p class="text-center">Email Address: <a href="#">hyattdiaginc@gmail.com</a></p>
				<table style="width: 100%;max-width: 100%;margin-top: 30px;" class="table-bordered">
					@foreach($info as $name => $value )
					<tr>
						<td>{{ $name }}</td>
						<td>{{ $value }}</td>
					</tr>
					@endforeach
				</table>
				<table style="width: 100%;margin-top: 25px;" class="table-bordered">
					<tr>
						<td style="text-align: center;font-weight: bold">Particulars</td>
						<td style="text-align: center;font-weight: bold">Amount</td>
					</tr>
					@foreach( $transList as $list )
					@php
						$totalAmount += $list->total_price;
					@endphp
						<tr>
							<td>{{ $list->name }}</td>
							<td style="text-align: center;">{{ number_format($list->total_price,2) }}</td>
						</tr>
					@endforeach
					@if( $discount != 0 )
						<tr>
							<td class="text-right"><b>Discount:</b></td>
							<td class="text-center">-{{ number_format($discount,2) }}</td>
						</tr>
					@endif
					<tr>
						<td style="text-align: right;font-weight: bold">Total Amount</td>
						<td style="text-align: center;font-weight: bold">{{ number_format($totalAmount-$discount, 2) }}</td>
					</tr>
				</table>
			</div>
			


			<div class="col-md-6">
				<p class="text-center h4" style="margin-bottom: 0px;">HYATT DIAGNOSTICE SYSTEM INC.</p>
				<p class="text-center" style="margin-bottom: 0px;">Main Office: Jaltan Bldg. CM Recto Davao city, 8000, Philippines</p>
				<p class="text-center" style="margin-bottom: 0px;">Tel No: +(63)(82) 286-7569</p>
				<p class="text-center">Email Address: <a href="#">hyattdiaginc@gmail.com</a></p>
			</div>
		</div>
	</div>
</body>
</html>