@extends('template')

@section('content')
{!! Form::model($service,['method'=>'PATCH','action'=>['ServiceController@update',$service->id]]) !!}
@php
    $x = 1;
@endphp
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Update Laboratory Service</h3>
            </div>
            <div class="col-md-6">
                <div class="clearfix">

                    <a href="{{ action('ServiceController@index') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
                    <a href="{{ action('ServiceController@create') }}" class="btn btn-default btn-sm btn-quirk pull-right" style="margin-right: 10px;"><span class="glyphicon glyphicon-plus"></span> Create New Entry</a>
                    <a href="print" target="_blank" class="btn btn-primary btn-sm btn-quirk pull-right" style="margin-right: 10px;"><span class="glyphicon glyphicon-print"></span> View Print</a>
                </div>
            </div>            
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('category_id','Category') !!}
                    {!! Form::select('category_id',$categories,null,['class'=>'form-control select','placeholder'=>'PLEASE SELECT'])!!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('name','Name') !!}
                    {!! Form::text('name',null,['class'=>'form-control'])!!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('price','Price') !!}
                    {!! Form::select('price[]',$price,$price,['class'=>'form-control select-tag', 'multiple'=>'multiple'])!!}
                </div>
            </div>
        </div>
        <div class="row spacing">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="ckbox ckbox-primary">
                        @php 
                            $checkValue = ( $service->is_xray == 1 ) ? true : false ;
                        @endphp
                        {!! Form::checkbox('is_xray', 1, $checkValue,['id'=>'x-ray_check']) !!}
                        <span>X-ray Form</span>
                    </label>
                </div>
            </div>
        </div>
        <hr>
        
        <div class="clearfix"></div>
        <div id="form-not-xray">
            <div id="wrap">
                @if( $service->item()->count() == 0 )
                    <div class="wrapp">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('service','Test:') !!}
                                {!! Form::text('service[]',null,['class'=>'form-control']) !!}
                                {!! Form::hidden('id[]','no',['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('cov','COV:') !!}
                                {!! Form::text('cov[]',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('group','Group:') !!}
                                {!! Form::text('group[]',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('nv','Normal Values:') !!}
                                {!! Form::text('nv[]',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button type="button" class="btn btn-default btn-quirk" id="bot" style="margin-top:22px;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>

                @endif

                @foreach( $service->item as $data )
                    @if ( $take_first->id == $data->id )
                        <div class="wrapp">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('service','Test:') !!}
                                    {!! Form::text('service[]',$data->service,['class'=>'form-control']) !!}
                                    {!! Form::hidden('id[]',$data->id,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('cov','COV:') !!}
                                    {!! Form::text('cov[]',$data->cov,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('group','Group:') !!}
                                    {!! Form::text('group[]',$data->group,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('nv','Normal Values:') !!}
                                    {!! Form::text('nv[]',$data->nv,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button type="button" class="btn btn-default btn-quirk" id="bot" style="margin-top:22px;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="clearfix"></div>
                        <div class="wrapp{{ $x++ }}" style="margin-top:20px;">
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::text('service[]',$data->service,['class'=>'form-control']) !!}
                                    {!! Form::hidden('id[]',$data->id,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::text('cov[]',$data->cov,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::text('group[]',$data->group,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::text('nv[]',$data->nv,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button type="button" class="btn btn-default btn-quirk  minus" id="bot"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <hr>
    </div>
</div>    

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-12">
                <label class="ckbox ckbox-success">
                    @php 
                        $if_check = ($service->supplies()->count() == 0) ? false : true ;
                    @endphp
                    {!! Form::checkbox('supplies', 1, $if_check,['id'=>'supplies_check']) !!}
                    <span>Supplies</span>
                </label>
                <!-- <h3 class="panel-title" style="margin-top: 5px;">Supplies</h3> -->
            </div>
        </div>
    </div>
    <div class="panel-body" id="supplies-data">
        <div id="supply-group">
            @if($service->supplies()->count() > 0)
                @foreach($service->supplies()->get() as $suppData)
                    <div class="supply-child">
                        <div class="row  {{ ($service->supplies()->first()->id != $suppData->id) ? 'spacing' : '' }} ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    @if( $service->supplies()->first()->id == $suppData->id )
                                        {!! Form::label('Supply') !!}
                                    @endif
                                    {!! Form::select('supply_id[]',$supply,$suppData->supply_id,['class'=>'form-control select','placeholder'=>'PLEASE SELECT'])!!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    @if( $service->supplies()->first()->id == $suppData->id )
                                        {!! Form::label('No of test') !!}
                                    @endif
                                    {!! Form::number('test[]',$suppData->qty,['class'=>'form-control'])!!}
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    @if( $service->supplies()->first()->id == $suppData->id )
                                        <button type="button" class="btn btn-default btn-quirk" id="addsupply" style="margin-top:22px;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    @else
                                        <button type="button" class="btn btn-default btn-quirk minus"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="supply-child">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('Supply') !!}
                                {!! Form::select('supply_id[]',$supply,null,['class'=>'form-control select','placeholder'=>'PLEASE SELECT'])!!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('No of test') !!}
                                {!! Form::number('test[]',0,['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button type="button" class="btn btn-default btn-quirk" id="addsupply" style="margin-top:22px;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
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
        var supp = 1;
        $('#addsupply').on('click',function(){
        supp++;
        var supdata = '<div class="supply-child'+supp+'">';
            supdata += '<div class="row spacing">';
            supdata += '<div class="col-md-6">';
            supdata += '<div class="form-group">';
            supdata += '{!! Form::select("supply_id[]",$supply,null,["class"=>"form-control select","placeholder"=>"PLEASE SELECT"])!!}';
            supdata += '</div></div>';

            supdata += '<div class="col-md-4">';
            supdata += ' <div class="form-group">';
            supdata += '{!! Form::number("test[]",0,["class"=>"form-control"])!!}';            
            supdata += ' </div></div>';

            supdata += '<div class="col-md-1">';
            supdata += '<div class="form-group">';
            supdata += '<button type="button" class="btn btn-default btn-quirk minus"><i class="fa fa-minus" aria-hidden="true"></i></button>';
            supdata += '</div></div></div></div>';

            $('#supply-group').append(supdata);
            $(".supply-child"+supp+" .select").select2();
        });

        $('#supply-group').on('click','.minus',function(){
            var $s = $(this).parent('div').parent('div').parent('div').parent('div').attr('class');
            $('.'+$s).remove();
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        var x = {{ $x++ }};
        $('#bot').on('click',function(){
        x++;
        var data =  '<div class="clearfix"></div><div class="wrapp'+x+'" style="margin-top:20px;"><div class="clearfix"></div>';
            data += '<div class="col-md-3"><div class="form-group">';
            data += '<input type="text" name="service[]" class="form-control" /><input type="hidden" name="id[]" class="form-control" value="no" /> ';
            data += '</div></div>';

            data += '<div class="col-md-3"><div class="form-group">';
            data += '<input type="text" name="cov[]" class="form-control" /> ';
            data += '</div></div>';

            data += '<div class="col-md-3"><div class="form-group">';
            data += '<input type="text" name="group[]" class="form-control" /> ';
            data += '</div></div>';

            data += '<div class="col-md-2"><div class="form-group">';
            data += '<input type="text" name="nv[]" class="form-control" /> ';
            data += '</div></div>';

            data += '<div class="col-md-1"><div class="form-group">';
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

    if ($('#x-ray_check').is(':checked')) {
        $('#form-not-xray').hide();
    }else{
        $('#form-not-xray').show();
    }

    $('#x-ray_check').click(function() {
        if($(this).is(':checked')) {
            $('#form-not-xray').hide('fade');
        } else {
            $('#form-not-xray').show('fade');
        }
    });

    if($('#supplies_check').is(':checked')) {
        $('#supplies-data').show('slow');
    } else {
        $('#supplies-data').hide('slow');
    }

    $('#supplies_check').click(function() {
        if($(this).is(':checked')) {
            $('#supplies-data').show('slow');
        } else {
            $('#supplies-data').hide('slow');
        }
    });

   
    
</script>
@endsection