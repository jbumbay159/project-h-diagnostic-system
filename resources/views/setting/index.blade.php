@extends('template')

@section('content')

@include('setting.nav')
{!! Form::open(['action'=>'SettingController@store']) !!}
<div class="row spacing">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6">
						<h3 class="panel-title" style="margin-top: 5px;">Vaccine Report</h3>
					</div>
					<div class="col-md-6">
					</div>		
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					{!! Form::label('Nurse') !!}
					{!! Form::text('vaccine_nurse',$settings['vaccine_nurse'],['class'=>'form-control']) !!}
				</div>
				<div class="form-group">
					{!! Form::label('Nurse License No.') !!}
					{!! Form::text('vaccine_license',$settings['vaccine_license'],['class'=>'form-control']) !!}
				</div>
				<div class="form-group">
					{!! Form::label('Signature (Optional)') !!}
					{!! Form::file('vaccine_signature',['class'=>'form-control']) !!}
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		{!! Form::submit('Save Settings',['class'=>'btn btn-primary']) !!}
	</div>
</div>
{!! Form::close() !!}


@endsection

