@extends('template')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">X-ray Index</h3>
            </div>          
        </div>
    </div>
    <div class="panel-body">
    	{!! Form::open(['method'=>'GET']) !!}
    	<div class="row">
    		<div class="col-md-4">
    			<div class="form-group">
    				{!! Form::select('customer',$customer,null,['class'=>'form-control select','placeholder'=>'Search Customer']) !!}
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
@if( $info != NULL )
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="panel-title" style="margin-top: 5px;">Customer Details</h3>
                </div>   
                <div class="col-md-6">
                    <div class="btn-toolbar pull-right" role="toolbar">
                        <a href="#" class="btn-group btn-default btn-sm btn-quirk" id="open"> Open Bio</a>
                        <a href="{{ action('LabResultController@index') }}" class="btn-group btn-default btn-sm btn-quirk"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
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
                                <img alt="" src="{{ $info->photos }}" style="height: 80px;width: 80px;" class="media-object img-circle">
                            </a>
                        </div>
                        <div class="media-body">
                            <h2 class="media-heading" style="text-transform: uppercase;">{{ $info->last_name.', '.$info->first_name.' '.$info->middle_name.' '.$info->name_extension }}</h2>
                            <h5 class="media-heading" style="text-transform: uppercase;">Agency Name: {{ $info->agency()->orderBy('created_at','desc')->first()->name }}</h5>
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
                    <div class="btn-toolbar pull-right" role="toolbar">
                        <a href="#perform-test" data-toggle="modal" class="btn btn-primary">Assign</a>
                        <a href="#" class="btn btn-primary">View History</a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row spacing">
                <div class="col-md-12">
                    <table class="table table-bordered table-sm table-striped-col" style="text-transform: uppercase;">
                        <thead>
                            <tr>
                                <th class="text-center">Package</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($info->sales()->orderBy('created_at','desc')->get() as $sales )
                                <tr>
                                    <td>{{ $sales->name }}</td>
                                </tr>
                            @endforeach                     
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal bounceIn animated" tabindex="-1" role="dialog" id="perform-test" aria-hidden="true">
        <div class="modal-dialog">
            {!! Form::open(['action'=>'XrayController@store']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myLargeModalLabel">Assign</h4>
                </div>
                <div class="modal-body">    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('Date Given.') !!}
                                {!! Form::text('date_given',$dateNow,['class'=>'form-control dt date','id'=>'date_given','placeholder'=>'Date Given']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Select Test') !!}
                                {!! Form::select('lab_result_id',$labResults,null,['class'=>'form-control select', 'placeholder'=>'PLEASE SELECT'])!!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('File No.') !!}
                                {!! Form::text('file_no',NULL,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Clinical Data') !!}
                                {!! Form::text('clinical_data',NULL,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Radiologist') !!}
                                {!! Form::select('radiologist_id',$users,$radio_latest ,['class'=>'form-control select', 'placeholder'=>'PLEASE SELECT'])!!}
                            </div>
                            <div class="form-group">
                                <p>Prepared By. <b>{{ $currentUser->fullName }}</b></p>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::submit('SUBMIT',['class'=>'btn btn-primary']) !!}
                            <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endif
@endsection