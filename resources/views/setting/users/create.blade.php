@extends('template')

@section('content')

<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-12">
				<h3 class="panel-title">Create New User</h3>
			</div>
		</div>
	</div>
	<div class="panel-body">
		{!! Form::open(['action'=>'SettingUserController@store','files' => true]) !!}
		<div class="row">
			<div class="col-md-6">
				<div class="row">
		            <div class="col-md-6">
		        		<div class="form-group">
		                	{!! Form::label('Username') !!}
		                	{!! Form::text('username', null,['class'=>'form-control input-sm']) !!}
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
        		
        	</div>
		</div>
		<div class="row spacing">
			<div class="col-md-12">
				{!! Form::submit('Create',['class'=>'btn btn-primary']) !!}
				<a href="{{ action('SettingUserController@index') }}" class="btn btn-link">Cancel</a>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection


