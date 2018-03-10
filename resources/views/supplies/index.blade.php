@extends('template')

@section('content')
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title" style="margin-top: 5px;">Supplies Module</h3>
			</div>
			<div class="col-md-6">
				<div class="clearfix">
					<a href="{{ action('SupplyController@create') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-plus"></span> Create Entry</a>
				</div>
			</div>		
		</div>
	</div>
	<style type="text/css">
		td:nth-child(2){
			text-align: center;
		}
		td:nth-child(4){
			padding: 5px !important;
		}
	</style>
	<div class="panel-body">
        <table id="supplies" class="table table-bordered table-striped-col" style="text-transform: uppercase;">
        	<thead>
        		<tr>
        			<th class="text-center">Name</th>
                    <th class="text-center">Minimum Level</th>
                    <th class="text-center">Remarks</th>
        			<th width="80" class="text-center">Action</th>
        		</tr>
        	</thead>
        </table>
	</div>
</div>
@endsection

@section('js')
<script>
	$(function() {
	    $('#supplies').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '{{ action("SupplyController@data") }}',
	        columns: [
	            { data: 'name'},
	            { data: 'minimumQty'},
	            { data: 'remarks'},
	            { data: 'action'},
	        ]
	    });
	});
</script>


@endsection