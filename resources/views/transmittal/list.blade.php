@php
    use Carbon\Carbon;
@endphp
@extends('template')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Transaction Summary</h3>
            </div>          
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['method'=>'GET']) !!}
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('Date from') !!}
                        {!! Form::text('date_from',null,['class'=>'form-control dt','placeholder'=>'SELECT DATE FROM']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('Date to') !!}
                        {!! Form::text('date_to',null,['class'=>'form-control dt','placeholder'=>'SELECT DATE TO']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::button('<i class="glyphicon glyphicon-list"></i> View Agency', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk','style'=>'margin-top:22px;')) !!}
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        <hr>
        <div class="row spacing">
            <div class="col-md-12">
                @if( $dateExist == true)
                    <table id="dataTable1" class="table table-bordered table-hover table-striped-col" style="text-transform: uppercase;">
                        <thead>
                            <tr>
                                <th class="text-center">Agency Name</th>
                                <th width="80" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transmittal as $agency => $list)
                                <tr>
                                    <td>{{ $agency }}</td>
                                    <td class="text-center" style="padding: 5px;"><button  id="agency-{{ str_slug($agency,'-') }}" type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-print"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>  
                @endif       
            </div>
        </div>
        
    </div>
</div>
<div style="display: none;">
@if( $dateExist == true)
    @foreach($transmittal as $agency => $list)
        <div id="print-agency-{{ str_slug($agency,'-') }}" style="background-color: #ffffff;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">COMPANY NAME</h3>
                        <h4 class="text-center">Company Address</h4>
                        <hr>
                        <h4 class="text-center">Agency/Account Group: <strong>{{ $agency }}</strong></h4>      
                        <h4 class="text-center">Date Covered: {{ \Carbon\Carbon::parse($date_from)->toFormattedDateString() }} - {{ \Carbon\Carbon::parse($date_to)->toFormattedDateString() }}</h4>                  
                    </div>
                </div>
                <div style="margin-top:10px;"></div>
                <div class="row">
                    <div class="col-md-12">
                    @foreach( $list->groupBy('customer_id') as $comId => $listData )
                        @php
                            $info = \App\Customer::findOrFail($comId);
                            $trans = $info->transmittal()->orderBy('created_at', 'DESC')->first();
                        @endphp
                        <p class="h4">{{ $info->last_name.', '.$info->first_name.' '.$info->middle_name.' '.$info->name_extension }}</p>
                        <p>Date of Expiration: {{ \Carbon\Carbon::parse($trans->created_at)->addDays($trans->days)->toFormattedDateString() }}</p>
                        

                        <table style="text-transform: uppercase;font-size: 12px;background-color: #ffffff;width: 100%;  ">
                            <thead>
                                <tr>
                                    <th width="150px">Date</th>
                                    <th width="200px">Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $listData as $data )
                                    @if ( $data->encode_date != NULL )
                                        <tr style="border-top: 2px solid #ddd;">
                                            <td style="padding: 10px 0px;">{{ \Carbon\Carbon::parse($data->encode_date)->toFormattedDateString() }}</td>   
                                            <td style="padding: 10px 0px;">{{ $data->status }}</td>    
                                            <td style="padding: 10px 0px;">{{ $data->remarks }} {{ ( $data->exp_display == 1 ) ? ' Expiry Date:'.Carbon::parse($data->expiry_date)->toFormattedDateString() : '' }}</td>   
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                    </div>
                </div>
                <div class="row spacing">
                    <div class="col-md-12">
                        <p>PREPARED BY: CASHIER NAME HERE</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
</div>








@endsection
@section('js')
@if( $dateExist == true)
    <script type="text/javascript">
        $(function(){
            @foreach($transmittal as $agency => $list)
                $("#agency-{{ str_slug($agency,'-') }}").printPreview({
                    obj2print:'#print-agency-{{ str_slug($agency,"-") }}',
                    width:'810',
                    title:'{{ $agency }}'
                    
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
            @endforeach
        });
    </script>
@endif
@endsection