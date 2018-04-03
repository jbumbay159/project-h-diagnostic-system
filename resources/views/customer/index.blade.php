@extends('template')

@section('content')
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title" style="margin-top: 5px;">Customers Module</h3>
			</div>
			<div class="col-md-6">
				<div class="clearfix">
					<a href="{{ action('CustomerController@create') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-plus"></span> Create Entry</a>
				</div>
			</div>		
		</div>
	</div>
	<div class="panel-body">
        <table id="dataTable1" class="table table-bordered table-hover table-striped" style="text-transform: uppercase;">
        	<thead>
        		<tr>
        			<th class="text-center">Customer ID</th>
        		    <th class="text-center">Customer Name</th>
                    <th class="text-center">Address</th>
        			<th class="text-center">Agency</th>
                    <th class="text-center">Destination</th>
        			<th width="80" class="text-center">Action</th>
        		</tr>
        	</thead>
              	<tbody>
              		@foreach ( $customer as $data )
              			<tr>
              				<td class="text-center">{{ $data->barcode }}</td>
              				<td>{{ $data->fullName }}</td>
              				<td>{{ $data->address }}</td>
              				<td>{{ $data->CurrentAgency->name }}</td>
              				<td>{{ $data->country()->orderBy('created_at','desc')->first()->name }}</td>
              				<td class="text-center" width="80" style="text-transform: uppercase; padding: 5px;">
	                            <div class="btn-group">
	                                <button type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-cog"></span></button>
	                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
	                                    <span class="caret"></span>
	                                    <span class="sr-only">Toggle Dropdown</span>
	                                </button>
	                                <ul class="dropdown-menu" role="menu">
	                                    <li><a href="{{ action('CustomerController@show', $data->id) }}">View Profile</a></li>
	                                </ul>
	                            </div>
	                        </td>
              			</tr>
              		@endforeach
              	</tbody>
        </table>
	</div>
</div>	

@endsection