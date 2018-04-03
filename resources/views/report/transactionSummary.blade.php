@extends('template')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Transaction Summary</h3>
            </div>          
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['method'=>'GET']) !!}
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('Date from') !!}
                        {!! Form::text('date',null,['class'=>'form-control dt','placeholder'=>'SELECT DATE FROM']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('Date to') !!}
                        {!! Form::text('date_to',null,['class'=>'form-control dt','placeholder'=>'SELECT DATE TO']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::button('<i class="glyphicon glyphicon-list"></i> View Agency', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk','style'=>'margin-top:22px;')) !!}
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        <hr>
        <div class="row spacing">
            <div class="col-md-12">
                
            </div>
        </div>
        
    </div>
</div>
@endsection