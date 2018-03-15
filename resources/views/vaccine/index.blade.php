@extends('template')

@section('content')
@php
	use Carbon\Carbon;
@endphp

<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title" style="margin-top: 5px;">Vaccine Module</h3>
			</div>
			<div class="col-md-6">
				<div class="clearfix">
					<a href="#create" class="btn btn-default btn-sm btn-quirk pull-right" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> Create Entry</a>
				</div>
			</div>		
		</div>
	</div>
	
	<div class="panel-body">
        <table id="dataTable1" class="table table-bordered table-striped-col">
        	<thead>
        		<tr style="text-transform: uppercase;">
        			<th class="text-center" width="150px">Last Vaccine Date</th>
        			<th class="text-center">Customer Name</th>
                    <th class="text-center" width="100px">Action</th>
        		</tr>
        	</thead>
        	<tbody>
        		@foreach( $customerList as $details )
        			@if( $details->vaccines()->count() != 0 )
	        			<tr>
	        				<td class="text-center">{{ Carbon::parse($details->lastVaccine)->toFormattedDateString() }}</td>
	        				<td>{{ $details->fullName }}</td>
	        				<td class="text-center" style="padding:5px;">
	        					<a href="{{ action('VaccineController@edit',$details->id) }}" class="btn btn-primary btn-sm">
		        					<span class="glyphicon glyphicon-list"></span>
		        				</a>
		        				<button type="button" class="btn btn-primary btn-sm vaccine-{{ $details->id }}">
		        					<span class="glyphicon glyphicon-print"></span>
		        				</button>
		        				<div style="display: none">
		        					<div class="print-vaccine-{{ $details->id }}">
		        						<a href="{{ action('VaccineController@show',$details->id) }}">Show Print</a>
		        					</div>
		        				</div>
		        			</td>
	        			</tr>
        			@endif 
        		@endforeach
        	</tbody>
        </table>
	</div>
</div>

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="create" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Create Vaccine</h4>
            </div>
            {!! Form::open(['action'=>'VaccineController@store','style'=>'margin-bottom:0px;','id'=>'create_vaccine']) !!}
	            <div class="modal-body">    
	            	<div class="row">
	                	<div class="col-md-6">
	                		<div class="form-group">
	                        	{!! Form::label('Date Given.') !!}
	                            {!! Form::text('date_given',$dateNow,['class'=>'form-control dt date','id'=>'date_given','placeholder'=>'Date Given']) !!}
	                        </div>
	                	</div>
	                	<div class="col-md-6">
	                		<div class="form-group">
	                        	{!! Form::label('Expiry Date') !!}
	                            {!! Form::text('expiry_date',( $last != NULL ? $last->expiry_date : NULL ),['class'=>'form-control','id'=>'expiry_date','placeholder'=>'Expiry Date']) !!}
	                        </div>
	                	</div>
	                </div>
	                <div class="row spacing">
	                    <div class="col-md-12">
	                        <div class="form-group">
	                        	{!! Form::label('Customer Name') !!}
	                            {!! Form::select('customer_id',$customer,null,['class'=>'form-control select','id'=>'customer_id','placeholder'=>'PLEASE SELECT'])!!}
	                        </div>
	                        <div class="form-group">
	                        	{!! Form::label('Brand Name.') !!}
	                            {!! Form::text('brand_name',( $last != NULL ? $last->brand_name : NULL ),['class'=>'form-control','id'=>'brand_name','placeholder'=>'Brand Name']) !!}
	                        </div>
	                        <div class="form-group">
	                        	{!! Form::label('Lot No.') !!}
	                            {!! Form::text('lot_no',( $last != NULL ? $last->lot_no : NULL ),['class'=>'form-control','id'=>'lot_no','placeholder'=>'Lot no.']) !!}
	                        </div>
	                    </div>
	                </div>  
	            </div>
	            <div class="modal-footer">
	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="form-group alert-div">
	                            <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
	                            {!! Form::button('Save', ['class'=>'btn btn-primary','style'=>'margin-top:0px;','id'=>'submit']) !!}
	                        </div>
	                    </div>
	                </div>
	            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('js')

<script type="text/javascript">
	$(document).ready(function() {
		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });


		$(".select").select2();

		$('#submit').click(function() {
	        $.ajax({    //create an ajax request to load_page.php
	            type: 'post',
	            url: "{{ action('VaccineController@store') }}",//php file url diri     
	            data: $("#create_vaccine").serialize(),
	            success: function(response){
	                $.each(response,function(index,value){
		                $(".alert-div").html(value.value);
		            });
	            }
	        });
	    });
	});
</script>


@endsection