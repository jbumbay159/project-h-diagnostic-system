<?php
    $mdbFilename =  $_SERVER["DOCUMENT_ROOT"]."/laravel/hyatt/public/timekeeper/timekeeper.mdb";
    if (file_exists($mdbFilename)) {
        $user = "";
        $password = "";
        $db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$mdbFilename; Uid=; Pwd=;");
    }else{
        dd($mdbFilename);
    }

    $upSql = "UPDATE employee SET idno ='".$info->id."', lname='".$info->last_name."', fname='".$info->first_name."', mname='".$info->middle_name."' WHERE employeeid=1";
    $done = $db->query($upSql);
    
    $delSql = "DELETE FROM fingerprint WHERE employeeid=1";
    $dDelSql = $db->query($delSql);
    foreach ($info->fingerPrint as $list) {
        // dump($list->templates);
        $insertSql = "INSERT INTO fingerprint (employeeid, finger, template) VALUES ('1',:finger, :template)";
        $dInsertSql = $db->prepare($insertSql);
        $dInsertSql->execute(array('finger' => $list->finger,'template'=>$list->templates));
    }
        //dd($customer->fingerPrint);
?>

@extends('template')

@section('content')
{!! Form::model($info, ['method'=>'patch', 'action' => ['CustomerController@update', $info->id]]) !!}
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Update Customer</h3>
            </div>
            <div class="col-md-6">
                <div class="btn-toolbar pull-right" role="toolbar">
                    <a href="{{ action('CustomerController@index') }}" class="btn btn-default btn-sm btn-quirk"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('last_name','Last Name') !!}
                    {!! Form::text('last_name',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('first_name','First Name') !!}
                    {!! Form::text('first_name',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('middle_name','Middle Name') !!}
                    {!! Form::text('middle_name',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('name_extension','Ext') !!}
                    {!! Form::text('name_extension',null,['class'=>'form-control'])!!}
                </div>
            </div>
        </div>
        <div class="row spacing">
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('gender','Gender') !!}
                    {!! Form::select('gender',['MALE'=>'MALE','FEMALE'=>'FEMALE'],null,['class'=>'form-control select','placeholder'=>'PLEASE SELECT'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('birthdate','Birthdate') !!}
                    {!! Form::text('birthdate',null,['class'=>'form-control dt'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('address','Address') !!}
                    {!! Form::text('address',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('contact_number','Contact Number') !!}
                    {!! Form::text('contact_number',null,['class'=>'form-control'])!!}
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('agency','Agency') !!}
                    {!! Form::select('agency',$agency,$info->agency()->orderBy('pivot_created_at','desc')->first()->id,['class'=>'form-control select','placeholder'=>'PLEASE SELECT'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('country','Country') !!}
                    {!! Form::select('country',$country,$info->country()->orderBy('pivot_created_at','desc')->first()->id,['class'=>'form-control select','placeholder'=>'PLEASE SELECT'])!!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('remarks','Remarks') !!}
                    {!! Form::text('remarks',null,['class'=>'form-control'])!!}
                </div>
            </div>
        </div>
    </div>
</div>    
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::button('<i class="glyphicon glyphicon-save"></i> UPDATE ENTRY', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk')) !!}
        </div>
    </div>
</div>  
{!! Form::close() !!}
@endsection