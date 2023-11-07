@extends('layouts.layout')
@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Orders</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">DevaSmriti</a></li>
                            <li class="breadcrumb-item active">Orders</li>
                        </ol>
                    </div>
                </div>
				<div class="col-sm-6" >
					<a class="btn btn-warning float-right" href="/export_order">Export</a>
				</div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- <h4 class="card-title">Admin Members</h4>
                                        <p class="card-title-desc">Here are the admin members. Here you can edit or add an admin member</p> -->
							<!-- Booking id, booked by, booked seva, created date, price , status, address. User detalils, payment details -->
							
                            <table id="orders_table" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
										<th>Booking Id</th>
                                        <th>Booked By</th>
                                        <th>Shipping</th>
                                        <th>Billing</th>
										<th>Pay Status</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach ($order as $res)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ 'DS-'.str_pad($res->id, 4, "0", STR_PAD_LEFT)}}</td>
										<td>{{ $res->user->fname}} {{$res->user->mobile_number}}</td>
                                        <td><b>{{ $res->user_address->address_name}}</b> 
										<br/><span class="fa fa-user"> {{$res->user_address->fname}} {{$res->user_address->lname }}</span> 
										<br/><span class="fa fa-phone"> {{$res->user_address->whatsup_no }}</span>
										</td>
                                        <td><b>{{ $res->user_billing->address_name}}</b> 
										<br/><span class="fa fa-user"> {{$res->user_billing->fname}} {{$res->user_billing->lname }}</span> 
										<br/><span class="fa fa-phone"> {{$res->user_billing->whatsup_no }}</span>
										</td>
										<td>{{$res->payment_status}}</td>
                                        <td>@if($res->is_active=='1')
                                            <button class="btn btn-success btn-sm waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'0');">
                                                Active</button>
                                            @elseif($res->is_active=='2')
                                            <button class="btn btn-success btn-sm waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'1');">
                                                Not Verified</button>
                                            @else
                                            <button class="btn btn-danger btn-sm waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'1');">
                                                Inactive</button>
                                            @endif

                                        </td>
                                        <td align="center">
											<a href="edit_user/{{ $res->id }}" class="btn btn-primary btn-sm waves-effect waves-light" href="#">
												<i class="ti-pencil mr-2"></i>Edit
											</a>
											
											<a href="#myModal" data-toggle="modal" class="btn btn-info btn-sm waves-effect waves-light" data-target="#myModal" data-order="{{$res->id}}">
												Sevas
											</a>
											<div style="display:none;" id="modal_table{{$res->id}}">
												<table class="table table-striped">
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
											</div>
										</td>
                                    </tr>
                                    <?php $i++ ?>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
	
	<div class="modal fade" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
          </div>

        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<script>
function change_status(id, status) {
	var Type = 'User';
	Swal.fire({
		text: "Are you sure want to change the status?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.isConfirmed) {
			window.location = "{{ url('/change_admin_status')}}" + '/' +
				id + '/' + status + '/' + Type + '/';
		}
	});
}
</script>
@endsection

@section('endscript')
<script type="text/javascript">	
$(document).ready(function () {
	var table = $('#orders_table').DataTable();

	$("#myModal").on('show.bs.modal', function (e) {

    var triggerLink = $(e.relatedTarget);
    var id = triggerLink.data("order");

    var data = table.rows( triggerLink.closest('tr') ).data();
    $('.modal-body').html($('#modal_table'+id).html());
    
	});
});
</script>
@endsection