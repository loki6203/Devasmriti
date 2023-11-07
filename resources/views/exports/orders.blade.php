<table id="orders_table">
	<thead>
		<tr>
			<th>Sno</th>
			<th>Booking Id</th>
			<th>UserName</th>
			<th>Mobile</th>
			<th>Mail</th>
			<th>Trans.No</th>
			<th>Name</th>
			<th>Relation</th>
			<th>DOB</th>
			<th>Gothram</th>
			<th>Raasi</th>
			<th>Nakshatram</th>
			<th>Address 1</th>
			<th>Address 2</th>
			<th>State</th>
			<th>City</th>
			<th>Pincode</th>
			<th>Address Name</th>
			<th>Booking Date</th>
		</tr>
	</thead>

	<tbody>
		<?php $i=1;?>
		@foreach ($order_sevas as $res)
		<?php 
		$user = $res['Order']['user'];
		$user_family = $res['userFamilyDetail'];
		$user_address = $res['Order']['user_address'];
		?>
		<tr>
			<td>{{ $i }}</td>
			<td>{{ 'DS-'.str_pad($res->order_id, 4, "0", STR_PAD_LEFT)}}</td>
			<td>{{$user['fname']}} {{$user['lname']}}</td>
			<td>{{$user['mobile_number']}}</td>
			<td>{{$user['email']}}</td>
			<td>{{$res->transaction_id}}</td>
			<td>{{$user_family->full_name}}</td>
			<td>{{$user_family->relation->name}}</td>
			<td>{{date('d M Y', strtotime($user_family->dob))}}</td>
			<td>{{$user_family->gothram}}</td>
			<td>{{$user_family->rasi->name}}</td>
			<td>{{$user_family->nakshatram}}</td>
			<td>{{$user_address->address_1}}</td>
			<td>{{$user_address->address_2}}</td>
			<td>{{$user_address->State['name']}}</td>
			<td>{{$user_address->City['name']}}</td>
			<td>{{$user_address->pincode}}</td>
			<td>{{$user_address->address_name}}</td>
			<td>{{date('d M Y', strtotime($res->created_at))}}</td>
		</tr>
		<?php $i++ ?>
		@endforeach
	</tbody>
</table>