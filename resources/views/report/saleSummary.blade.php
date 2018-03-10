@extends('template')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Summary Sales Index</h3>
            </div>          
        </div>
    </div>
    <div class="panel-body">
    	{!! Form::open(['method'=>'GET']) !!}
        	<div class="row">
        		<div class="col-md-4">
        			<div class="form-group">
        				{!! Form::text('date_from',null,['class'=>'form-control dt','placeholder'=>'SELECT DATE FROM']) !!}
        			</div>
        		</div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::text('date_to',null,['class'=>'form-control dt','placeholder'=>'SELECT DATE TO']) !!}
                    </div>
                </div>
        		<div class="col-md-2">
        			<div class="form-group">
    		            {!! Form::button('<i class="glyphicon glyphicon-print"></i> Generate Report', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk','style'=>'margin-top:0px;')) !!}
    		        </div>
        		</div>
        	</div>
    	{!! Form::close() !!}
    </div>
</div>
@endsection