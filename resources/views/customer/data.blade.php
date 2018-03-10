@foreach ( $customer as $data )
	<tr>
		<td class="text-center">{{ $data->barcode }}</td>
		<td>{{ $data->fullName }}</td>
		<td>{{ $data->address }}</td>
		<td>{{ $data->CurrentAgency->name }}</td>
		<td>{{ $data->country()->orderBy('created_at','desc')->first()->name }}</td>
		<td class="text-center" width="80" style="text-transform: uppercase;">
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-cog"></span></button>
            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ action('CustomerController@show', $data->id) }}">View Profile</a></li>
            </ul>
        </div>
    </td>
	</tr>
@endforeach