@extends('layouts.layout')
@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<style>
.is-invalid {
	border:1px solid #fbdadf;
}
</style>
<div class="main-content">
	<div class="page-content">
        <div class="container-fluid">
			<!-- start page title -->
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Add User</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">DevaSmriti</a></li>
                            <li class="breadcrumb-item"><a href="user_management">User Management</a></li>
                            <li class="breadcrumb-item active">Add User</li>
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
            <div class="row">
				@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $key=>$error)
								@if($key === 'fname')
									@continue
								@endif
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
                <div class="col-12">
                    <div class="card">
						<form action="/save_user" enctype="multipart/form-data" method="post">
							{{ csrf_field() }}
							<div class="card-body">
								<div class="row">
									<div class="form-group col-lg-3">
										<label for="fname">First Name</label>
										<input type="text" id="fname" name="fname" class="form-control @error('fname') is-invalid @enderror"
											placeholder="Enter First Name" value="{{ old('fname') }}"/>
										@error('fname')
											<div class="alert alert-danger">{{ $message }}</div>
										@enderror

									</div>
									<div class="form-group col-lg-3">
										<label for="lname">Last Name</label>
										<input type="text" id="lname" name="lname" class="form-control"
											placeholder="Enter Last Name" />
									</div>

									<div class="form-group col-lg-3">
										<label for="email">Email</label>
										<input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter Email" value="{{ old('lname') }}" />
										@error('email')
											<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									</div>

									<div class="form-group col-lg-3">
										<label for="mobile_number">Phone</label>
										<input type="text" name="mobile_number" id="mobile_number"
											class="form-control" placeholder="Enter Mobile No" />
										@error('mobile_number')
											<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									</div>
									
									<div class="form-group col-lg-3">
										<label for="file">Profile Pic</label>
										<input type="file" name="file" id="file"
											class="form-control" placeholder="Enter Profile Pic" />
									</div>
									<div class="form-group col-lg-3">
										<label for="dob">DOB</label>
										<input type="date" name="dob" id="dob"
											class="form-control" placeholder="Enter Date Of Birth"  value="{{ old('dob') }}"/>
									</div>
									<div class="form-group col-lg-3">
										<label for="about_me">About Me</label>
										<textarea name="about_me" id="about_me"
											class="form-control" placeholder="Enter About Me">{{ old('about_me') }}</textarea>
									</div>
								</div>
								<h5>Address Details</h5>
								<div class="_addr_area">
								<div class="row alert alert-success alert-dismissible fade show _addr_single">
									<div class="form-group col-lg-4">
										<label for="address_name">Name</label>
										<input type="text" name="address_name[]" class="form-control address_name" placeholder="Enter Address Name"  value="{{ old('address_name.0') }}"/>
										
									</div>
									<div class="form-group col-lg-4">
										<label for="whatsup_no">Whatsup No</label>
										<input type="text" name="whatsup_no[]" class="form-control whatsup_no" placeholder="Enter Mobile No"  value="{{ old('whatsup_no.0') }}"/>
									</div>
									<div class="form-group col-lg-4">
										<label for="pincode">Pincode</label>
										<input type="text" name="pincode[]" class="form-control pincode" placeholder="Enter Pincode"  value="{{ old('pincode.0') }}" />
									</div>
									<div class="form-group col-lg-4">
										<label for="country">Country</label>
										<select name="country[]" class="form-control country"/>
											@foreach ($country as $id=>$name)
												<option value="{{ $id }}">{{ $name }}</option>
											@endforeach
										</select>
										
									</div>
									<div class="form-group col-lg-4">
										<label for="state">State</label>
										<select name="state[]" class="form-control state"/>
											@foreach ($state as $id=>$name)
												<option value="{{ $id }}">{{ $name }}</option>
											@endforeach
										</select>
										
									</div>
									<div class="form-group col-lg-4">
										<label for="city">City</label>
										<select name="city[]" class="form-control city"/>
										<option>--</option>
											<?php /* @foreach ($state as $res)
												<option value="{{ $res->id }}">{{ $res->name }}</option>
											@endforeach */ ?>
										</select>
										
									</div>
									
									<div class="form-group col-lg-6">
										<label for="address_1">Address 1</label>
										<textarea name="address_1[]" class="form-control address_1" placeholder="Enter Address 1">{{ old('address_1.0') }}</textarea>
										
									</div>
									<div class="form-group col-lg-6">
										<label for="address_2">Address 2</label>
										<textarea name="address_2[]" class="form-control address_2" placeholder="Enter Address 2">{{ old('address_2.0') }}</textarea>
									</div>
								</div>
								</div>
								<button type="button" name="_addr_add" id="_addr_add" class="btn btn-sm btn-success float-right"><i class="fa fa-plus">&nbsp;</i> Add More</button>
							</div>
							<div class="submit_cnt">
								<button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

		
<div class="d-none _addr_html">
<div class="row alert alert-success alert-dismissible fade show _addr_single" role="alert">
	<button type="button" class="btn btn-xs close btn-danger" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<div class="form-group col-lg-4">
		<label for="address_name">Name</label>
		<input type="text" name="address_name[]" class="form-control address_name" placeholder="Enter Address Name" />
	</div>
	<div class="form-group col-lg-4">
		<label for="whatsup_no">Whatsup No</label>
		<input type="text" name="whatsup_no[]" class="form-control whatsup_no" placeholder="Enter Mobile No" />
	</div>
	<div class="form-group col-lg-4">
		<label for="pincode">Pincode</label>
		<input type="text" name="pincode[]" class="form-control pincode" placeholder="Enter Pincode" />
	</div>
	<div class="form-group col-lg-4">
		<label for="country">Country</label>
		<select name="country[]" class="form-control country"/>
			@foreach ($country as $id=>$name)
				<option value="{{ $id }}">{{ $name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group col-lg-4">
		<label for="state">State</label>
		<select name="state[]" class="form-control state"/>
			@foreach ($state as $id=>$name)
				<option value="{{ $id }}">{{ $name }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group col-lg-4">
		<label for="city">City</label>
		<select name="city[]" class="form-control city"/>
		<option>--</option>
			<?php /* @foreach ($state as $res)
				<option value="{{ $res->id }}">{{ $res->name }}</option>
			@endforeach */ ?>
		</select>
	</div>
	
	<div class="form-group col-lg-6">
		<label for="address_1">Address 1</label>
		<textarea name="address_1[]" class="form-control address_1" placeholder="Enter Address 1"></textarea>
	</div>
	<div class="form-group col-lg-6">
		<label for="address_2">Address 2</label>
		<textarea name="address_2[]" class="form-control address_2" placeholder="Enter Address 2"></textarea>
	</div>
</div>
</div>
@endsection



@section('endscript')
<script type="text/javascript">
	$(document).ready(function(){      
		var i=1;  
		$('#_addr_add').click(function(){
			i++;  
			$('._addr_area').append($('._addr_html').html());  
		});  

		$(document).on('click', '.btn_remove', function(){  
		
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
		}); 
	  
		$(document).on('change', '.state', function (e) {
			THIS = $(this);
			var idState = this.value; //alert("{{url('api/city')}}?state_id="+idState);
			THIS.parents('._addr_single').find('.city').html('');
			$.ajax({
				url: "{{url('api/city')}}?state_id="+idState,
				type: "GET",
				data: {
					_token: '{{csrf_token()}}'
				},
				contentType: "application/json",
				dataType: 'json',
				success: function (res) { //console.log(res.data); return false;
					THIS.parents('._addr_single').find('.city').html('<option value="">-- Select City --</option>');
					$.each(res.data.data, function (key, value) { //console.log(value);
						THIS.parents('._addr_single').find('.city').append('<option value="' + value.id + '">' + value.name + '</option>');
					});
				}
			});
		});
			
	});	
	
</script>
@endsection