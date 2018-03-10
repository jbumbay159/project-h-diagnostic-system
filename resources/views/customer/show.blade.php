@extends('template')

@section('content')

<div class="row profile-wrapper">
    <div class="col-xs-12 col-md-3 col-lg-2 profile-left">
        <div class="profile-left-heading">
            <ul class="panel-options">
                <li><a class=" dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-option-vertical"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ action('CustomerController@edit', $info->id) }}">Edit Profile</a></li>
                    </ul>
                </li>
            </ul>
            <a href="#photo-modal" data-toggle="modal" class="profile-photo">
                <img class="img-circle img-responsive" src="{{ $info->photos }}" alt="" style="height: 120px;width: 120px;">
            </a>
            <h2 class="profile-name">{{ $info->last_name.', '.$info->first_name.' '.$info->middle_name.' '.$info->name_extension }}</h2>
            <h4 class="profile-designation"></h4>
            <ul class="list-group">
                <li class="list-group-item">Agencies <a href="#">{{ $info->agency()->count() }}</a></li>
                <li class="list-group-item">Balance <a href="#balance" data-toggle="modal">{{ number_format($grandTotal, 2, ".", ",") }}</a></li>
            </ul>
            <a  href="#menu" data-toggle="modal" class="btn btn-danger btn-quirk btn-block ">Main Menu</a>
        </div>
            <div class="profile-left-body">
              <h4 class="panel-title">Remarks</h4>
              <p>{{ $info->remarks }}</p>

              <hr class="fadeout">

              <h4 class="panel-title">Location</h4>
              <p><i class="glyphicon glyphicon-map-marker mr5"></i> {{ $info->address }}</p>

              <hr class="fadeout">

              <h4 class="panel-title">Current Agency</h4>
              <p><i class="glyphicon glyphicon-briefcase mr5"></i> {{ $info->agency()->orderBy('pivot_created_at','desc')->first()->name }}</p>

              <hr class="fadeout">

              <h4 class="panel-title">Contacts</h4>
              <p><i class="glyphicon glyphicon-phone mr5"></i> {{ $info->contact_number }}</p>
              {!! Form::hidden('current_agency', $info->agency()->orderBy('pivot_created_at','desc')->first()->id, ['id'=>'new_agency']) !!}
              {!! Form::hidden('current_country', $info->country()->orderBy('pivot_created_at','desc')->first()->id, ['id'=>'new_country']) !!}
            </div>
          </div>
          <div class="col-md-9 col-lg-10 profile-right">
            <div class="profile-right-body">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs nav-justified nav-line">
                <li class="active"><a href="#details" data-toggle="tab"><strong>Customer Detail</strong></a></li>
                <li><a href="#lab-result" data-toggle="tab"><strong>Laboratory Result</strong></a></li>
                <li><a href="#transmittal" data-toggle="tab"><strong>Transmittal</strong></a></li>
                <li><a href="#transaction" data-toggle="tab"><strong>Transaction History</strong></a></li>
                
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane" id="transaction">
                    
                </div>


                <div class="tab-pane" id="lab-result">
                
                    @if( $count == 0  )
                        <a href="#retake" data-toggle="modal" style="margin-bottom: 20px;" class="btn btn-primary btn-quirk"><i class="fa fa-pencil-square-o"></i> Retake Service</a>
                    @endif
                
                    <table class="table table-bordered" style="text-transform: uppercase;">
                        <thead>
                            <th style="text-align:center;" width="150px;">Date</th>
                            <th style="text-align:center;">Services</th>
                            <th style="text-align:center;">Remarks</th>
                        </thead>
                      <tbody>
                      @foreach ( $info->labResults as  $labData)
                        <tr>
                            <td>{{ $labData->CreatedDate }}</td>
                            <td>{{ $labData->name }}</td>
                            <td>{{ $labData->remarks }}</td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>

                </div><!-- tab-pane -->

                <div class="tab-pane  active" id="details">
                    <table class="table">
                        <thead>
                            <th colspan="2">Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td>{{ $info->barcode }}</td>
                            </tr>
                            <tr>
                                <td><strong>Name:</strong></td><td>{{ $info->last_name.', '.$info->first_name.' '.$info->middle_name.' '.$info->name_extension }}</td>
                            </tr>
                            <tr>
                                <td><strong>Gender:</strong></td><td>{{ $info->gender }}</td>
                            </tr>
                            <tr>
                                <td><strong>Birthdate:</strong></td><td>{{ \Carbon\Carbon::parse($info->birthdate)->toFormattedDateString() }}</td>
                            </tr>
                            <tr>
                                <td><strong>Address:</strong></td><td>{{ $info->address }}</td>
                            </tr>
                            <tr>
                                <td><strong>Contact No:</strong></td><td>{{ $info->contact_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Agency:</strong></td><td>{{ $info->agency()->orderBy('pivot_created_at','desc')->first()->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Destination:</strong></td><td>{{ $info->country()->orderBy('pivot_created_at','desc')->first()->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Remarks:</strong></td><td>{{ $info->remarks }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table class="table table-bordered">
                        <thead>
                            <th colspan="2">Agency</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;font-weight: bold;">Date</td>
                                <td style="text-align: center;font-weight: bold;">Name</td>
                                
                            </tr>
                            @foreach ( $info->agency()->orderBy('pivot_created_at', 'desc')->get() as $agency )
                            <tr>
                                <td style="text-align: center;">{{ \Carbon\Carbon::parse($agency->pivot->created_at)->toFormattedDateString() }}</td>
                                <td style="text-align: center;">{{ $agency->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <table class="table table-bordered">
                        <thead>
                            <th colspan="3">Country</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;font-weight: bold;">Date</td>
                                <td style="text-align: center;font-weight: bold;">Name</td>
                                <td style="text-align: center;font-weight: bold;">Association</td>
                            </tr>
                            @foreach ( $info->country()->orderBy('pivot_created_at', 'desc')->get() as $country )
                            <tr>
                                <td style="text-align: center;">{{ \Carbon\Carbon::parse($country->pivot->created_at)->toFormattedDateString() }}</td>
                                <td style="text-align: center;">{{ $country->name }}</td>
                                <td style="text-align: center;">{{ $country->association->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
                
                
                <div class="tab-pane" id="transmittal">
                    <table class="table table-bordered">
                        <thead>
                            <th class="text-center" width="100px">Date</th>
                            <th class="text-center" width="150px">Status</th>
                            <th class="text-center">Remarks</th>
                        </thead>
                        <tbody>
                            @foreach ( $info->transmittal as $trans)
                                <tr>
                                    <td class="text-center">{{ $trans->encode_date }}</td>
                                    <td class="text-center">{{ $trans->status }}</td>
                                    <td>{{ $trans->remarks }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                
                
                
              </div>
            </div>
          </div>
        </div><!-- row -->

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="menu" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Main Menu</h4>
            </div>
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <p style="color:red;">Date Expiration: 
                            @if( $latestSale != NULL )
                                {{ \Carbon\Carbon::parse($latestSale->created_at)->addDays($latestSale->days)->toFormattedDateString() }} 
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row spacing">
                    <div class="col-md-6">
                        <a  href="#add-package" data-toggle="modal" class="btn btn-primary btn-quirk btn-block ">New Package</a>
                    </div>
                    <div class="col-md-6">
                        <a  href="#upgrade-package" data-toggle="modal" class="btn btn-primary btn-quirk btn-block {{ $status }}">Upgrade Package</a>
                    </div>
                </div>  
                <div class="row spacing">
                    <div class="col-md-6">
                        <a  href="#add-service" data-toggle="modal" class="btn btn-primary btn-quirk btn-block ">Add Services</a>
                    </div>
                    <div class="col-md-6">
                        <a  href="#balance" data-toggle="modal" class="btn btn-primary btn-quirk btn-block ">Payment</a>
                    </div>
                </div> 
                <div class="row spacing">
                    <div class="col-md-6">
                        <a  href="{{ action('CustomerController@edit', $info->id) }}" class="btn btn-primary btn-quirk btn-block ">Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal animated" tabindex="-1" role="dialog" id="add-service" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Add Services</h4>
            </div>
            {!! Form::model($info, ['method'=>'patch', 'action' => ['CustomerController@addService', $info->id]]) !!}
                <div class="modal-body">    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('service','Select Services') !!}
                                {!! Form::select('service[]',$serviceList,null,['class'=>'form-control select','multiple']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                                {!! Form::submit('ADD SERVICE', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal animated" tabindex="-1" role="dialog" id="upgrade-package" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Upgrade Package</h4>
            </div>
            {!! Form::model($info, ['method'=>'patch', 'action' => ['CustomerController@upgradePackage', $info->id]]) !!}
                <div class="modal-body">    
                    <div class="row">
                        <div class="col-md-12">
                            <p style="color:red;">Package Expiration: 
                                @if( $latestSale != NULL)
                                    {{ \Carbon\Carbon::parse($latestSale->created_at)->addDays($latestSale->days)->toFormattedDateString() }} 
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('package','Upgrade to') !!}
                                {!! Form::select('package',$package,null,['class'=>'form-control select-limit-one','multiple',$status]) !!}
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                            {!! Form::submit('UPGRADE PACKAGE', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>



<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="retake" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Retake Service</h4>
            </div>
            {!! Form::model($info, ['method'=>'patch', 'action' => ['CustomerController@updateRetake', $info->id]]) !!}
                <div class="modal-body">    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('service','Select Services') !!}
                                {!! Form::select('service[]',$service,null,['class'=>'form-control select','multiple']) !!}
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">CLOSE</button>
                                {!! Form::submit('UPDATE ENTRY', ['class'=>'btn btn-lg btn-primary','style'=>'margin-top:0px;']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="add-package" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Add Package</h4>
            </div>
            {!! Form::model($info, ['method'=>'patch', 'action' => ['CustomerController@newPackage', $info->id]]) !!}
                <div class="modal-body">    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('package','Package') !!}
                                {!! Form::select('package_id',$package,null,['id'=>'new_package','class'=>'form-control select','placeholder'=>'Please Select']) !!}
                            </div>
                        </div>
                    </div>  
                    <div class="row spacing">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('Price','Price') !!}
                                {!! Form::select('price',[],null,['id'=>'new_price','class'=>'form-control select']) !!}
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                                {!! Form::submit('ADD PACKAGE', ['class'=>'btn btn-primary','style'=>'margin-top:0px;']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="balance" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Balance</h4>
            </div>
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Price</th>
                                <th style="text-align: center;" width="100px;">Action</th>
                            </thead>
                            <tbody>
                                @if( count($balance) > 0 )
                                  @foreach ( $balance as $bal )
                                  <tr>
                                      <td>{{ $bal->name }}</td>
                                      <td>{{ $bal->total_price }}</td>
                                      <td style="text-align: center;"><a target="_blank" href="{{ url('customer/'.$info->id.'/sale-invoice?saleID='.$bal->id) }}" class="btn btn-link" style="padding: 0px;">Print</a></td>
                                  </tr>
                                  @endforeach
                                @else
                                  <tr>
                                      <td colspan="2">No Balance</td>
                                  </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal bounceIn animated" tabindex="-1" role="dialog" id="photo-modal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        {!! Form::model($info, ['method'=>'patch', 'action' => ['CustomerController@uploadPhoto', $info->id],'files'=>'true']) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myLargeModalLabel">Customer Photo</h4>
            </div>
            <div class="modal-body">    
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <img class="img-circle img-responsive" src="{{ $info->photos }}" alt="" style="height: 120px;width: 120px;">
                        </center>
                    </div>
                </div>
                <div class="row spacing">
                    <div class="col-md-12">
                        {!! Form::label('photo','Photo') !!}
                        {!! Form::file('photo', ['class' => 'form-control image-form']) !!}
                    </div>    
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">CLOSE</button>
                        {!! Form::submit('UPDATE ENTRY', ['class'=>'btn btn-sm btn-primary','style'=>'margin-top:0px;']) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#new_package').change(function() {
        var package_id = $(this).val(); 
        var agency_id = $('#new_agency').val(); 
        var country_id = $('#new_country').val(); 
        $("#new_price").html("");
        var token = $("input[name='_token']").val();
        $.ajax({    //create an ajax request to load_page.php
            type: 'post',
            url: "{{ action('CustomerController@loadData') }}",//php file url diri     
            data: { agency_id : agency_id, package_id : package_id, _token:token, country_id:country_id },
            success: function(response){
               $.each(response,function(index,value){
                    $("#new_price").append('<option value="'+value.price+'">'+value.name+'</option>');
               });
               
            }
        });
    });
</script>
@endsection