@php
	use Carbon\Carbon;
	use App\Supply;
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
					<h4 class="text-center">Date Covered: {{ $date_from }} {{ ($date_to == $date_from)? '' : ' - '.$date_to }}</h4>
				</div>
			</div>
			<div style="margin-top:10px;"></div>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<table class="table">
						<thead>
	                        <th>Name</th>
	                        <th class="text-center">Test</th>
	                    </thead>
	                    @foreach($items->groupBy('supply_id') as $name => $item)
	                        <tr>
	                            <td>{{ Supply::findOrFail($name)->name }}</td>
	                            <td class="text-center">{{ $item->sum('testqty') }} TEST</td>
	                        </tr>
	                    @endforeach
                    </table>
				</div>
			</div>
		</div>
	</body>
</html>