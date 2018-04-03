@extends('template')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Status Report</h3>
            </div>          
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['method'=>'GET']) !!}
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('Agency') !!}
                        {!! Form::select('agency',$agencies,null,['class'=>'form-control select','placeholder'=>'All']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('Status') !!}
                        {!! Form::select('status',$status,null,['class'=>'form-control select','placeholder'=>'All']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('Date from') !!}
                        {!! Form::text('date_from',$dateNow,['class'=>'form-control dt','placeholder'=>'SELECT DATE FROM']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('Date to') !!}
                        {!! Form::text('date_to',$dateNow,['class'=>'form-control dt','placeholder'=>'SELECT DATE TO']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::button('<i class="glyphicon glyphicon-search"></i> Filter', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk','style'=>'margin-top:22px;')) !!}
                        {!! Form::submit('Print', array('class' => 'btn btn-primary btn-quirk','style'=>'margin-top:22px;','name'=>'print')) !!}
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        <hr>
        <div class="row spacing">
            <div class="col-md-12">
                <table class="table table-bordered table-hover">
                    <thead>
                        <th>Name</th>
                        <th class="text-center">Encode Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Remarks</th>
                    </thead>
                    <tbody>
                        @foreach($trasmittalStatus as $agency => $lists)
                            <tr>
                                <td colspan="3"><b>{{ $agency }}</b></td>
                            </tr>
                            @foreach($lists as $list)
                                <tr>
                                    <td>{{ $list->customer->fullName }}</td>
                                    <td class="text-center">{{ $list->encodeDateName }}</td>
                                    <td class="text-center">{{ $list->status }}</td>
                                    <td>{{ $list->remarks }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

