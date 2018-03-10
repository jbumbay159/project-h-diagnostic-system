{!! Form::model($data, ['method'=>'patch','id'=>'labResult', 'action' => ['LabResultController@update', $data->id]]) !!}
        <div class="container-fluid">
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
                                <td class="text">9999-99-99</td>
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
                                            <td class="text"><center>{!! Form::text('remarks_val[]',$serviceItem->remarks,['class'=>'inputs','style'=>'text-align:center;']) !!}</center></td>
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
            <p class="notSave text-center">====================== Not Save ======================</p>

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
            <button type="button" id="submit">Save</button>
            {!! Form::submit('Direct') !!}
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
            <script type="text/javascript">
                $(document).ready(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#submit').click(function() {
                        alert('Im click');

                        $.ajax({    //create an ajax request to load_page.php
                            type: 'post',
                            url: "{{ action('LabResultController@update',$data->id) }}",//php file url diri     
                            data: $("#labResult").serialize(),
                            success: function(response){
                                $.each(response,function(index,value){
                                    alert(value.result);
                                });
                            }
                        });
                    });
                });
            </script>
        </div>
        <div style="page-break-after: always;"></div>