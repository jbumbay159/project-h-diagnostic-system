@extends('template')

@section('content')
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title" style="margin-top: 5px;">Supplies Module</h3>
			</div>
			<div class="col-md-6">
				<div class="clearfix">
					<a href="{{ action('SettingController@index') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-plus"></span> Create Entry</a>
				</div>
			</div>		
		</div>
	</div>
	<div class="panel-body">
		@include('setting.nav')
		<div class="row">
			{!! Form::open(['action'=>'SettingController@store']) !!}
			<div class="col-md-6">
				<div class="form-group">
					{!! Form::label('Vaccine Nurse') !!}
					{!! Form::text('vaccine_nurse',NULL,['class'=>'form-control']) !!}
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection

