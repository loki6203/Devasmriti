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
                        <h4 class="font-size-18">User Address</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">DevaSmriti</a></li>
                            <li class="breadcrumb-item active">User Address</li>
                        </ol>
                    </div>
                </div>
				<div class="col-sm-6">
                    <div class="float-right">
                        <a href="user_management" class="btn btn-primary waves-effect waves-light">
                            <i class="mdi mdi-arrow-left mr-2"></i> Back
                        </a>
						
                    </div>
                </div>
            </div>
            <!-- end page title -->
			
			<div class="card">
			<form action="/save_address/{{$user_id}}" method="post">
				{{ csrf_field() }}
				<input type="hidden" id="id" name="id" value="{{isset($usersingleaddress->id)?$usersingleaddress->id:''}}"/>
				<div class="card-body">
					<div class="row">
						<div class="form-group col-lg-2">
							<label for="address_name">Name</label>
							<input type="text" name="address_name" class="form-control address_name" placeholder="Enter Address Name"  value="{{ isset($usersingleaddress->address_name)?$usersingleaddress->address_name:''}}"/>
							@error('address_name')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-lg-2">
							<label for="whatsup_no">Whatsup No</label>
							<input type="text" name="whatsup_no" class="form-control whatsup_no" placeholder="Enter Mobile No"  value="{{ isset($usersingleaddress->whatsup_no)?$usersingleaddress->whatsup_no:''}}"/>
							@error('whatsup_no')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-lg-2">
							<label for="pincode">Pincode</label>
							<input type="text" name="pincode" class="form-control pincode" placeholder="Enter Pincode"  value="{{isset($usersingleaddress->pincode)?$usersingleaddress->pincode:''}}" />
							@error('address_name')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-lg-2">
							<label for="country">Country</label>
							<select name="country" class="form-control country"/>
								<option value="">Select Country</option>
								@foreach ($country as $res) 
									<option value="{{ $res->id }}" {{ isset($usersingleaddress->country_id) && $res->id == $usersingleaddress->country_id ? 'selected' : '' }}>{{ $res->name }}</option>
								@endforeach
							</select>
							@error('country')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-lg-2">
							<label for="state">State</label>
							<select name="state" class="form-control state"/>
								<option value="">Select State</option>
								@foreach ($state as $res)
									<option value="{{ $res->id }}" {{ isset($usersingleaddress->state_id) && $res->id == $usersingleaddress->state_id ? 'selected' : '' }}>{{ $res->name }}</option>
								@endforeach
							</select>
							@error('state')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-lg-2">
							<label for="city">City</label>
							<select name="city" class="form-control city"/>
							@if(isset($usersingleaddress->city_id) && $usersingleaddress->city_id!='')
								<option value="{{$usersingleaddress->city_id}}" selected>{{$usersingleaddress->city->name}}</option>
							@else
								<option value="">--</option>
							@endif	
							</select>
							@error('city')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="form-group col-lg-6">
							<label for="address_1">Address 1</label>
							<textarea name="address_1" class="form-control address_1" placeholder="Enter Address 1">{{ isset($usersingleaddress->address_1)?$usersingleaddress->address_1:''}}</textarea>
							@error('address_1')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-lg-6">
							<label for="address_2">Address 2</label>
							<textarea name="address_2" class="form-control address_2" placeholder="Enter Address 2">{{ isset($usersingleaddress->address_2)?$usersingleaddress->address_2:''}}</textarea>
						</div>
					</div>
					<div class="form-group">
						<button class="btn btn-primary" style="float:right;" type="submit">Submit</button>
					</div>
				</div>
			</div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- <h4 class="card-title">Admin Members</h4>
                                        <p class="card-title-desc">Here are the admin members. Here you can edit or add an admin member</p> -->

                            <table id="tableID" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
										<th>Address</th>
                                        <th>Name</th>
										<th>Whatsup</th>
                                        <th>Country</th>
                                        <th>State</th>
										<th>City</th>
										<th>Pincode</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach ($useraddress as $res)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $res->address_name }}</td>
                                        <td>{{ $res->fname.' '.$res->lname }}</td>
                                        <td>{{ $res->whatsup_no }}</td>
										<td>{{ $res->country->name }}</td>
										<td>{{ $res->state->name }}</td>
										<td>{{ $res->city->name }}</td>
										<td>{{ $res->pincode }}</td>
										<td>@if($res->is_active=='active')
                                            <button type="button" class="btn btn-success  waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'0', {{$res->user_id}});">
                                                Active</button>
                                            @else
                                            <button type="button" class="btn btn-danger  waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'1', {{$res->user_id}});">
                                                Inactive</button>
                                            @endif
										</td>
										<td align="center">
											<a href="{{url('/')}}/user_address/{{ $res->user_id }}/{{ $res->id }}"
                                                class="btn btn-primary  waves-effect waves-light" href="#"><i
                                                    class="ti-pencil mr-2"></i>Edit</a>
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
    
<script type="text/javascript">
function change_status(id, status, user_id) {
	Swal.fire({
		text: "Are you sure want to change the status?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.isConfirmed) {
			window.location = "{{ url('/change_address_status')}}" + '/' +
				id + '/' + status + '/' + user_id;
		}
	});
}
</script>
@endsection
	
	
@section('endscript')
<script type="text/javascript">
	$(document).ready(function(){	  
		$(document).on('change', '.state', function (e) {
			THIS = $(this);
			var idState = this.value; //alert("{{url('api/city')}}?state_id="+idState);
			$('.city').html('');
			$.ajax({
				url: "{{url('api/city')}}?state_id="+idState,
				type: "GET",
				data: {
					_token: '{{csrf_token()}}'
				},
				contentType: "application/json",
				dataType: 'json',
				success: function (res) { //console.log(res.data); return false;
					$('.city').html('<option value="">-- Select City --</option>');
					$.each(res.data.data, function (key, value) { //console.log(value);
						$('.city').append('<option value="' + value.id + '">' + value.name + '</option>');
					});
				}
			});
		});	
	});
</script>
@endsection