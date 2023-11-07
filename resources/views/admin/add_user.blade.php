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
				<!--@if ($errors->any())
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
				@endif -->
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


@endsection



@section('endscript')
<script type="text/javascript">
	$(document).ready(function(){	  
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