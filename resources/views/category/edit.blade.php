@extends('template')

@section('content')
{!! Form::model($category,['method'=>'PATCH','action'=>['CategoryController@update',$category->id]]) !!}
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Update Category</h3>
            </div>
            <div class="col-md-6">
                <div class="clearfix">
                    <a href="{{ action('CategoryController@index') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
                    
                    <a href="{{ action('CategoryController@create') }}" class="btn btn-default btn-sm btn-quirk pull-right" style="margin-right: 10px;"><span class="glyphicon glyphicon-plus"></span> Create New Entry</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('name','Name') !!}
                    {!! Form::text('name',null,['class'=>'form-control'])!!}
                </div>
            </div>
        </div>
    </div>
</div>    
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::button('<i class="glyphicon glyphicon-save"></i> UPDATE ENTRY', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk')) !!}
        </div>
    </div>
</div>  
{!! Form::close() !!}
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        
    });
</script>
@endsection