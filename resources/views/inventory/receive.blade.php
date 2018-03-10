@extends('template')

@section('content')
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title" style="margin-top: 5px;">Receive Items</h3>
			</div>
		</div>
	</div>
	<div class="panel-body">
		{!! Form::open(['action' => 'InventoryController@addReceiveItem']) !!}
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					{!! Form::label('Product Name') !!}
					{!! Form::select('supply',$supply,null,['class'=>'form-control select','placeholder'=>'PLEASE SELECT']) !!}
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					{!! Form::label('Lot Number') !!}
					{!! Form::text('lot_number',NULL,['class'=>'form-control']) !!}
				</div>
			</div>
			<div class="col-md-1">
				<div class="form-group">
					{!! Form::label('Quantity') !!}
					{!! Form::number('qty',0,['class'=>'form-control']) !!}
				</div>
			</div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('Price per test') !!}
                    {!! Form::number('price',0,['class'=>'form-control','step'=>0.01]) !!}
                </div>
            </div>

			<div class="col-md-2">
				<div class="form-group">
					{!! Form::label('Expiry Date') !!}
					{!! Form::text('exp_date',NULL,['class'=>'form-control dt date']) !!}
				</div>
			</div>
			<div class="col-md-2">
                <div class="form-group">
                    {!! Form::button('<i class="glyphicon glyphicon-plus"></i> ADD ITEM', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk','style'=>'margin-top:22px;')) !!}
                </div>
            </div>
		</div>
		{!! Form::close() !!}
		<hr>
        <table id="dataTable1" class="table table-bordered table-striped-col">
        	<thead  style="text-transform: uppercase;">
        		<tr>
        			<th class="text-center">Name</th>
                    <th width="150" class="text-center">Qty</th>
                    <th width="150" class="text-center">Price per test</th>
                    <th width="150" class="text-center">Lot Number</th>
                    <th width="150" class="text-center">Expiry Date</th>
                    <th width="100" class="text-center">Action</th>
        		</tr>
        	</thead>
        	<tbody>
        		@if($receiveItems != NULL)
	        		@foreach($receiveItems as $key => $items)
		        		<tr>
		        			<td>{{ $items['prodName'] }}</td>
		        			<td class="text-center">{{ $items['qty'].' '.$items['unit'] }}</td>
                            <td class="text-center">&#x20B1; {{ $items['price'] }}</td>
		        			<td class="text-center">{{ $items['lot_number'] }}</td>
		        			<td class="text-center">{{ $items['exp_date'] }}</td>
		        			<td class="text-center" style="padding: 5px;">
		        				<a href="#update-{{ $key }}" data-toggle="modal" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-edit"></i></a>
		        				<a href="{{ action('InventoryController@removeReceiveItem',$key) }}" class="btn btn-danger btn-sm" onclick="event.preventDefault(); document.getElementById('remove-{{ $key }}').submit();"><i class="glyphicon glyphicon-trash"></i></a>
	        					{!! Form::model($items, ['method'=>'DELETE','id'=>'remove-'.$key, 'action' => ['InventoryController@removeReceiveItem',$key]]) !!}
                                {!! Form::close() !!}
		        			</td>
		        		</tr>
	        		@endforeach
        		@endif
        	</tbody>
        </table>
	</div>
</div>
<a href="#receive-data" data-toggle="modal">{!! Form::button('<i class="glyphicon glyphicon-save"></i> SAVE ITEMS', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}</a>

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="receive-data" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Receive Supplies</h4>
            </div>
            {!! Form::open(['action'=>'InventoryController@store','style'=>'margin-bottom:0px;','files'=>'true']) !!}
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
						<div class="form-group">
							{!! Form::label('Receive Date') !!}
							{!! Form::text('date_received',NULL,['class'=>'form-control dt date','required']) !!}
						</div>
					</div>
                </div>
                <div class="row spacing">
                    <div class="col-md-12">
						<div class="form-group">
							{!! Form::label('Remarks') !!}
							{!! Form::textarea('remarks',NULL,['class'=>'form-control','size'=>'10x5','required']) !!}
						</div>
					</div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                            {!! Form::submit('SAVE', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<!-- Update Modal -->
@if($receiveItems != NULL)
@foreach($receiveItems as $key => $items)
<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="update-{{ $key }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">{{ $items['prodName'] }}</h4>
            </div>
            {!! Form::model($items, ['method'=>'PATCH', 'action' => ['InventoryController@editReceiveItem',$key]]) !!}
            <div class="modal-body">   
                <div class="row">
                    <div class="col-md-12">
						<div class="form-group">
							{!! Form::label('Expiry Date') !!}
							{!! Form::text('exp_date',$items['exp_date'],['class'=>'form-control dt date','required']) !!}
						</div>
					</div>
                </div>
                <div class="row spacing">
                    <div class="col-md-12">
						<div class="form-group">
							{!! Form::label('Lot Number') !!}
							{!! Form::text('lot_number',$items['lot_number'],['class'=>'form-control','required']) !!}
						</div>
					</div>
                </div> 
                <div class="row spacing">
                    <div class="col-md-12">
						<div class="form-group">
							{!! Form::label('Quantity') !!}
							{!! Form::text('qty',$items['qty'],['class'=>'form-control','required']) !!}
						</div>
					</div>
                </div> 
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                            {!! Form::submit('SAVE', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endforeach
@endif

@endsection
