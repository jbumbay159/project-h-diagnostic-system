@extends('template')

@section('content')

<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h3 class="panel-title">Edit User</h3>
			</div>
		</div>
	</div>
	<div class="panel-body">
		{!! Form::model($user,['action'=>['SettingUserController@update',$user->id],'files' => true]) !!}
		<div class="row">
			<div class="col-md-6">
				<div class="row">
		            <div class="col-md-6">
		        		<div class="form-group">
		                	{!! Form::label('Username') !!}
		                	{!! Form::text('username', $user->name,['class'=>'form-control input-sm']) !!}
		                </div>
		            </div>
		            <div class="col-md-6">
		        		<div class="form-group">
		                	{!! Form::label('Email Address') !!}
		                	{!! Form::text('email', null,['class'=>'form-control input-sm']) !!}
		                </div>
		            </div>
		        </div>
				<hr>
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
		        <div class="row spacing">
		        	<div class="col-md-12">
		        		<div class="form-group">
		        			{!! Form::label('Signature (.png)') !!} 
		        			{!! Form::file('signature') !!}
		        		</div>
		        	</div>
		        </div>
        	</div>
        	<div class="col-md-6">
        		<div class="row">
        			<div class="col-md-12">
		        		<div class="signature-view" style="border: 1px solid;">
			        		<center>
			        			<p style="font-weight: bold;font-size: 20px;color: #161616;padding-top: 70px;">{{ $user->fullName }}</p>
			        			<img src="{{ $signature }}" style="height: 70px;margin-top: -80px;position: initial;display: table;">
			        			@if( $user->license_no != null )
			        				<p style="margin-top: -8px;color: #000;">Lic no. {{ $user->license_no }}</p>
			        			@endif
		        			</center>
		        		</div>
		        	</div>
        		</div>
        		<div class="row spacing">
        			<div class="col-md-12">
        				<a href="#roles" data-toggle="modal" class="btn btn-primary">Edit Roles</a>	
        			</div>
        		</div>
        	</div>
		</div>
		<div class="row spacing">
			<div class="col-md-12">
				{!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
				<a href="{{ action('SettingUserController@index') }}" class="btn btn-link">Cancel</a>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="roles" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">User Role</h4>
            </div>
            {!! Form::model($user,['method'=>'PATCH','action'=>['SettingUserController@update',$user->id]]) !!}
            <div class="modal-body">    
                <div class="row">
                	@foreach( $roles as $role )
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
@endsection


