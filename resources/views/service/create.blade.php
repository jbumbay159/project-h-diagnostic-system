@extends('template')

@section('content')
{!! Form::open(['action'=>'ServiceController@store']) !!}
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Create Laboratory Service</h3>
            </div>
            <div class="col-md-6">
                <div class="clearfix">
                    <a href="{{ action('ServiceController@index') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-home"></span> Back to Index</a>
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
                    {!! Form::select('price[]',[],null,['class'=>'form-control select-tag', 'multiple'=>'multiple'])!!}
                </div>
            </div>
        </div>
        <div class="row spacing">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="ckbox ckbox-primary">
                        {!! Form::checkbox('is_xray', 1, false,['id'=>'x-ray_check']) !!}
                        <span>X-ray Form</span>
                    </label>
                </div>
            </div>
        </div>
        <hr>
        <div class="clearfix"></div>
        <div class="row spacing">
            <div id="form-not-xray">
                <div id="wrap">
                    <div class="wrapp">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('service','Test:') !!}
                                {!! Form::text('service[]',null,['class'=>'form-control']) !!}
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
                </div>
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
                    {!! Form::checkbox('supplies', 1, false,['id'=>'supplies_check']) !!}
                    <span>Supplies</span>
                </label>
                <!-- <h3 class="panel-title" style="margin-top: 5px;">Supplies</h3> -->
            </div>
        </div>
    </div>
    <div class="panel-body" id="supplies-data">
        <div id="supply-group">
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

        var x = 1;
        $('#bot').on('click',function(){
        x++;
        var data =  '<div class="clearfix"></div><div class="wrapp'+x+'" style="margin-top:20px;"><div class="clearfix"></div>';
            data += '<div class="col-md-3"><div class="form-group">';
            data += '<input type="text" name="service[]" class="form-control" /> ';
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

    $('#x-ray_check').click(function() {
        if($(this).is(':checked')) {
            $('#form-not-xray').hide('slow');
        } else {
            $('#form-not-xray').show('slow');
        }
    });

    $('#supplies-data').hide();
    $('#supplies_check').click(function() {
        if($(this).is(':checked')) {
            $('#supplies-data').show('slow');
        } else {
            $('#supplies-data').hide('slow');
        }
    });


</script>
@endsection