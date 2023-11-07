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
                        <h4 class="font-size-18">Add Temple</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">DevaSmriti</a></li>
                            <li class="breadcrumb-item"><a href="user_management">Temple</a></li>
                            <li class="breadcrumb-item active">Add Temple</li>
                        </ol>
                    </div>
                </div>
				<div class="col-sm-6">
                    <div class="float-right">
                        <a href="temple" class="btn btn-primary waves-effect waves-light">
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
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
                <div class="col-12">
                    <div class="card">
						<form action="/save_temple" enctype="multipart/form-data" method="post">
							{{ csrf_field() }}
							<div class="card-body">
								<div class="row">
									<div class="form-group col-lg-2">
										<label for="fname">Name</label>
										<input type="text" id="name" name="name" class="form-control @error('nname') is-invalid @enderror"
											placeholder="Enter Temple Name" value="{{ old('name') }}"/>
										@error('name')
											<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									</div>
									<div class="form-group col-lg-2">
										<label for="code">Code</label>
										<input type="text" id="code" name="code" class="form-control"
											placeholder="Enter Code" />
									</div>
									
									<div class="form-group col-lg-2">
										<label for="country">Country</label>
										<select name="country" class="form-control country"/>
											@foreach ($country as $id=>$name)
												<option value="{{ $id }}">{{ $name }}</option>
											@endforeach
										</select>
										
									</div>
									<div class="form-group col-lg-2">
										<label for="state">State</label>
										<select name="state" class="form-control state"/>
											@foreach ($state as $id=>$name)
												<option value="{{ $id }}">{{ $name }}</option>
											@endforeach
										</select>
										
									</div>
									<div class="form-group col-lg-2">
										<label for="city">City</label>
										<select name="city" class="form-control city"/>
										<option>--</option>
											<?php /* @foreach ($state as $res)
												<option value="{{ $res->id }}">{{ $res->name }}</option>
											@endforeach */ ?>
										</select>
										
									</div>
									<div class="form-group col-lg-2">
										<label for="pincode">Pincode</label>
										<input type="text" name="pincode" class="form-control pincode" placeholder="Enter Pincode"  value="{{ old('pincode') }}" />
									</div>
									<div class="form-group col-lg-4">
										<label for="latitude">Latitude</label>
										<input type="text" name="latitude" id="latitude"
											class="form-control" placeholder="Enter Latitude" />
										@error('latitude')
											<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									</div>
									<div class="form-group col-lg-4">
										<label for="longitude">Longitude</label>
										<input type="text" name="longitude" id="longitude"
											class="form-control" placeholder="Enter Longitude" />
										@error('longitude')
											<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									</div>
									<div class="form-group col-md-4">
										<label for="image">Featured Image</label>
										<input type="file" name="image" class="form-control">
									</div>
									<div class="form-group col-lg-4">
										<label for="about_me">About Me</label>
										<textarea name="about_me" id="about_me"
											class="form-control" placeholder="Enter About Me">{{ old('about_me') }}</textarea>
									</div>
									<div class="form-group col-lg-4">
										<label for="address_1">Address 1</label>
										<textarea name="address" class="form-control address" placeholder="Enter Address">{{ old('address') }}</textarea>
										
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