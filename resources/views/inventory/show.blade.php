@extends('template')

@section('content')
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title" style="margin-top: 5px;">Items: {{ $supply->name }}</h3>
			</div>
            <div class="col-md-6">
                <div class="clearfix">
                    <a href="{{ action('InventoryController@index') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
                </div>
            </div>
		</div>
	</div>
	<div class="panel-body">
        <table id="dataTable1" class="table table-bordered table-striped-col">
        	<thead  style="text-transform: uppercase;">
        		<tr>
        			<th class="text-center">Date</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Status</th>
        		</tr>
        	</thead>
        	<tbody>
                @foreach($list as $item)
                    <tr class="{{ $item['state'] }}">
                        <td class="text-center">{{ $item['date'] }}</td>
                        <td class="text-center">{{ $item['quantity'] }}</td>
                        <td class="text-center">{{ $item['status'] }}</td>
                    </tr>
                @endforeach
        	</tbody>
        </table>
	</div>
</div>
@endsection
