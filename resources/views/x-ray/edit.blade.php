@php
    use Carbon\Carbon;
@endphp
@extends('template')

@section('content')
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title" style="margin-top: 5px;">Radiography Section</h3>
			</div>
            <div class="col-md-6">
                <div class="btn-toolbar pull-right" role="toolbar">
                    <a href="{{ action('XrayController@radiologist') }}" class="btn-group btn-default btn-sm btn-quirk"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
                </div>
            </div>
		</div>
	</div>
	<div class="panel-body">
        <div class="row">
            <div class="col-md-8">
                <table  class="table">
                    <tr>
                        <td>File No:</td>
                        <td><b>{{ $xrayResult->file_no }}</b></td>
                        <td>Date:</td>
                        <td><b>{{ $xrayResult->date }}</b></td>
                    </tr>
                    <tr>
                        <td>Name: </td>
                        <td><b>{{ $xrayResult->customer->fullName }}</b></td>
                        <td>Age:</td>
                        <td><b>{{ $xrayResult->customer->age }} years old</b></td>
                    </tr>
                    <tr>
                        <td>Examination:</td>
                        <td><b>{{ $xrayResult->labResult->name }}</b></td>
                        <td>Sex:</td>
                        <td><b>{{ $xrayResult->customer->gender }}</b></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-offset-2 col-md-2">
                <img src="{{ $xrayResult->customer->photos }}" width="100%">
            </div>
        </div>
        @if( $xrayResult->is_done == 0 )
            {!! Form::model($xrayResult, ['method'=>'PATCH','action'=>['XrayController@update', $xrayResult->id]]) !!}
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        {!! Form::label('Remarks') !!}
                        {!! Form::textarea('remarks',NULL,['class'=>'form-control','rows'=>'5']) !!}
                        {!! Form::hidden('is_done',1) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Impression') !!}
                        {!! Form::textarea('impression',NULL,['class'=>'form-control','rows'=>'5']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
                    </div>
                </div>
            </div>  
            {!! Form::close() !!}
        @else
            <div class="row">
                <div class="col-md-10">
                    <h4>Remarks</h4>
                    <p>{{ $xrayResult->remarks }}</p>
                    <h4>Impression</h4>
                    <p>{{ $xrayResult->impression }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ action('XrayController@radiologistPrint',$xrayResult->id) }}" target="_blank" class="btn btn-success">View Print</a>
                </div>
            </div>
        @endif


        
	</div>
</div>
@endsection
