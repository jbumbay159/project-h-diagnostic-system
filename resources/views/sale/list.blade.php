@extends('template')

@section('content')
<div class="row">
    <div class="col-md-6">
        <a href="{{ action('SaleController@show',$saleFirst->customer_id) }}" class="btn btn-primary">Back</a>
    </div>
    <div class="col-md-6">
        <div class="pull-right">
            @if($saleFirst->status == 0)
                <!-- <button type="button" class="btn btn-primary" >Add Discount</button> -->
                <a href="#discount" data-toggle="modal" class="btn btn-primary">Discount</a>
                <a href="#add-service" data-toggle="modal" class="btn btn-primary">Add Services</a>
                <a href="#accept-payment" data-toggle="modal" class="btn btn-success">Accept Payment</a>
            @else
                <a href="{{ action('SaleController@printPayment',$trans) }}" target="_blank" class="btn btn-success">Print</a>
            @endif
        </div>
    </div>

</div>

<div class="row spacing">
    <div class="col-md-5">
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
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <td>Transaction no: </td><td class="text-right"><b>{{ $trans }}</b></td>
                            </tr>
                            <tr>
                                <td>Name: </td><td class="text-right"><b>{{ $info->fullName }}</b></td>
                            </tr>
                            <tr>
                                <td>Agency: </td><td class="text-right"><b>{{ $info->agencyName }}</b></td>
                            </tr>
                            <tr>
                                <td>Date: </td><td class="text-right"><b>{{ \Carbon\Carbon::parse($saleFirst->created_at)->toFormattedDateString() }}</b></td>
                            </tr>
                            <tr>
                                <td>Package Expiration: </td><td class="text-right" style="color: red;"><b>{{ \Carbon\Carbon::parse($saleFirst->created_at)->addDays($saleFirst->days)->toFormattedDateString() }}</b></td>
                            </tr>
                            @if($saleFirst->status == 0)
                                <tr>
                                    <td>Status:</td><td class="text-right"><b>Unpaid</b></td>
                                </tr>
                            @elseif($saleFirst->status == 1 || $saleFirst->status == 2)
                                <tr class="success">
                                    <td>Status:</td><td class="text-right"><b>Paid</b></td>
                                </tr>
                            @else
                                <tr class="danger">
                                    <td>Status:</td><td class="text-right"><b>Cancel</b></td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="panel-title" style="margin-top: 5px;">Transaction Detail</h3>
                    </div>   
                    <div class="col-md-6">
                       
                    </div>         
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th class="text-center">Package/Services</th>
                                <th class="text-center">Amount</th>
                            </thead>
                            <tbody>
                                @foreach( $sales as $sale )
                                    <tr>
                                        <td>{{ $sale->name }}  @ 1 x {{ number_format($sale->total_price, 2) }}</td>
                                        <td class="text-right">{{ number_format($sale->total_price, 2) }}</td>
                                    </tr>
                                @endforeach
                                @if( $discount !=0 )
                                    <tr>
                                        <td class="text-right"><b>Discount:</b></td>
                                        <td class="text-right">-{{ $discount }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-right"><b>Total Amount:</b></td>
                                    <td class="text-right"><b>{{ number_format($totalAmount, 2) }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection
{{-- ============================Modal============================================ --}}
@section('modal')
<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="accept-payment" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Accept Payment</h4>
            </div>
            {!! Form::open(['method'=>'patch', 'action' => ['SaleController@acceptPayment', $trans]]) !!}
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

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="discount" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Discount</h4>
            </div>
            {!! Form::open(['action' => ['SaleController@discount', $trans]]) !!}
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('amount','Amount') !!}
                            {!! Form::number('amount',$discount,['class'=>'form-control','step'=>'0.01']) !!}
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                            {!! Form::submit('SAVE DISCOUNT', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="add-service" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Add Service</h4>
            </div>
            {!! Form::open(['action' => ['SaleController@addService', $trans]]) !!}
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('Select Service') !!}
                            {!! Form::select('service_id',$serviceList,null,['class'=>'form-control select','placeholder'=>'Please Select Services']) !!}
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                            {!! Form::submit('ADD SERVICE', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection