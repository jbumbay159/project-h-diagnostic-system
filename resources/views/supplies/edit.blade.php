@extends('template')

@section('content')
{!! Form::model($item, ['method'=>'patch', 'action' => ['SupplyController@update', $item->id]]) !!}
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Edit Supply</h3>
            </div>
            <div class="col-md-6">
                <div class="clearfix">
                    <a href="{{ action('SupplyController@index') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
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
                    {!! Form::number('test_per_unit',null,['class'=>'form-control'])!!}
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