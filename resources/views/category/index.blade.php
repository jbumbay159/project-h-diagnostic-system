@extends('template')

@section('content')
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-6">
				<h3 class="panel-title" style="margin-top: 5px;">Categories Module</h3>
			</div>
			<div class="col-md-6">
				<div class="clearfix">
					<a href="{{ action('CategoryController@create') }}" class="btn btn-default btn-sm btn-quirk pull-right"><span class="glyphicon glyphicon-plus"></span> Create Entry</a>
				</div>
			</div>		
		</div>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
            <table id="dataTable1" class="table table-bordered table-striped-col" style="text-transform: uppercase;">
            	<thead>
            		<tr>
            			<th class="text-center">Name</th>
            			<th  width="80" class="text-center">Action</th>
            		</tr>
            	</thead>
                <tbody>
                    @foreach ( $category as $list )
                        <tr>
                            <td class="">{{ $list->name }}</td>
                            <td class="text-center" width="80">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-cog"></span></button>
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ action('CategoryController@edit', $list->id) }}">Edit</a></li>
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
@endsection