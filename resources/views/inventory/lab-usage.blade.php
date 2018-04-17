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
		<div class="row">
            {!! Form::open(['action'=>'InventoryController@addLabUsage']) !!}
			<div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('Product Name') !!}
                    {!! Form::select('supply_id',$supply,null,['class'=>'form-control select','placeholder'=>'PLEASE SELECT']) !!}
                </div>
            </div>
			<div class="col-md-4">
				<div class="form-group">
                    {!! Form::label('Customer Name') !!}
                    {!! Form::select('customer_id',$customers,null,['class'=>'form-control select','placeholder'=>'PLEASE SELECT']) !!}
                </div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					{!! Form::label('No of test') !!}
					{!! Form::number('testqty',0,['class'=>'form-control']) !!}
				</div>
			</div>

			<div class="col-md-2">
                <div class="form-group">
                    {!! Form::button('<i class="glyphicon glyphicon-plus"></i> ADD ITEM', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk','style'=>'margin-top:22px;')) !!}
                </div>
            </div>
            {!! Form::close() !!}
		</div>
		<hr>
        <table id="dataTable1" class="table table-bordered table-striped-col">
        	<thead  style="text-transform: uppercase;">
        		<tr>
                    <th width="150" class="text-center">Supply</th>
                    <th width="150" class="text-center">Customer</th>
                    <th width="150" class="text-center">Qty</th>
        		</tr>
        	</thead>
        	<tbody>
                @foreach( $items as $item )
                    <tr>
                        <td class="text-center">{{ $item->supply->name }}</td>
                        <td class="text-center">{{ $item->customer->fullName }}</td>
                        <td class="text-center">{{ $item->testqty }} Test</td>
                    </tr>
                @endforeach
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

@endsection
