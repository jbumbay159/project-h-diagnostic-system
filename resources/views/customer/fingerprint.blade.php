<?php
    use Carbon\Carbon;

    $mdbFilename =  $_SERVER["DOCUMENT_ROOT"]."/hyatt/timekeeper/timekeeper.mdb";
    // $mdbFilename =  'D:/xampp/htdocs/laravel/hyatt/public/timekeeper/timekeeper.mdb';
    // $mdbFilename =  system("cmd /c START  E:/xampp/htdocs/hyatt/public/timekeeper/timekeeper.exe");
    if (file_exists($mdbFilename)) {
        $user = "";
        $password = "";
        $db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$mdbFilename; Uid=; Pwd=;");
    }else{
        dd($mdbFilename);
    }


    $insertEmployeeSql = "INSERT INTO employee (employeeid, idno, lname, fname, mname, deptid, password, userlevel) VALUES (:employeeid,:idno,:lname,:fname,:mname,'1','admin123','99')";
    $dInsertEmployeeSql = $db->prepare($insertEmployeeSql);
    $dInsertEmployeeSql->execute(array('employeeid' => $info->id,'idno' => $info->id,'lname'=>$info->last_name,'fname'=>$info->first_name,'mname'=>$info->middle_name));

    $nowDate = Carbon::now()->format('n/d/Y');

    $delSql = "DELETE FROM fingerprint WHERE datecreated!='%".$nowDate."%'";
    $dDelSql = $db->query($delSql);
    $delSql = "DELETE FROM employee WHERE datecreated!='%".$nowDate."%'";
    $dDelSql = $db->query($delSql);


    
    foreach ($info->fingerPrint as $list) {
        // dump($list->templates);
        $insertSql = "INSERT INTO fingerprint (employeeid, finger, template) VALUES (:employeeid,:finger, :template)";
        $dInsertSql = $db->prepare($insertSql);
        $dInsertSql->execute(array('employeeid' => $info->id,'finger' => $list->finger,'template'=>$list->templates));
    }
        //dd($customer->fingerPrint);
?>
@extends('template')

@section('content')

<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::button('OPEN BIO', array('type' => 'button','id' => 'open', 'class' => 'btn btn-primary btn-quirk')) !!}
        </div>
    </div>
    <div class="col-md-6">
        <h2 style="margin: 0px;">ID: {{ $info->id }}</h2>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Fingerprint</h3>
            </div>      
            <div class="col-md-6">
                <div class="clearfix">
                    <a href="{{ action('CustomerController@show', $info->id) }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-user"></span> Back To Profile</a>
                </div>
            </div>  
        </div>
    </div>
    <div class="panel-body">
    	<div id="fingerprint"></div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        setInterval(timestamp, 1000);
    });
    function timestamp() {
        $.ajax({
            url: "{{ action('CustomerController@fingerTable', $info->id) }}",
            success: function(data) {
                $('#fingerprint').html(data);
            },
        });
    }
    
    $('#open').click(function(){
        $.ajax({
          url: "{{ action('CustomerController@openFinger', $info->id) }}",
            success: function(data) {
                alert('Form Open');
            },  
        });
    })
</script>
@endsection
