@extends('template')

@section('content')
{!! Form::open(['action'=> 'AgencyPricingController@store']) !!}
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Create Agency Pricing</h3>
            </div>
            <div class="col-md-6">
                <div class="clearfix">
                    <a href="{{ action('AgencyPricingController@index') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    {!! Form::label('agency','Agency') !!}
                    {!! Form::select('agency_id',$agency,null,['class'=>'form-control select', 'id' => 'agency_id','placeholder'=>'PLEASE SELECT']) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('country','Country') !!}
                    {!! Form::select('country_id',$country,null,['class'=>'form-control select', 'id' => 'agency_id','placeholder'=>'PLEASE SELECT']) !!}
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" style="margin-top:20px;">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('package','Package') !!}
                    {!! Form::select('package_id',$package,null,['class'=>'form-control select', 'id' => 'agency_id','placeholder'=>'PLEASE SELECT']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('pricing_type_id','Price Type') !!}
                    {!! Form::select('pricing_type_id',$pricingType,null,['class'=>'form-control select', 'id' => 'priceType','placeholder'=>'PLEASE SELECT']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('price','Price') !!}
                    {!! Form::number('price','00.00',['class'=>'form-control', 'step'=>'0.01' , 'id' => 'price']) !!}
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