@extends('template')
@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Customer Details</h3>
            </div>   
            <div class="col-md-6">
            	<div class="btn-toolbar pull-right" role="toolbar">
                    <a href="{{ action('LabResultController@show', $info->id) }}" class="btn-group btn-default btn-sm btn-quirk"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
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
                            <img class="media-object img-circle" src="{{ $info->photos }}" alt="" style="height: 120px;width: 120px;">
			          	</a>
			        </div>
			        <div class="media-body">
			          	<h2 class="media-heading" style="text-transform: uppercase;">
                            {{ $info->last_name.', '.$info->first_name.' '.$info->middle_name.' '.$info->name_extension }}
                        </h2>
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
    			<span class="center-block text-center">
    				<div class="alert alert-warning" style="color:#000;text-transform: uppercase;">
		                <h4>{{ $labResult->sale->name }}</h4>
		            </div>
    			</span>
    		</div>
    	</div>
    	<hr>
    	<h4 style="text-transform: uppercase;">{{ $labResult->name }}</h4>
    	<hr>

        {!! Form::open(['method'=>'PATCH','action'=>['LabResultController@update', $labResult->id]]) !!}
        @if( $labResult->service->is_xray != 1 )
            @if($labResult->items()->count() > 0 )
        	<div class="row spacing">
        		<div class="col-md-12">
        			<table id="" class="table table-bordered table-striped-col" style="text-transform: ;">
        				<thead>
        					<tr>
        						<th class="text-center">Item</th>
                                @if($labResult->covnv('normal_values') == true)
        						<th class="text-center">Normal Values</th>
                                @endif
                                @if($labResult->covnv('co_values') == true)
        						  <th class="text-center">COV</th>
                                @endif
        						<th width="150" class="text-center">Result</th>
                                <th width="150" class="text-center">Remarks</th>
        					</tr>
        				</thead>
        				<tbody>
        					@foreach($labResult->items->groupBy('group') as $title => $list)
                            @if( $title != "" )
                                <tr>
                                    <td colspan="3"><strong>{{ $title }}</strong></td>
                                    @if($labResult->covnv('normal_values') == true)
                                        <td class="text-center"> -- </td>
                                    @endif
                                    @if($labResult->covnv('co_values') == true)
                                        <td class="text-center"> -- </td>
                                    @endif
                                </tr>
                            @endif
                                @foreach ( $list as $data )
                					<tr>
                    					<td>
                                            {{ $title != "" ? ' -- ' : '' }}
                                            {{ $data->name }}
                                            @if( $data->result == NULL || $data->remarks == NULL )
                                                {!! Form::hidden('id[]', $data->id) !!}
                                            @endif
                                        </td>
                                        @if($labResult->covnv('normal_values') == true)
                						  <td>{{ ($data->normal_values == NULL) ? 'NO VALUES' : $data->normal_values }}</td>
                                        @endif
                                        @if($labResult->covnv('co_values') == true)

                						  <td>{{ ($data->co_values == NULL) ? 'NO VALUES' : $data->co_values }}</td>
                                        @endif
                						<td width="150" >
                                            @if( $data->result == NULL || $data->result == NULL )
                                                {!! Form::text('result[]', $data->result,['class'=>'form-control input-sm text-center']) !!}
                                            @else
                                                {{ $data->result }}
                                            @endif
                						</td>
                                        <td width="150" >
                                            @if( $data->remarks == NULL || $data->remarks == NULL )
                                                {!! Form::text('remarks_val[]', $data->remarks,['class'=>'form-control input-sm text-center']) !!}
                                            @else
                                                {{ $data->remarks }}
                                            @endif
                                        </td>
                					</tr>
                                @endforeach
        					@endforeach
        				</tbody>
        			</table>
        		</div>
        	</div>
            @endif
        @endif
        @if ( $labResult->service->is_xray == 1)
            <div class="row spacing">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('Remarks') !!}
                        {!! Form::textarea('remarks',NULL,['class'=>'form-control','size'=>'30x5']) !!}
                    </div>
                </div>
            </div>
            <div class="row spacing">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('Impression') !!}
                        {!! Form::textarea('interpret',NULL,['class'=>'form-control','size'=>'30x1']) !!}
                    </div>
                </div>
            </div>
            <div class="row spacing">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('File No.') !!}
                        {!! Form::text('file_no',NULL,['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
        @else
            <div class="row spacing">
                <div class="col-md-6">
                    <div class="form-group">
                        @if( $labResult->remarks == NULL || $labResult->interpret == NULL )
                            {!! Form::label('','Remarks') !!}
                            {!! Form::textarea('remarks',$labResult->remarks,['class'=>'form-control','size'=>'30x5']) !!}
                        @else
                            <h4>Remarks</h4>
                            <p>{{ $labResult->remarks }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        @if( $labResult->remarks == NULL || $labResult->interpret == NULL )
                            {!! Form::label('','Interpretation') !!}
                            {!! Form::textarea('interpret',$labResult->interpret,['class'=>'form-control','size'=>'30x5']) !!}
                        @else
                            <h4>Interpretation</h4>
                            <p>{{ $labResult->interpret }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif


        <div class="row spacing">
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::button('<i class="glyphicon glyphicon-save"></i> SAVE ENTRY', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk')) !!}
                </div>
            </div>
        </div> 
        {!! Form::close() !!}
    </div>
</div>
@endsection