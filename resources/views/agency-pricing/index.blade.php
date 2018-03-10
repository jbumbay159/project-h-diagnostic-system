@extends('template')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Agency Pricing Module</h3>
            </div>          
            <div class="col-md-6">
                <div class="clearfix">
                    <a href="{{ action('AgencyPricingController@create') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-plus"></span> Create Entry</a>
                </div>
            </div>  
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['method'=>'GET']) !!}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::select('agency',$agency,null,['class'=>'form-control select','placeholder'=>'All Agencies' , 'id'=> 'agency_id']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::select('package',$package,null,['class'=>'form-control select','placeholder'=>'All Packages' , 'id'=> 'package_id']) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::button('<i class="glyphicon glyphicon-search"></i> FILTER', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk','style'=>'margin-top:0px;', 'id' => 'ajax-btn')) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <hr>
        <div class="row spacing">
            <div class="col-md-12">
                <table id="dataTable1" class="table table-bordered table-striped-col"  style="text-transform: uppercase;font-weight: bold;">
                    <thead>
                        <tr>
                            <th class="text-center">Agency</th>
                            <th class="text-center">Package</th>
                            <th class="text-center">Price type</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="ajax-list">
                        @foreach( $agencyPricing as $data )
                            <tr>
                                <td>{{ $data->package->name }}</td>
                                <td>{{ $data->agency->name }}</td>
                                <td>{{ $data->pricingType->name }}</td>
                                <td>{{ number_format($data->price, 2, ".", ",") }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-cog"></span></button>
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ action('AgencyPricingController@edit', $data->id) }}">Edit</a></li>
                                            <li><a style="color: red;" href="#destroy-{{ $data->id }}" data-toggle="modal"">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('modal')

@foreach( $agencyPricing as $dataModal )
<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="destroy-{{ $dataModal->id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Warning</h4>
            </div>
            {!! Form::model($dataModal, ['method'=>'DELETE', 'action' => ['AgencyPricingController@destroy', $dataModal->id]]) !!}
                <div class="modal-body">    
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="text-center">Are you sure you want to delete?</h2>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                            {!! Form::submit('DELETE', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endforeach
@endsection