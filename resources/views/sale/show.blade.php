@extends('template')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Sales Index</h3>
            </div>          
        </div>
    </div>
    <div class="panel-body">
    	{!! Form::open(['method'=>'post','action'=>'SaleController@store']) !!}
    	<div class="row">
    		<div class="col-md-4">
    			<div class="form-group">
    				{!! Form::select('customer',$customer,$info->id,['class'=>'form-control select','placeholder'=>'Search Customer']) !!}
    			</div>
    		</div>
    		<div class="col-md-2">
    			<div class="form-group">
		            {!! Form::button('<i class="glyphicon glyphicon-search"></i> SEARCH', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk','style'=>'margin-top:0px;')) !!}
		        </div>
    		</div>
    	</div>
    	{!! Form::close() !!}
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Customer Details</h3>
            </div>   
            <div class="col-md-6">
               
            </div>         
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-8">
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                             <img alt="" src="{{ $info->photos }}" style="height: 80px;width: 80px;" class="media-object img-circle">
                        </a>
                    </div>
                    <div class="media-body">
                        <h2 class="media-heading" style="text-transform: uppercase;">{{ $info->last_name.', '.$info->first_name.' '.$info->middle_name.' '.$info->name_extension }}</h2>
                        <h4 class="media-heading" style="text-transform: uppercase;">Agency: {{ $info->agencyName }}</h4>
                        <h5 class="media-usermeta" style="text-transform: uppercase;">
                            <span class="media-time">Date of Registration: {{ \Carbon\Carbon::parse($info->created_at)->toFormattedDateString() }}</span>
                        </h5>
                        <h5 class="media-usermeta" style="text-transform: uppercase;">
                            <span class="media-time" style="color:red;">Package Expiration: {{ \Carbon\Carbon::parse($info->expirationDate->created_at)->addDays($info->expirationDate->days)->toFormattedDateString() }}</span>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <span class="center-block text-center">
                </span>
            </div>
        </div>
        <hr>
        <div class="row spacing">
            <div class="col-md-12">
                <table class="table table-bordered" style="text-transform: uppercase;font-weight: bold;">
                    <thead>
                        <tr>
                            <th class="text-center">Transaction No.</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Payment Mode</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $info->sales()->orderBy('created_at','desc')->get()->groupBy('transcode') as $trans => $translist )
                            @php
                                $totalPrice = 0;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $trans }}</td>
                                @foreach( $translist as $list )
                                    @php
                                        $status = $list->status;
                                        $paymentStatus = $list->payment_id;
                                        $totalPrice += $list->total_price; 
                                        $date = $list->created_at;
                                    @endphp
                                @endforeach
                                <td class="text-center">{{ \Carbon\Carbon::parse($date)->toFormattedDateString() }}</td>
                            <td class="text-center">{{ number_format($totalPrice, 2) }}</td>
                            <td class="text-center">
                                @if ( $paymentStatus == 2 )
                                    BILLED
                                @elseif($paymentStatus == 1)
                                    CASH
                                @else
                                    CANCELLED
                                @endif
                            </td>
                            <td class="text-center" style="padding: 5px;">
                                <a href="{{ action('SaleController@list',[$info->id, $list->transcode]) }}" class="btn btn-sm btn-primary">View Details</a>


                                {{-- <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-cog"></span></button>
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        @if( $list->status == 0 AND $list->payment_id != 0 )
                                            <li><a href="{{ action('SaleController@list',[$info->id, $list->transcode]) }}" >List</a></li>
                                            <li><a href="#detail-{{ $list->id }}" data-toggle="modal">View Details</a></li>
                                            <li><a href="#ds-{{ $list->id }}" data-toggle="modal">Add Discount</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#pm-{{ $list->id }}" data-toggle="modal">Accept Payment</a></li>
                                        @else
                                            <li><a href="#detail-{{ $list->id }}" data-toggle="modal">View Details</a></li>
                                        @endif
                                    </ul>
                                </div> --}}
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')

@foreach ( $info->sales()->orderBy('created_at','desc')->get() as $list )
<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="detail-{{ $list->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Sales Detail</h4>
            </div>
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <td width="200px"><strong>ID:</strong></td>
                                <td>{{ $list->transcode }}</td>
                            </tr>
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{ $list->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Quantity:</strong></td>
                                <td>{{ $list->quantity }}</td>
                            </tr>
                            <tr>
                                <td><strong>Unit Price:</strong></td>
                                <td>{{ number_format($list->unit_price, 2, ".", ",") }}</td>
                            </tr>
                            <tr>
                                <td><strong>Discount:</strong></td>
                                <td>{{ number_format($list->discount, 2, ".", ",") }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total Price:</strong></td>
                                <td>{{ number_format($list->total_price, 2, ".", ",") }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                @if($list->status == 0)
                                    <td>Unpaid</td>
                                @elseif($list->status == 1)
                                    <td>Paid</td>
                                @else
                                    <td>Cancelled</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>







@if( $list->status == 0 )
<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="pm-{{ $list->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Accept Payment</h4>
            </div>
            {!! Form::model($list, ['method'=>'patch', 'action' => ['SaleController@update', $list->id]]) !!}
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('payment_id','Select Payment Mode') !!}
                            {!! Form::select('payment_id',['1'=>'CASH','2'=>'BILLED'],null,['class'=>'form-control select']) !!}
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                            {!! Form::submit('ACCEPT PAYMENT', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="ds-{{ $list->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Update Discount</h4>
            </div>
            {!! Form::model($list, ['method'=>'patch', 'action' => ['SaleController@update', $list->id]]) !!}
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('discount','Discount') !!}
                            {!! Form::text('discount',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">CLOSE</button>
                            {!! Form::submit('UPDATE ENTRY', ['class'=>'btn btn-lg btn-primary','style'=>'margin-top:0px;']) !!}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="qty-{{ $list->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Update Quantity</h4>
            </div>
            {!! Form::model($list, ['method'=>'patch', 'action' => ['SaleController@update', $list->id]]) !!}
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('quantity','Quantity') !!}
                            {!! Form::text('quantity',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">CLOSE</button>
                            {!! Form::submit('UPDATE ENTRY', ['class'=>'btn btn-lg btn-primary','style'=>'margin-top:0px;']) !!}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="payment-{{ $list->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Update Payment Mode</h4>
            </div>
            {!! Form::model($list, ['method'=>'patch', 'action' => ['SaleController@update', $list->id]]) !!}
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('amount','Enter Payment') !!}
                            {!! Form::number('amount',$list->total_price,['step' => 0.01,'class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">CLOSE</button>
                            {!! Form::submit('UPDATE ENTRY', ['class'=>'btn btn-lg btn-primary','style'=>'margin-top:0px;']) !!}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endif
@endforeach
@endsection