@extends('template')
@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Customer Details</h3>
            </div>   
            <div class="col-md-6">
            	<div class="btn-toolbar pull-right" role="toolbar">
                    <a href="{{ action('TransmittalController@index') }}" class="btn-group btn-default btn-sm btn-quirk"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
                </div>
            </div>       
        </div>
    </div>
    <div class="panel-body">
    	<div class="row">
    		<div class="col-md-8">
				<div class="media">
			        <div class="media-left">
			          	<a href="#">
			            	<img alt="" src="{{ $info->photo }}" style="height: 80px;width: 80px;" class="media-object img-circle">
			          	</a>
			        </div>
			        <div class="media-body">
			          	<h2 class="media-heading" style="text-transform: uppercase;">{{ $info->fullName }} [{{ $info->agency()->count() }}]</h2>
			          	<h5 class="media-heading" style="text-transform: uppercase;">Agency Name: {{ $info->agency()->orderBy('pivot_created_at','desc')->first()->name }}</h5>
			          	<h5 class="media-usermeta" style="text-transform: uppercase;">
			            	<span class="media-time">Date of Registration: {{ \Carbon\Carbon::parse($trans->created_at)->toFormattedDateString() }}</span>
			          	</h5>
                        <h5 class="media-usermeta" style="text-transform: uppercase;">
                            <span class="media-time" style="color:red;">Package Expiration: {{ \Carbon\Carbon::parse($info->expirationDate->created_at)->addDays($info->expirationDate->days)->toFormattedDateString() }}</span>
                        </h5>
			        </div>
			    </div>
    		</div>
    		<div class="col-md-4">
    			<span class="center-block text-center">
    				<div class="alert alert-warning" style="color:#000;text-transform: uppercase;">
		                <h4>{{ $trans->name }}</h4>
		            </div>
    			</span>
    		</div>
    	</div>
    	<hr>
        {!! Form::model($trans,['method'=>'PATCH','action'=>['TransmittalController@update',$trans->id]]) !!}
    	<div class="row spacing">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('','Select Status') !!}
                    {!! Form::select('status',$status,$trans->status_id,['class'=>'form-control select','placeholder'=>'PLEASE SELECT']) !!}
                </div>
            </div>    
        </div>
        <div class="row spacing">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('','Remarks') !!}
                    {!! Form::textarea('remarks',null,['class'=>'form-control','size'=>'60x5']) !!}
                </div>
            </div>    
        </div>
        <div class="row spacing">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::button('<i class="glyphicon glyphicon-save"></i> SAVE ENTRY', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk btn-lg','style'=>'margin-top:0px;')) !!}
                </div>
            </div>    
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection