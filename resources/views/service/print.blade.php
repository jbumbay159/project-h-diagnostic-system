<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="{{ asset('public/css/print.css') }}">
		<title></title>
		<style type="text/css">
			.text{
				border: 0px solid;
			    padding: 3px;
			    width: 100%;
			    display: inline-block;
			}
			.label-text{
				padding-left: 3px;
			}

			.spacing{
				margin-top: 20px;
			}
			.col-wrap {
			    -webkit-column-count: 3; /* Chrome, Safari, Opera */
			    -moz-column-count: 3; /* Firefox */
			    column-count: 2;
			}

			.content{
				  list-style: none;
				  padding: 0;
				  margin: 0;
				  display: flex;
				  flex-direction: column;
				  flex-wrap: wrap;
				  width: 45%;
				  height: 300px;
			}

			table{
				margin: 0px 20px 10px;
			}

			table:nth-child(1) {
				margin: 0px;
			}

			input{
				border: none !important;
	            box-shadow: none !important;
	            outline: none !important;
			}

		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p class="text-center">
						HYATT DIAGNOSTIC SYSTEM INC.<br>
						Main Office: Jaltan Bldg., CM Recto. Davao City, 8000, Philppines<br>
						Tel No: +(63)(82)268-7569 / email add: hyattdiaginc@gmail.com
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h5 class="text-center"><b>{{ $service->name }}</b></h2>
				</div>
			</div>
			<div class="row spacing">
				<div class="col-md-12">
					<center>
						<table style="width: 100%;">
							<tr>
								<td class="label-text">NAME</td>
								<td class="text">XXXXXXXXXXXXX,XXXXXXXXX XXXX</td>
								<td class="label-text">DATE</td>
								<td class="text">{{ $dateNow }}</td>
							</tr>
							<tr>
								<td class="label-text">AGE</td>
								<td class="text">99 years old</td>
								<td class="label-text">SEX</td>
								<td class="text">&nbsp;</td>
							</tr>
						</table>
					</center>
				</div>
			</div>
			<hr style="border: 1px solid;    margin: 0px;">
			@if( $service->covnv('nv') == true || $service->covnv('cov') == true )
				<div class="row">
					<div class="col-md-12">
						<div class="">
							@foreach($service->item()->get()->groupBy('group') as $groupName => $serviceItem) 
								<table style="width: 100%;">
									<thead>
										<th><u>{{ $groupName }}</u></th>
										<th><u><center>RESULT</center></u></th>

										@if($service->covnv('cov') == true)
											<th><u><center>COV</center></u></th>
										@endif
										@if($service->covnv('nv') == true)
											<th><u><center>NORMAL VALUE</center></u></th>
										@endif
										<th><u><center>REMARKS</center></u></th>
									</thead>
									<tbody>
										@foreach( $serviceItem as $data )
										<tr>
											<td>{{ $data->service }}</td>
											<td class="text">&nbsp;</center></td>
											@if($service->covnv('cov') == true)
												<td><center>{{ $data->cov }}</center></td>
											@endif
											@if($service->covnv('nv') == true)
												<td><center>{!! nl2br($data->nv) !!}</center></td>
											@endif
											<td class="text">&nbsp;</center></td>
										</tr>
										@endforeach
									</tbody>
								</table>
							@endforeach
						</div>
					</div>
				</div>
			@else
				<div class="row spacing">
					<div class="col-md-12">
						<div class="content">
							@foreach($service->item()->get()->groupBy('group') as $groupName => $serviceItem) 
								<table style="width: 100%;">
									<thead>
										<th width="250px"><u>{{ ($groupName != NULL) ? $groupName : 'Test' }}</u></th>
										<th width="150px"><center>RESULT</center></th>
									</thead>
									<tbody>
										@foreach( $serviceItem as $data )
										<tr style="font-size: 14px;">
											<td style="padding: 0px;">{{ $data->service }}:</td>
											<td style="padding: 0px;" class="text">&nbsp;</center></td>
										</tr>
										@endforeach
									</tbody>
								</table>
							@endforeach
						</div>
					</div>
				</div>
			@endif
			<p style="margin-top: 20px;">REMARKS:</p>
			<hr style="border: 1px solid;">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<center>
						<b>JOHN PATRICK C. PADILLA, MD. FPSP</b><br>
						<p>Lic no. 0089855</p>
					</center>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<center>
						<b>PETER GLENN A. GERONDIO, RMT</b><br>
						<p>Lic no. 0062752</p>
					</center>
				</div>
			</div>
		</div>
	</body>
</html>