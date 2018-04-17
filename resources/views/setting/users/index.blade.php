@extends('template')

@section('content')
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title" style="margin-top: 5px;">Users</h3>
			</div>
			<div class="col-md-6">
				<div class="clearfix">
					<a href="{{ action('SettingUserController@create') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-plus"></span> Create Entry</a>
				</div>
			</div>			
		</div>
	</div>
	<style type="text/css">
		td{
			text-align: center;
			font-size: 12px;
		}
		td:nth-child(3){
			padding: 5px !important;
		}
	</style>
	<div class="panel-body">
		<table id="dataTable1" class="table table-hover table-bordered">
			<thead>
				<th class="text-center">Name</th>
				<th class="text-center">Position</th>
				<th class="text-center">Action</th>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td>{{ $user->fullName }}</td>
						<td>{{ $user->position }}</td>
						<td>
							<a href="{{ action('SettingUserController@edit',$user->id) }}" class="btn btn-default btn-sm">INFO</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection


@foreach($users as $user)
	<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="user-{{ $user->id }}" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title" id="myLargeModalLabel">Update User</h4>
	            </div>
	            {!! Form::model($user,['method'=>'PATCH','action'=>['SettingUserController@update',$user->id]]) !!}
	            <div class="modal-body">    
	                <div class="row">
	                    <div class="col-md-12">
	                		<div class="form-group">
	                        	{!! Form::label('Name') !!}
	                        	{!! Form::text('fullName', null,['class'=>'form-control input-sm']) !!}
	                        </div>
	                    </div>
	                </div>
	                <div class="row spacing">
	                    <div class="col-md-6">
	                		<div class="form-group">
	                        	{!! Form::label('Position') !!}
	                        	{!! Form::text('position', null,['class'=>'form-control input-sm']) !!}
	                        </div>
	                    </div>
	                     <div class="col-md-6">
	                		<div class="form-group">
	                        	{!! Form::label('License No.') !!}
	                        	{!! Form::text('license_no', null,['class'=>'form-control input-sm']) !!}
	                        </div>
	                    </div>
	                </div>  
	                <hr>
	                <div class="row spacing">
	                    <div class="col-md-6">
	                		<div class="form-group">
	                        	{!! Form::label('Username') !!}
	                        	{!! Form::text('name', null,['class'=>'form-control input-sm']) !!}
	                        </div>
	                    </div>
	                    <div class="col-md-6">
	                		<div class="form-group">
	                        	{!! Form::label('Email Address') !!}
	                        	{!! Form::text('email', null,['class'=>'form-control input-sm']) !!}
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <div class="row">
	                    <div class="col-md-12">
	                        {!! Form::button('<i class="glyphicon glyphicon-save"></i> SAVE ENTRY', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk')) !!}
	                        <button type="button" class="btn btn-link" data-dismiss="modal">CLOSE</button>
	                    </div>
	                </div>
	            </div>
	            {!! Form::close() !!}
	        </div>
	    </div>
	</div>
	<!-- User Role Down -->
	<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="user-roles-{{ $user->id }}" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title" id="myLargeModalLabel">{{ $user->fullName }}</h4>
	            </div>
	            {!! Form::model($user,['method'=>'PATCH','action'=>['SettingUserController@update',$user->id]]) !!}
	            {!! Form::hidden('update_rules',1) !!}
	            <div class="modal-body">  
	            	<div class="row">  
		        		@foreach( $roles->whereIn('name',['administrator']) as $role )
							<div class="col-md-3">
							  	<label  class="ckbox ckbox-primary ckbox-md">
									{{ Form::checkbox('roles[]',$role->name,$user->hasChecked($role->name)) }} 
									<span>{{ $role->description }}</span>
							  	</label>
							</div>
			            @endforeach
		            </div>
	            	
	            	<div class="row">
			           	@foreach( $roles->whereIn('name',['radiologist']) as $role )
							<div class="col-md-3">
							  	<label  class="ckbox ckbox-primary ckbox-md">
									{{ Form::checkbox('roles[]',$role->name,$user->hasChecked($role->name)) }} 
									<span>{{ $role->description }}</span>
							  	</label>
							</div>
		            	@endforeach
                    </div>
	            </div>
	            <div class="modal-footer">
	                <div class="row">
                        {!! Form::button('<i class="glyphicon glyphicon-save"></i> SAVE ENTRY', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk')) !!}
                        <button type="button" class="btn btn-link" data-dismiss="modal">CLOSE</button>
	                </div>
	            </div>
	            {!! Form::close() !!}
	        </div>
	    </div>
	</div>

@endforeach
