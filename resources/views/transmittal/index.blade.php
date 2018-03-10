@php
    use Carbon\Carbon;
@endphp

@extends('template')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Transmittal Index</h3>
            </div>          
        </div>
    </div>
    <div class="panel-body">
    	{!! Form::open(['method'=>'GET','action'=>'TransmittalController@index']) !!}
    	<div class="row">
    		<div class="col-md-4">
    			<div class="form-group">
    				{!! Form::select('id',$customer,null,['class'=>'form-control select','placeholder'=>'Search Customer']) !!}
    			</div>
    		</div>
    		<div class="col-md-2">
    			<div class="form-group">
		            {!! Form::button('<i class="glyphicon glyphicon-search"></i> Search', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk','style'=>'margin-top:0px;')) !!}
		        </div>
    		</div>
    	</div>
    	{!! Form::close() !!}
    </div>
</div>

@if( $info != NULL )
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Transmittal Results</h3>
            </div>
            <div class="col-md-6">
                <div class="clearfix">
                    <a href="#addTrans" data-toggle="modal" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-plus"></span> Add Transmittal</a>
                </div>
            </div>  
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-10">
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                            <img alt="" src="{{ $info->photos }}" style="height: 80px;width: 80px;" class="media-object img-circle">
                        </a>
                    </div>
                    <div class="media-body">
                        <h2 class="media-heading" style="text-transform: uppercase;">{{ $info->fullName }}
                         [{{ $info->agency()->count() }}]</h2>
                        <h5 class="media-heading" style="text-transform: uppercase;">Agency Name: {{ $info->agency()->orderBy('pivot_created_at','desc')->first()->name }}</h5>
                        <h5 class="media-usermeta" style="text-transform: uppercase;">
                            <span class="media-time">Date of Registration: {{ \Carbon\Carbon::parse($info->created_at)->toFormattedDateString() }}</span>
                        </h5>
                        <h5 class="media-usermeta" style="text-transform: uppercase;">
                            <span class="media-time" style="color:red;">Package Expiration: {{ $expiryDate->toFormattedDateString() }}</span>
                        </h5>
                        <!--  -->
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <table id="dataTable1" class="table table-bordered table-striped-col" style="text-transform: uppercase;">
            <thead>
                <tr>
                    <th class="text-center">Date</th>
                    <th class="text-center">Agency</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Remarks</th>
                    <th width="80" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($info->transmittal()->orderBy('created_at', 'desc')->get() as $data)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($data->encode_date)->toFormattedDateString() }}</td>
                        <td>{{ $data->agency->name }}</td>
                        <td>{{ $data->status }}</td>
                        <td>{{ $data->remarks }}</td>
                        <td width="80" class="text-center" style="padding: 5px;">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-cog"></span></button>
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#details-{{ $data->id }}" data-toggle="modal">View Details</a></li>
                                    <li><a href="#edit-{{ $data->id }}" data-toggle="modal">Edit Details</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>        
    </div>
</div>  

@foreach( $info->transmittal as $mdata )
<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="details-{{ $mdata->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Transmittal Details</h4>
            </div>
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="200px"><strong>Customer name:</strong></td><td>{{ $info->fullName }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Agency:</strong></td><td>{{ $mdata->agency->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Encoded Date:</strong></td><td>{{ \Carbon\Carbon::parse($mdata->encode_date)->toFormattedDateString() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td><td>{{ $mdata->status }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Remarks:</strong></td><td>{{ $mdata->remarks }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Expiry Date:</strong></td><td>{{ Carbon::parse($mdata->expiry_date)->toFormattedDateString() }}</td>
                                </tr>
                            </tbody>
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
    </div>
</div>

{{-- Edit Section --}}

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="edit-{{ $mdata->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Update Transmittal</h4>
            </div>
            {!! Form::model($mdata, ['method'=>'patch', 'action' => ['TransmittalController@update', $mdata->id]]) !!}
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::label('encode_date','Date') !!}
                        {!! Form::text('encode_date',$mdata->encode_date,['class'=>'form-control dt date'])!!}
                    </div>
                </div>  
                <div class="row spacing">
                    <div class="col-md-12">
                        {!! Form::label('remarks','Remarks') !!}
                        {!! Form::textarea('remarks',$mdata->remarks,['class'=>'form-control autosize','rows'=>'3','placeholder'=>'Remarks'])!!}
                        <div class="cbk cbk-primary">
                            {!! Form::checkbox('exp_display',1,( $mdata->exp_display == 1 ? true : false ),['form-control']) !!}
                            {!! Form::label('Display') !!}
                        </div>
                    </div>
                </div>  
                <div class="row spacing">
                    <div class="col-md-12">
                        {!! Form::label('status_id','Status') !!}
                        {!! Form::select('status_id',$status,$mdata->status_id,['class'=>'form-control select','placeholder'=>'PLEASE SELECT'])!!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::button('<i class="glyphicon glyphicon-save"></i> SAVE ENTRY', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endforeach

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="addTrans" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Add Transmittal</h4>
            </div>
            {!! Form::open(['action'=> 'TransmittalController@store']) !!}
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::label('encode_date','Date') !!}
                        {!! Form::text('encode_date',$dateNow,['class'=>'form-control dt date'])!!}
                        {!! Form::hidden('customer_id',$info->id) !!}
                        {!! Form::hidden('expiry_date',$expiryDate->toDateString()) !!}
                        
                    </div>
                </div>  
                <div class="row spacing">
                    <div class="col-md-12">
                        {!! Form::label('remarks','Remarks') !!}
                        {!! Form::textarea('remarks',null,['class'=>'form-control autosize','rows'=>'3','placeholder'=>'Remarks'])!!}
                        <div class="cbk cbk-primary">
                            {!! Form::checkbox('exp_display',1,false,['form-control']) !!}
                            {!! Form::label('Display') !!}
                        </div>
                    </div>
                </div>  
                <div class="row spacing">
                    <div class="col-md-12">
                        {!! Form::label('status_id','Status') !!}
                        {!! Form::select('status_id',$status,null,['class'=>'form-control select','placeholder'=>'PLEASE SELECT'])!!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::button('<i class="glyphicon glyphicon-save"></i> SAVE ENTRY', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk')) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                         
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endif
@endsection