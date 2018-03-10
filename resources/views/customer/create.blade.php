@extends('template')

@section('content')
{!! Form::open(['action' => 'CustomerController@store']) !!}
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-6">
                <h3 class="panel-title" style="margin-top: 5px;">Create Customer</h3>
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
                    {!! Form::text('birthdate',null,['class'=>'form-control dt date'])!!}
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
                    {!! Form::select('agency',$agency,null,['class'=>'form-control select', 'id' => 'agency_id' ,'placeholder'=>'PLEASE SELECT'])!!}
                </div>
            </div>
            <div class="col-md-3" id="package">
                <div class="form-group">
                    {!! Form::label('package','Package') !!}
                    {!! Form::select('package_id',$package,null,['class'=>'form-control select', 'id'=>'package_id','placeholder'=>'PLEASE SELECT'])!!}
                </div>
            </div>
            <div class="col-md-3" id="country">
                <div class="form-group">
                    {!! Form::label('country','Country') !!}
                    {!! Form::select('country',$country,null,['class'=>'form-control select','id' => 'country_id','placeholder'=>'PLEASE SELECT'])!!}
                </div>
            </div>
            <div class="col-md-3" id="price-tag">
                <div class="form-group">
                    {!! Form::label('price','Price') !!}
                    {!! Form::select('price',[],null,['class'=>'form-control select','id'=>'price','placeholder'=>'PLEASE SELECT'])!!}
                </div>
            </div>
        </div>
        <div class="row spacing">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('remarks','Remarks') !!}
                    {!! Form::textarea('remarks',null,['class'=>'form-control','rows'=>'3'])!!}
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
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#package').hide();
    $('#country').hide();
    $('#price-tag').hide();

    $('#agency_id').change(function() {
        var agency_id = $(this).val(); 
        var package_id = $('#package_id').val(); 
        var country_id = $('#country_id').val(); 
        $("#price").html("");
        var token = $("input[name='_token']").val();
        $.ajax({    //create an ajax request to load_page.php
            type: 'post',
            url: "{{ action('CustomerController@loadData') }}",//php file url diri     
            data: { agency_id : agency_id, package_id : package_id, _token:token, country_id:country_id },
            success: function(response){
               $.each(response,function(index,value){
                    $("#price").append('<option value="'+value.price+'">'+value.name+'</option>');
               });
               
            }
        });
        $('#package').show( "drop", 1000 );
    });

    $('#package_id').change(function() {
        var package_id = $(this).val(); 
        var agency_id = $('#agency_id').val(); 
        var country_id = $('#country_id').val();
        $("#price").html("");
        var token = $("input[name='_token']").val();
        $.ajax({    //create an ajax request to load_page.php
            type: 'post',
            url: "{{ action('CustomerController@loadData') }}",//php file url diri     
            data: { agency_id : agency_id, package_id : package_id, _token:token, country_id:country_id },
            success: function(response){
               $.each(response,function(index,value){
                    $("#price").append('<option value="'+value.price+'">'+value.name+'</option>');
               });
               
            }
        });
        $('#country').show( "drop", 1000 );
    });

    $('#country_id').change(function() {
        var country_id = $(this).val(); 
        var agency_id = $('#agency_id').val(); 
        var package_id = $('#package_id').val();
        $("#price").html("");
        var token = $("input[name='_token']").val();
        $.ajax({    //create an ajax request to load_page.php
            type: 'post',
            url: "{{ action('CustomerController@loadData') }}",//php file url diri     
            data: { agency_id : agency_id, package_id : package_id, _token:token, country_id:country_id },
            success: function(response){
               $.each(response,function(index,value){
                    $("#price").append('<option value="'+value.price+'">'+value.name+'</option>');
               });
               
            }
        });
        $('#price-tag').show( "drop", 1000 );
    });

</script>
@endsection
