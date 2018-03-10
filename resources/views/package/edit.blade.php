@extends('template')

@section('content')
{!! Form::model($package, ['method'=>'patch', 'action' => ['PackageController@update', $package->id]]) !!}
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Update Package</h3>
            </div>
            <div class="col-md-6">
                <div class="clearfix">
                    <a href="{{ action('PackageController@index') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
                    <a href="{{ action('PackageController@create') }}" class="btn btn-default btn-sm btn-quirk pull-right" style="margin-right: 10px;"><span class="glyphicon glyphicon-plus"></span> Create New Entry</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('name','Name') !!}
                    {!! Form::text('name',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('price','Price') !!}
                    {!! Form::text('price',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('days','Interval Days') !!}
                    {!! Form::text('days',null,['class'=>'form-control'])!!}
                </div>
            </div>
        </div>
        <hr>
        <div class="clearfix"></div>
        <div id="wrap">
            @php
                $x = 1;
            @endphp
            @foreach($list as $key => $data)
                @if ($service_id == $key)
                    <div class="wrapp">
                        <div class="col-md-10">
                            <div class="form-group">
                                {!! Form::label('service','Select Service:') !!}
                                 {!! Form::select('service[]',$service,$key,['class'=>'form-control select','placeholder'=>'PLEASE SELECT']) !!}
                                 {!! Form::hidden('id[]',$key) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-default btn-quirk" id="bot" style="margin-top:22px;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="clearfix"></div>
                    <div class="wrapp{{ $x++ }}" style="margin-top:20px;">
                        <div class="col-md-10">
                            <div class="form-group">
                                 {!! Form::select('service[]',$service,$key,['class'=>'form-control select','placeholder'=>'PLEASE SELECT']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-default btn-quirk minus" id="bot"><i class="fa fa-minus" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="clearfix"></div>
        <hr>
    </div>
</div>    
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::button('<i class="glyphicon glyphicon-save"></i> SAVE ENTRY', array('type' => 'submit', 'class' => 'btn btn-primary btn-quirk')) !!}
        </div>
    </div>
</div> 
{!! Form::close() !!} 
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        var x = {{ $x++ }};
        $('#bot').on('click',function(){
        x++;
        var data = '<div class="clearfix"></div><div class="wrapp'+x+'" style="margin-top:20px;"><div class="clearfix"></div><div class="col-md-10"><div class="form-group">';
            data += '{!! Form::select("service[]",$service,null,["class"=>"form-control select","placeholder"=>"PLEASE SELECT"]) !!}';
            data += '</div></div>';

            data += '<div class="col-md-2"><div class="form-group">';
            data += '<button type="button" class="btn btn-default btn-quirk minus" ><i class="fa fa-minus" aria-hidden="true"></i></button>';
            data += '</div></div></div>';

            $('#wrap').append(data);
            $(".wrapp"+x+" .select").select2();

        });

        $('#wrap').on('click','.minus',function(){
            var $a = $(this).parent('div').parent('div').parent('div').attr('class');
            $('.'+$a).remove();
            var sum = 0;
            var num = [];
            $('.amount').each(function(){
                var total = $(this).val();
                num.push(total)
            });
            $.each(num,function(){
                sum += parseFloat(this);
            });

            $('#total').val(sum);
        });


    });
</script>
@endsection