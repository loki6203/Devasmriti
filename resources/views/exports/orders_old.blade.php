<table id="orders_table">
	<thead>
		<tr>
			<th style="background(-color):#ff0;">Sno</th>
			<th>Booking Id</th>
			<th>Booked By</th>
			<th>Shipping</th>
			<th>Billing</th>
			<th>Pay Status</th>
			<th>Status</th>
		</tr>
	</thead>

	<tbody>
		<?php $i=1; ?>
		@foreach ($order as $res)
			<tr>
				<td>{{ $i }}</td>
				<td>{{ 'DS-'.$res->user->id}}</td>
				<td>{{ $res->user->fname}} {{$res->user->mobile_number}}</td>
				<td>{{ $res->user_address->address_name}}
				<br/><span class="fa fa-user"> {{$res->user_address->fname}} {{$res->user_address->lname }}</span> 
				<br/><span class="fa fa-phone"> {{$res->user_address->whatsup_no }}</span>
				</td>
				<td>{{ $res->user_billing->address_name}} 
				<br/><span class="fa fa-user"> {{$res->user_billing->fname}} {{$res->user_billing->lname }}</span> 
				<br/><span class="fa fa-phone"> {{$res->user_billing->whatsup_no }}</span>
				</td>
				<td>{{$res->payment_status}}</td>			
			</tr>
			<?php $i++ ?>
			
			<tr>
				<th></th>
				<th>SNO</th>
				<th>Seva Title</th>
				<th>Base Price</th>
				<th>Selling Price</th>
				<th>Quantity</th>
			</tr>
			@if(isset($order_wise_sevas[$res->id]))
				<?php $j=1; ?>
				@foreach ($order_wise_sevas[$res->id] as $ows) 
					<?php //print_r($order_wise_sevas[$res->id]); exit; ?>
					<tr>
						<td></td>
						<td>{{ $j }}</td>
						<td>{{ $ows['seva_price']['title']}}</td>
						<td>{{ $ows['seva_price']['base_price']}}</td>
						<td>{{ $ows['seva_price']['selling_price']}}</td>
						<td>{{ $ows['qty'] }}</td>
					</tr>
					<?php $j++;?>
				@endforeach
			@else
				<tr>
					<td colspan="6">No sevas found</td>
				</tr>
			@endif
			<tr></tr>
			<!--tr>
				<td colspan="6">
					<table>
						<thead>
							<tr>
								<th>SNO</th>
								<th>Seva Title</th>
								<th>Base Price</th>
								<th>Selling Price</th>
								<th>Quantity</th>
							</tr>
						</thead>
						<tbody>
						@if(isset($order_wise_sevas[$res->id]))
							<?php $j=1; ?>
							@foreach ($order_wise_sevas[$res->id] as $ows) 
								<?php //print_r($order_wise_sevas[$res->id]); exit; ?>
								<tr>
									<td>{{ $j }}</td>
									<td>{{ $ows['seva_price']['title']}}</td>
									<td>{{ $ows['seva_price']['base_price']}}</td>
									<td>{{ $ows['seva_price']['selling_price']}}</td>
									<td>{{ $ows['qty'] }}</td>
									<td>{{ $ows['is_prasadam_available']=='1'?'Yes':'No' }}</td>
								</tr>
								<?php $j++;?>
							@endforeach
						@else
							<tr>
								<td colspan="6">No sevas found</td>
							</tr>
						@endif
						</tbody>
					</table>
				</td>
			</tr-->			
		@endforeach
		
	</tbody>
</table>