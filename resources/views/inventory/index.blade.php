@extends('template')

@section('content')
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-3">
				<h3 class="panel-title" style="margin-top: 5px;">Inventory Module</h3>
			</div>
			<div class="col-md-6">
				 <center>
				 	<a href="{{ action('InventoryController@index') }}" class="btn btn-default btn-sm btn-quirk"> All</a>
				 	<a href="{{ action('InventoryController@filter','critical-level') }}" class="btn btn-success btn-sm btn-quirk"> Critical Level</a>
				 	<a href="{{ action('InventoryController@filter','expired') }}" class="btn btn-danger btn-sm btn-quirk"> Expired</a>
				 	<a href="{{ action('InventoryController@filter','nearing-expiry') }}" class="btn btn-warning btn-sm btn-quirk"> Nearing Expiring</a>
				 </center>
			</div>
			<div class="col-md-3">
				<div class="clearfix">
					<a href="{{ action('SupplyController@create') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-plus"></span> Create Entry</a>
				</div>
			</div>		
		</div>
	</div>
	<style type="text/css">
		td{
			text-align: center;
		}
		td:nth-child(1){
			text-align: left;
		}
		td:nth-child(5){
			padding:5px !important;
		}
	</style>
	<div class="panel-body">
        <table id="inventory" class="table table-bordered table-striped-col">
        	<thead>
        		<tr style="text-transform: uppercase;">
        			<th class="text-center">Name</th>
                    <th class="text-center">Minimum Level</th>
                    <th class="text-center">Qty.</th>
                    <th width="150" class="text-center">Last Updated</th>
                    <th class="text-center">Action</th>
        		</tr>
        	</thead>
        </table>
	</div>
</div>
@endsection

@section('js')
	<script>
		$(function() {
		    $('#inventory').DataTable({
		        processing: true,
		        serverSide: true,
		        ajax: '{{ action("InventoryController@data") }}',
		        columns: [
		            { data: 'name'},
		            { data: 'minimumQty'},
		            { data: 'qty'},
		            { data: 'updated_at'},
		            { data: 'action'},
		        ]
		    });
		});
	</script>
@endsection