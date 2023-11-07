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
				<div class="col-sm-6">
					<a class="btn btn-info" style="float:right;" href="/export_order"><i class="mdi mdi-file-excel"></i>&nbsp;Export</a>
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
                                        <td>
											<?php if(isset($user_family['full_name'])){?> 
												{{$user_family->full_name}} 
											<?php } ?>
										</td>
										<td>
											<?php if(isset($user_family['relation'])){?> 
											{{$user_family->relation->name}}
											<?php } ?>
										</td>
										<td>
										<?php if(isset($user_family['dob'])){?> 
											{{date('d M Y', strtotime($user_family->dob))}}
											<?php } ?>
										</td>
										<td>
											<?php if(isset($user_family['gothram'])){?> 
											{{$user_family->gothram}}
											<?php } ?>
											</td>
										<td>
										<?php if(isset($user_family['nakshatram'])){?> 
											{{$user_family->nakshatram}}
											<?php } ?>
											</td>
										<td>
											<?php if(isset($user_family['rasi'])){?> 
											{{$user_family->rasi->name}}
											<?php } ?>
											</td>
										<td>
											<?php if(isset($user_family['address_1'])){?> 
											{{$user_address->address_1}}
											<?php
											}
											?>
											</td>
										<td>
										<?php if(isset($user_address['address_2'])){?> 
											{{$user_address->address_2}}
											<?php } ?>
										</td>
										<td>
											<?php if(isset($user_address['State'])){?> 
											{{$user_address->State['name']}}
											<?php } ?>
										</td>
										<td>
											<?php if(isset($user_address['City'])){?> 
											{{$user_address->City['name']}}
											<?php } ?>
										</td>
										<td>
											<?php if(isset($user_address['pincode'])){?> 
											{{$user_address->pincode}}
											<?php } ?>
										</td>
										<td>
											<?php if(isset($user_address['address_name'])){?> 
											{{$user_address->address_name}}
											<?php } ?>
										</td>
										<td>{{date('d M Y', strtotime($res->created_at))}}</td>
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
});
</script>
@endsection