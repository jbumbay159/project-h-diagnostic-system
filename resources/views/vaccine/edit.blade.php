@extends('template')

@section('content')
@php
	use Carbon\Carbon;
@endphp

<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title" style="margin-top: 5px;">Vaccine Module</h3>
			</div>
			<div class="col-md-6">
				<div class="clearfix">
					<a href="{{ action('VaccineController@index') }} " class="btn btn-default btn-sm btn-quirk pull-right" data-toggle="modal"><span class="glyphicon glyphicon-home"></span> Back to index</a>
				</div>
			</div>		
		</div>
	</div>
	
	<div class="panel-body">
        <table id="dataTable1" class="table table-bordered table-striped-col">
        	<thead>
        		<tr style="text-transform: uppercase;">
        			<th class="text-center" width="100px">Given Date</th>
        			<th class="text-center" width="100px">Expiry Date</th>
        			<th class="text-center">Brand Name</th>
        			<th class="text-center">Lot No.</th>
        			<th class="text-center">Administered By.</th>
                    <th class="text-center" width="80px">Action</th>
        		</tr>
        	</thead>
        	<tbody>
        		@foreach( $vaccines as $vaccine )
        			<tr>
        				<td class="text-center">{{ Carbon::parse($vaccine->date_given)->toFormattedDateString() }}</td>
        				<td class="text-center">{{ $vaccine->expiry_date }}</td>
        				<td class="text-center">{{ $vaccine->brand_name }}</td>
        				<td class="text-center">{{ $vaccine->lot_no }}</td>
        				<td class="text-center">{{ $vaccine->nurse_name }}</td>
        				<td class="text-center" style="padding:5px;">
	        				<a href="{{ action('VaccineController@show',$vaccine->id) }}" target="_blank" class="btn btn-primary btn-sm vaccine-{{ $vaccine->id }}">
	        					<span class="glyphicon glyphicon-print"></span>
	        				</button>
	        			</td>
        			</tr>
        		@endforeach
        	</tbody>
        </table>
	</div>
</div>
@endsection
