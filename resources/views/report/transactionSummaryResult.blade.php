<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('public/css/print.css') }}">
		<title>Hyatt System Generated Report</title>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3 class="text-center">COMPANY NAME</h3>
					<h4 class="text-center">Company Address</h4>
					<hr>
					<h4 class="text-center">Agency/Account Group: <strong>{{ $agency->name }}</strong></h4>
					<h4 class="text-center">Date Covered: {{ \Carbon\Carbon::parse($date_from)->toFormattedDateString() }} - {{ \Carbon\Carbon::parse($date_to)->toFormattedDateString() }}</h4>
				</div>
			</div>
			<div style="margin-top:10px;"></div>
			<div class="row">
				<div class="col-md-12">
				@foreach( $list->groupBy('customer_id') as $comId => $listData )
					@php
						$info = \App\Customer::findOrFail($comId);
						$trans = $info->transmittal()->orderBy('created_at', 'DESC')->first();
					@endphp
					<h4>{{ $info->last_name.', '.$info->first_name.' '.$info->middle_name.' '.$info->name_extension }}</h4>
					<h5>Date of Expiration: {{ \Carbon\Carbon::parse($trans->created_at)->addDays($trans->days)->toFormattedDateString() }}</h5>
					
					<table class="table" style="text-transform: uppercase;font-size: 12px;">
						<thead>
							<tr>
								<th width="150px">Date</th>
								<th width="200px">Status</th>
								<th>Remarks</th>
							</tr>
						</thead>
						<tbody>
							@foreach ( $listData as $data )
								@if ( $data->encode_date != NULL )
									<tr>
										<td>{{ \Carbon\Carbon::parse($data->encode_date)->toFormattedDateString() }}</td>	
										<td>{{ $data->status }}</td>	
										<td>{{ $data->remarks }}</td>	
									</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				@endforeach
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<p>PREPARED BY: CASHIER NAME HERE</p>
				</div>
			</div>
		</div>
	</body>
</html>