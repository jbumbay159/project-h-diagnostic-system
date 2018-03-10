@extends('template')

@section('content')
{!! Form::open(['action'=>'AgencyController@store']) !!}
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Create Agency</h3>
            </div>
            <div class="col-md-6">
                <div class="clearfix">
                    <a href="{{ action('AgencyController@index') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    {!! Form::label('name','Agency Name') !!}
                    {!! Form::text('name',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('address','Address') !!}
                    {!! Form::text('address',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('contact_person','Contact Person') !!}
                    {!! Form::text('contact_person',null,['class'=>'form-control'])!!}
                </div>
            </div>
        </div>
        <div class="row spacing">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('email','Email Address') !!}
                    {!! Form::select('email[]',[],null,['class'=>'form-control select-tag', 'multiple'=>'multiple'])!!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('contact','Contact Number') !!}
                    {!! Form::select('contact[]',[],null,['class'=>'form-control select-tag', 'multiple'=>'multiple'])!!}
                </div>
            </div>
        </div>
    </div>
</div>    
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::button('<i class="glyphicon glyphicon-save"></i> SAVE ENTRY', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk')) !!}
        </div>
    </div>
</div> 
{!! Form::close() !!} 
@endsection