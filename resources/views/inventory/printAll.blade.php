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
					<table class="table-bordered" style="width: 100%;">
						<thead>
							<th>NAME</th>
							<th class="text-center">MINIMUM BALANCE</th>
							<th class="text-center">BALANCE ON HAND</th>
						</thead>
						<tbody>
							@foreach( $supplies as $supply )
							<tr>
								<td>{{ $supply->name }}</td>
								<td class="text-center">
									{{ floor($supply->currentQty).' '.$supply->unit.' / '.$supply->currentTest.' Test' }}
								</td>
								<td class="text-center">{{ $supply->minimumQty }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>