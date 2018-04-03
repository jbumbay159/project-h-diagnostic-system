@php
	use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('public/css/print.css') }}">
		<title></title>
		<style type="text/css">
			table td{
				font-size: 12px;
			}
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
				<div class="col-md-offset-2 col-md-8">
					@if($type == 'critical-level')
			        <table id="dataTable1" class="table table-bordered table-hover">
			        	<thead>
			        		<tr style="text-transform: uppercase;">
			        			<th class="text-center">ITEM NAME</th>
			        			<th class="text-center">BALANCE ON HAND</th>
			                    <th class="text-center">MINIMUM LEVEL</th>
			        		</tr>
			        	</thead>
			        	<tbody>
			        		@foreach( $supplies as $supply )
				        		<tr>
				        			<td>{{ $supply->name }}</td>
				        			<td>{{ $supply->currentQty.' '.$supply->unit }}</td>
				        			<td>{{ number_format($supply->minimumQtyNoTest,0).' '.$supply->unit }}</td>
				        		</tr>
			        		@endforeach
			        	</tbody>
			        </table>
			        @elseif($type == 'expired' || $type == 'nearing-expiry')
				        <table id="dataTable1" class="table table-bordered table-hover">
				        	<thead>
				        		<tr style="text-transform: uppercase;">
				        			<th class="text-center">DATE EXPIRED</th>
				        			<th class="text-center">ITEM NAME</th>
				        			<th class="text-center">BALANCE ON HAND</th>
				        		</tr>
				        	</thead>
				        	<tbody>
				        		@foreach( $itemArray as $item )
					        		<tr>
					        			<td class='text-center'>{{ Carbon::parse($item['dateExp'])->toFormattedDateString() }}</td>
					        			<td>{{ $item['name'] }}</td>
					        			<td>{{ floor($item['qty']) }} {{ $item['unit'] }}</td>
					        		</tr>
				        		@endforeach
				        	</tbody>
				        </table>
			        @endif
				</div>
			</div>
		</div>
	</body>
</html>