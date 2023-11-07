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
                        <h4 class="font-size-18">User Family</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">DevaSmriti</a></li>
                            <li class="breadcrumb-item active">User Family</li>
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
			<form action="/save_family/{{$user_id}}" enctype="multipart/form-data" method="post">
				{{ csrf_field() }}
				<input type="hidden" id="id" name="id" value="{{isset($usersinglefamily->id)?$usersinglefamily->id:''}}"/>
				<div class="card-body">
					<div class="row">
						<div class="form-group col-lg-2">
							<label for="family_type">Family Type</label>
							<select name="family_type" class="form-control family_type"/>
								<option value="">Select Family Type</option>
								<option value="kartha" {{isset($usersinglefamily->family_type)&& $usersinglefamily->family_type=='kartha'?'selected="selected"':''}}>Kartha</option>
								<option value="ancestors" {{isset($usersinglefamily->family_type)&&$usersinglefamily->family_type=='ancestors'?'selected="selected"':''}}>Ancestors</option>
								<option value="kartha_ancestors" {{isset($usersinglefamily->family_type)&&$usersinglefamily->family_type=='kartha_ancestors'?'selected="selected"':''}}>Kartha Ancestors</option>
							</select>
						</div>
						<div class="form-group col-lg-2">
							<label for="full_name">Name</label>
							<input type="text" id="full_name" name="full_name" class="form-control" value="{{isset($usersinglefamily->full_name)?$usersinglefamily->full_name:''}}" placeholder="Enter Full Name" />
							@error('full_name')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-lg-2">
							<label for="relation">Relation Type</label>
							<select name="relation" class="form-control relation"/>
								<option value="">Select Relation</option>
								@foreach ($relation as $res)
									<option value="{{ $res->id }}" {{isset($usersinglefamily->relation_id)&& $usersinglefamily->relation->id==$res->id?'selected="selected"':''}}>{{ $res->name }}</option>
								@endforeach
							</select>
							@error('relation')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-lg-2">
							<label for="rasi">Rasi</label>
							<select name="rasi" class="form-control rasi"/>
								<option value="">Select Rasi</option>
								@foreach ($rasi as $res)
									<option value="{{ $res->id }}" {{isset($usersinglefamily->rasi_id)&& $usersinglefamily->rasi->id==$res->id?'selected="selected"':''}}>{{ $res->name }}</option>
								@endforeach
							</select>
							@error('rasi')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="form-group col-lg-2">
							<label for="dob">DOB</label>
							<input type="date" name="dob" id="dob"
								class="form-control" placeholder="Enter Date Of Birth"  value="{{isset($usersinglefamily->dob)?date('Y-m-d', strtotime($usersinglefamily->dob)):''}}"/>
							@error('dob')
							<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-lg-2">
							<label for="gothram">Gothram</label>
							<input type="text" id="gothram" name="gothram" class="form-control" value="{{isset($usersinglefamily->gothram)?$usersinglefamily->gothram:''}}"placeholder="Enter Gothram" />
						</div>
						<div class="form-group col-lg-2">
							<label for="nakshatram">Nakshatram</label>
							<input type="text" id="nakshatram" name="nakshatram" class="form-control" value="{{isset($usersinglefamily->nakshatram)?$usersinglefamily->nakshatram:''}}" placeholder="Enter Nakshatram" />
						</div>
						<div class="form-group col-lg-4">
							<label for="description">Description</label>
							<textarea name="description" id="description"
								class="form-control" placeholder="Enter Description">{{isset($usersinglefamily->description)?$usersinglefamily->description:''}}</textarea>
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
										<th>Type</th>
                                        <th>Name</th>
										<th>DOB</th>
                                        <th>Gothram</th>
                                        <th>Nakshatram</th>
										<th>Desc.</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach ($userfamilydetails as $res)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $res->family_type }}</td>
                                        <td>{{ $res->full_name }}</td>
                                        <td>{{ $res->dob }}</td>
										<td>{{ $res->gothram }}</td>
										<td>{{ $res->nakshatram }}</td>
										<td>{{ $res->description }}</td>
                                        <td>@if($res->is_active=='active')
                                            <button class="btn btn-success  waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'0', {{$res->user_id}});">
                                                Active</button>
                                            @else
                                            <button class="btn btn-danger  waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'1', {{$res->user_id}});">
                                                Inactive</button>
                                            @endif

                                        </td>
                                        <td align="center">
											<a href="{{url('/')}}/user_family/{{ $res->user_id }}/{{ $res->id }}"
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
@endsection

@section('endscript')
<script>
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
			window.location = "{{ url('/change_family_status')}}" + '/' +
				id + '/' + status + '/' + user_id;
		}
	});
}
</script>
@endsection