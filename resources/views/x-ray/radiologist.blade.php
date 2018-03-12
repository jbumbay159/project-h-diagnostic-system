@extends('template')

@section('content')
@php
	use Carbon\Carbon;
@endphp
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h3 class="panel-title" style="margin-top: 5px;">Radiologist</h3>
			</div>
		</div>
	</div>
	<div class="panel-body">
        <table id="dataTable1" class="table table-bordered table-striped-col">
        	<thead>
        		<tr style="text-transform: uppercase;">
        			<th class="text-center" >Customer Name</th>
        			<th class="text-center">Examination</th>
        			<th class="text-center">File No</th>
                    <th class="text-center">Radiologist</th>
                    <th class="text-center">Prepared By</th>
                    <th class="text-center">Action</th>
        		</tr>
        	</thead>
        	<tbody>
        		@foreach( $xrayResults as $xrayResult )
        			<tr>
        				<td class="text-center">{{ $xrayResult->customer->fullName }}</td>
        				<td class="text-center">{{ $xrayResult->labResult->name }}</td>
        				<td class="text-center">{{ $xrayResult->file_no }}</td>
        				<td class="text-center">{{ $xrayResult->radiologistUser->fullName }}</td>
        				<td class="text-center">{{ $xrayResult->preparedUser->fullName }}</td>
        				<td class="text-center" style="padding: 5px;">
        					<a href="{{ action('XrayController@edit',$xrayResult->id) }}" data-toggle="modal" class="btn btn-primary btn-sm">Add Result</a>
        				</td>
        			</tr>
        		@endforeach
        	</tbody>
        </table>
	</div>
</div>
@endsection
