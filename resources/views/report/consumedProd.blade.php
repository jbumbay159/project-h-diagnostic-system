@extends('template')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Sales per Agency Index</h3>
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
        		<div class="col-md-4">
        			<div class="form-group">
    		            {!! Form::button('<i class="glyphicon glyphicon-search"></i> Filter', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk','style'=>'margin-top:0px;')) !!}
                         {!! Form::submit('Print', array('class' => 'btn btn-primary btn-quirk','style'=>'margin-top:0px;','name'=>'print')) !!}
    		        </div>
        		</div>
        	</div>
    	{!! Form::close() !!}
        <div class="row spacing">
            <div class="col-md-8">
                <table class="table table-hover">
                    <thead>
                        <th>Name</th>
                        <th class="text-center">Test</th>
                    </thead>
                    @foreach($items->groupBy('supplyName') as $name => $item)
                        <tr>
                            <td>{{ $name }}</td>
                            <td class="text-center">{{ $item->sum('testqty') }} TEST</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection