@php
	use Carbon\Carbon;
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
				<div class="col-md-12">
					@foreach($trasmittalStatus as $agency => $lists)
                        <b>{{ $agency }}</b>
                        <table class="table" style="font-size: 12px;">
	                        @foreach($lists as $list)
	                            <tr>
	                                <td class="text-center">{{ $list->encodeDateName }}</td>
	                                <td>{{ $list->customer->fullName }}</td>
	                                <td class="text-center">{{ $list->status }}</td>
	                                <td>{{ $list->remarks }}</td>
	                            </tr>
	                        @endforeach
                        </table>
                    @endforeach
				</div>
			</div>
		</div>
	</body>
</html>