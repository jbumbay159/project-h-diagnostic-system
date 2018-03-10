@extends('template')
@section('content')

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Customer Index</h3>
            </div>          
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['method'=>'post','action'=>'LabResultController@store']) !!}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::select('customer',$customer,$info->id,['class'=>'form-control select','placeholder'=>'Search Customer']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::button('<i class="glyphicon glyphicon-search"></i> SEARCH', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk','style'=>'margin-top:0px;')) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Customer Details</h3>
            </div>   
            <div class="col-md-6">
            	<div class="btn-toolbar pull-right" role="toolbar">
                    <a href="#" class="btn-group btn-default btn-sm btn-quirk" id="open"> Open Bio</a>
                    <a href="{{ action('LabResultController@index') }}" class="btn-group btn-default btn-sm btn-quirk"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
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
                            <img alt="" src="{{ $info->photos }}" style="height: 80px;width: 80px;" class="media-object img-circle">
                        </a>
			        </div>
			        <div class="media-body">
			          	<h2 class="media-heading" style="text-transform: uppercase;">{{ $info->last_name.', '.$info->first_name.' '.$info->middle_name.' '.$info->name_extension }}</h2>
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
                <div class="btn-toolbar pull-right" role="toolbar">
                    <a href="#perform-test" data-toggle="modal" class="btn btn-primary">Perform Test</a>
                    <a href="#" class="btn btn-primary">View History</a>
                </div>
    		</div>
    	</div>
    	<hr>
    	<div class="row spacing">
    		<div class="col-md-12">
    			<table class="table table-bordered table-sm table-striped-col" style="text-transform: uppercase;">
    				<thead>
    					<tr>
    						<th class="text-center">Package</th>
    					</tr>
    				</thead>
    				<tbody>
                        @foreach($info->sales()->orderBy('created_at','desc')->get() as $sales )
                            <tr>
                                <td>{{ $sales->name }}</td>
                            </tr>
                        @endforeach    					
    				</tbody>
    			</table>
    		</div>
    	</div>
    </div>
</div>

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="perform-test" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Perform Test</h4>
            </div>
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <th class="text-center">Available Test</th>
                                <th>Action</th>
                            </thead>
                            @foreach($labResults as $data)
                                @if( $data->isxray == 0 )
                                <tr>
                                    <td>{{ $data->name }}</td>
                                    <td class="text-center" width="80" style="text-transform: uppercase; padding: 5px;">
                                        <button type="button" class="btn btn-primary btn-sm service-{{ $data->id }}"><span class="glyphicon glyphicon-edit"></span></button>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="unpaid" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Notice</h4>
            </div>
            
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <h2 style="text-align: center;">This service is unavailable</h2>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display: none;">
    @foreach($labResults as $data)
    @if( $data->isxray == 0 )
        <div class="print-service print-service-{{ $data->id }}" style="background-color: #ffffff; color: #000000;">
            <a href="{{ action('LabResultController@edit',$data->id) }}">Edit</a>
        </div>
    @endif
    @endforeach
</div>


@endsection
@section('js')
<script>
    $('#open').click(function(){
        $.ajax({
          url: "{{ action('CustomerController@openFinger', $info->id) }}",
            success: function(data) {
                alert('Form Open');
            },  
        });
    })
</script>



<script type="text/javascript">
@foreach($labResults as $list)
    $(function(){
        $(".service-{{ $list->id }}").printPreview({
            obj2print:'.print-service-{{ $list->id }}',
            width:'810',
            title:'{{ $list->name }}'
            
            /*optional properties with default values*/
            //obj2print:'body',     /*if not provided full page will be printed*/
            //style:'',             /*if you want to override or add more css assign here e.g: "<style>#masterContent:background:red;</style>"*/
            //width: '670',         /*if width is not provided it will be 670 (default print paper width)*/
            //height:screen.height, /*if not provided its height will be equal to screen height*/
            //top:0,                /*if not provided its top position will be zero*/
            //left:'center',        /*if not provided it will be at center, you can provide any number e.g. 300,120,200*/
            //resizable : 'yes',    /*yes or no default is yes, * do not work in some browsers*/
            //scrollbars:'yes',     /*yes or no default is yes, * do not work in some browsers*/
            //status:'no',          /*yes or no default is yes, * do not work in some browsers*/
            //title:'Print Preview' /*title of print preview popup window*/
            
        });
    });
@endforeach
</script>


@endsection