@extends('template')

@section('content')
{!! Form::open(['action'=>'SupplyController@store']) !!}
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Create Supply</h3>
            </div>
            <div class="col-md-6">
                <div class="clearfix">
                    <a href="{{ action('SupplyController@index') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
                    <a href="#import" class="btn btn-default btn-sm btn-quirk pull-right"  data-toggle="modal" style="margin-right: 10px;"><span class="glyphicon glyphicon-save"></span> Import CSV</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    {!! Form::label('name','Name') !!}
                    {!! Form::text('name',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('min_qty','Minimum Qty') !!}
                    {!! Form::number('min_qty',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('unit','Unit') !!}
                    {!! Form::text('unit',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('testunit','Test per Unit') !!}
                    {!! Form::number('testunit',null,['class'=>'form-control'])!!}
                </div>
            </div>
        </div>
        <div class="row spacing">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('remarks','Remarks') !!}
                    {!! Form::text('remarks',null,['class'=>'form-control'])!!}
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

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="import" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Import Supply</h4>
            </div>
            {!! Form::open(['action'=>'SupplyController@importData','style'=>'margin-bottom:0px;','files'=>'true']) !!}
            <div class="modal-body">    
                <div class="row">
                    <p style="padding: 0px 10px;">Please Import using the .CSV file only and with the following column( name, min_qty, unit, testunit and remarks)</p>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::file('importfile',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                            {!! Form::submit('IMPORT', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>