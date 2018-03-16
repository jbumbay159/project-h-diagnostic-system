@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>{{ $labResult->name }}</title>
    <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/jquery-ui/jquery-ui.css') ?>">
    <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/select2/select2.css') ?>">
    <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/dropzone/dropzone.css') ?>">
    <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/jquery-toggles/toggles-full.css') ?>">
    <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/fontawesome/css/font-awesome.css') ?>">
    <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/timepicker/jquery.timepicker.css') ?>">
    <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/bootstrapcolorpicker/css/bootstrap-colorpicker.css') ?>">
    <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') ?>">
    <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/select2/select2.css') ?>">
    <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/animate.css/animate.css') ?>">

    <link rel="stylesheet" href="<?php echo asset('public/quirk/css/quirk.css') ?>">
    <style type="text/css">
        @media print {
            button, hr {
                display: none !important;
            }
                input,
                textarea {
                border: none !important;
                box-shadow: none !important;
                outline: none !important;
            }
        }




    </style>
    @if( $data->is_done == 1 && $is_edit == false )
        <style type="text/css">
                button, hr {
                    display: none !important;
                }
                    input,
                    textarea {
                    border: none !important;
                    box-shadow: none !important;
                    outline: none !important;
                }
        </style>
    @endif
</head>
<body style="background-color: #fff;color: #000000;">



@if( $data->is_done != 1 )
        <button type="button" onclick="event.preventDefault();document.getElementById('labResult').submit();">Save</button>
        <hr>
@elseif( $is_edit == true )
    <button type="button" onclick="event.preventDefault();document.getElementById('labResult').submit();">Save</button>
        <hr>
@endif

{!! Form::model($labResult, ['method'=>'patch','id'=>'labResult', 'action' => ['LabResultController@update', $labResult->id]]) !!}
        <div class="container-fluid">
            <div class="row">
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center">
                        HYATT DIAGNOSTIC SYSTEM INC.<br>
                        Main Office: Jaltan Bldg., CM Recto. Davao City, 8000, Philppines<br>
                        Tel No: +(63)(82)268-7569 / email add: hyattdiaginc@gmail.com
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <img class="media-object" src="{{ asset($info->photos) }}" style="width: 15%;">
                </div>
            </div>
            <div class="row spacing">
                <div class="col-md-12">
                    <center>
                        <table style="width: 100%;background-color: #ffffff;">
                            <tr>
                                <td class="label-text">NAME</td>
                                <td class="text">{{ $info->fullName }}</td>
                                <td class="label-text">DATE</td>
                                <td class="text">{{ Carbon::now()->toFormattedDateString() }}</td>
                            </tr>
                            <tr>
                                <td class="label-text">AGE</td>
                                <td class="text">{{ $info->age }} years old</td>
                                <td class="label-text">SEX</td>
                                <td class="text">{{ $info->gender }}</td>
                            </tr>
                        </table>
                    </center>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
            @if( $data->covnv('normal_values') == true || $data->covnv('co_values') == true )
                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                            @foreach($data->items()->get()->groupBy('group') as $groupName => $serviceItems) 
                                <table style="width: 100%;background-color: #ffffff;">
                                    <thead>
                                        <th><u>{{ $groupName }}:</u></th>
                                        <th><u><center>RESULT</center></u></th>

                                        @if($data->covnv('co_values') == true)
                                            <th><u><center>COV</center></u></th>
                                        @endif
                                        @if($data->covnv('normal_values') == true)
                                            <th><u><center>NORMAL VALUE</center></u></th>
                                        @endif
                                        <th><u><center>REMARKS</center></u></th>
                                    </thead>
                                    <tbody>
                                        @foreach( $serviceItems as $serviceItem )
                                        <tr>
                                            <td>{{ $serviceItem->name }}</td>
                                            <td class="text"><center>{!! Form::text('result[]',$serviceItem->result,['class'=>'inputs','style'=>'text-align:center;']) !!}</center></td>
                                            {!! Form::hidden('id[]',$serviceItem->id) !!}
                                            @if($data->covnv('co_values') == true)
                                                <td><center>{{ $serviceItem->co_values }}</center></td>
                                            @endif
                                            @if($data->covnv('normal_values') == true)
                                                <td><center>{{ $serviceItem->normal_values }}</center></td>
                                            @endif
                                            <td><center>{!! Form::text('remarks_val[]',$serviceItem->remarks,['style'=>'text-align:center;']) !!}</center></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="content" style="list-style: none;padding: 0;margin: 0;display: flex;flex-direction: column;flex-wrap: wrap;width: 45%;height: 300px;">
                            @foreach($data->items()->get()->groupBy('group') as $groupName => $serviceItems) 
                                <table style="width: 100%;background-color: #ffffff;">
                                    <thead>
                                        <th width="250px"><u>{{ $groupName }}</u></th>
                                        <th width="150px"><center>&nbsp;</center></th>
                                    </thead>
                                    <tbody>
                                        @foreach( $serviceItems as $serviceItem )
                                        <tr>
                                            <td style="padding: 0px;">{{ $serviceItem->name }}:</td>

                                            <td style="padding: 0px;" class="text">
                                                <center>{!! Form::text('result[]',NULL,['class'=>'inputs','style'=>'text-align:center;']) !!}</center>
                                                {!! Form::hidden('id[]',$serviceItem->id) !!}
                                                {!! Form::hidden('remarks_val[]',$serviceItem->id) !!}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
           
            <p><span style="margin-top:20px;display: block;"><b>REMARKS:</b></span>{!! Form::textarea('labRemarks',$data->remarks,['cols'=>100,'rows'=>2,'class'=>'inputs']) !!}</p>
            <hr style="border: 1px solid;">
            @if( $data->is_done != 1 )
            <p class="notSave text-center">====================== Not Save ======================</p>
            @endif
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center>
                        <b>JOHN PATRICK C. PADILLA, MD. FPSP</b><br>
                        <p>Lic no. 0089855</p>
                    </center>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center>
                        <b>PETER GLENN A. GERONDIO, RMT</b><br>
                        <p>Lic no. 0062752</p>
                    </center>
                </div>
            </div>
            
        </div>
        {{ Form::close() }}
            <script src="<?php echo asset('public/quirk/lib/jquery/jquery.js') ?>"></script>
            <script type="text/javascript">
                $('.inputs').keydown(function (e) {
                     if (e.which === 13) {
                         var index = $('.inputs').index(this) + 1;
                         $('.inputs').eq(index).focus();
                     }
                 });
            </script>
        </div>
        <div style="page-break-after: always;"></div>
</body>
</html>