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
                        <h4 class="font-size-18">Edit Temple</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">DevaSmriti</a></li>
                            <li class="breadcrumb-item"><a href="admin_management">Admin Management</a></li>
                            <li class="breadcrumb-item active">Edit Temple</li>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- <h4 class="card-title">Example</h4> -->
                            <form action="/update_temple/{{ $temple[0]['id'] }}" class=" repeater"
                                enctype="multipart/form-data" method="post">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
								<div class="row">
									<div class="form-group col-lg-2">
										<label for="fname">Name</label>
										<input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
											placeholder="Enter Temple Name" value="{{ $temple[0]['name'] }}"/>
										@error('name')
											<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									</div>
									<div class="form-group col-lg-2">
										<label for="code">Code</label>
										<input type="text" id="code" name="code" class="form-control"
											placeholder="Enter Code" value="{{$temple[0]['code']}}"/>
									</div>
									
									<div class="form-group col-lg-2">
										<label for="country">Country</label>
										<select name="country" class="form-control country"/>
											@foreach ($country as $id=>$name) 
												<option value="{{ $id }}" {{ $id == $temple[0]['country_id'] ? 'selected' : '' }}>{{ $name }}</option>
											@endforeach
										</select>
										
									</div>
									<div class="form-group col-lg-2">
										<label for="state">State</label>
										<select name="state" class="form-control state"/>
											@foreach ($state as $id=>$name)
												<option value="{{ $id }}" {{ $id == $temple[0]['state_id'] ? 'selected' : '' }}>{{ $name }}</option>
											@endforeach
										</select>
										
									</div>
									<div class="form-group col-lg-2">
										<label for="city">City</label>
										<select name="city" class="form-control city"/>
										@if($temple[0]['city_id'])
											<option value="{{$temple[0]['city_id']}}" selected>{{$temple[0]['city_name']}}</option>
										@else
											<option>--</option>
										@endif	
										</select>
										
									</div>
									<div class="form-group col-lg-2">
										<label for="pincode">Pincode</label>
										<input type="text" name="pincode" class="form-control pincode" placeholder="Enter Pincode"  value="{{$temple[0]['pincode']}}" />
									</div>
									<div class="form-group col-lg-4">
										<label for="latitude">Latitude</label>
										<input type="text" name="latitude" id="latitude"
											class="form-control" placeholder="Enter Latitude" value="{{$temple[0]['latitude']}}"/>
										@error('latitude')
											<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									</div>
									<div class="form-group col-lg-4">
										<label for="longitude">Longitude</label>
										<input type="text" name="longitude" id="longitude"
											class="form-control" placeholder="Enter Longitude" value="{{$temple[0]['longitude']}}"/>
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
											class="form-control" placeholder="Enter About Me">{{$temple[0]['about']}}</textarea>
									</div>
									<div class="form-group col-lg-4">
										<label for="address_1">Address 1</label>
										<textarea name="address" class="form-control address" placeholder="Enter Address">{{$temple[0]['address']}}</textarea>
										
									</div>
								</div>
								
								
                                    
								
									
									
									
                                <div class="submit_cnt">
                                    <button class="btn btn-primary waves-effect waves-light"
                                        type="submit">Submit</button>
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