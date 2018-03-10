@extends('template')

@section('content')
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title" style="margin-top: 5px;">Transaction</h3>
			</div>
			<div class="col-md-6">
				<div class="clearfix">
					<a href="#add-void" data-toggle="modal" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-plus"></span> Create Entry</a>
				</div>
			</div>		
		</div>
	</div>
	<div class="panel-body">
		<div >
            <table id="dataTable1" class="table table-bordered table-striped-col" style="text-transform: uppercase;">
            	<thead>
            		<tr>
            			<th class="text-center">Transaction ID</th>
            			<th class="text-center">Customer Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Remarks</th>
            			<th  width="80" class="text-center">Action</th>
            		</tr>
            	</thead>
                <tbody>
                    @foreach ( $trans as $list)
                        <tr>
                            <td class="text-center">{{ $list->sale->transcode }}</td>
                            <td class="text-center">{{ $list->customer->fullName }}</td>
                            <td class="text-center">
                                @if ( $list->status == 0)
                                    Pending
                                @elseif( $list->status == 1 )
                                    Approved
                                @else
                                    Cancelled
                                @endif
                            </td>
                            <td class="text-center">{{ $list->remarks }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-cog"></span></button>
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#trans-detail-{{ $list->id }}" data-toggle="modal">View Details</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
	</div>
</div>	
@endsection
@section('modal')
<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="add-void" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Void Transaction</h4>
            </div>
            {!! Form::open(['action'=> 'TransactionController@store']) !!}
            <div class="modal-body"> 
                <div class="row spacing">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('transaction','Transaction No.') !!}
                            {!! Form::select('transcode[]',[],null,['class'=>'form-control select-tag', 'multiple'=>'multiple'])!!}
                        </div>
                    </div>
                </div>
                <div class="row spacing">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('remarks','Remarks') !!}
                            {!! Form::textarea('remarks','',['class'=>'form-control autosize','rows'=>'3','placeholder'=>'Remarks'])!!}
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                        {!! Form::submit('SAVE ENTRY', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>



@foreach ( $trans as $list)

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="trans-detail-{{ $list->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Void Transaction Details</h4>
            </div>
            {!! Form::model($list, ['method'=>'patch', 'action' => ['TransactionController@update', $list->id]]) !!}
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h4>Customer Name</h4>
                            <p>{{ $list->customer->fullName }}</p>
                        </div>
                    </div>
                </div>
                <div class="row spacing">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h4>Transaction ID</h4>
                            <p>{{ $list->sale_id.' - '.$list->sale->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="row spacing">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h4>Remarks</h4>
                            <p>{{ $list->remarks }}</p>
                        </div>
                    </div>
                </div>  
                <div class="row spacing">
                    <div class="col-md-12">
                        <div class="form-group">
                            @if( $list->status == 0 )
                                {!! Form::label('status','Status') !!}
                                {!! Form::select('status',[0=>'Pending',1=>'Approve',2=>'Cancel'],null,['class'=>'form-control select'])!!}
                            @else
                                <h4>Status</h4>
                                @if( $list->status == 1 )
                                    <p>Approved - ( {{ $list->updated_at }} )</p>
                                @else
                                    <p>Cancelled - ( {{ $list->updated_at }} )</p>
                                @endif    
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                        @if( $list->status == 0 )
                            {!! Form::submit('SAVE ENTRY', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}
                        @endif
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endforeach
@endsection