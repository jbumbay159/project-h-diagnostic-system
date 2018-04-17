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
                <table id="status" class="table table-bordered table-hover">
                    <thead>
                        <th>Name</th>
                        <th class="text-center" width="70px">Encode Date</th>
                        <th>Agency</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Remarks</th>
                    </thead>
                    <tbody>
                        @foreach($trasmittalStatus as $list)
                            <tr>
                                <td>{{ $list->customer->fullName }}</td>
                                <td class="text-center">{{ $list->encodeDateName }}</td>
                                <td>{{ $list->agency->name }}</td>
                                <td class="text-center">{{ $list->status }}</td>
                                <td>{{ $list->remarks }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#status').DataTable({
                "columnDefs": [
                    { "visible": false, "targets": 2 }
                ],
                "order": [[ 2, 'asc' ]],
                "displayLength": 25,
                "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;
         
                    api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="group info"><td colspan="4" style="font-weight: bold;">'+group+'</td></tr>'
                            );
         
                            last = group;
                        }
                    } );
                }
            } );
         
            // Order by the grouping
            $('#status tbody').on( 'click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
                    table.order( [ 2, 'desc' ] ).draw();
                }
                else {
                    table.order( [ 2, 'asc' ] ).draw();
                }
            } );
        } );
    </script>
@endsection

