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
                        <h4 class="font-size-18">Temples</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">DevaSmriti</a></li>
                            <li class="breadcrumb-item active">Temples</li>
                        </ol>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right">
                        <a href="add_temple" class="btn btn-primary waves-effect waves-light">
                            <i class="mdi mdi-plus mr-2"></i> Add Temple
                        </a>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- <h4 class="card-title">Admin Members</h4>
                                        <p class="card-title-desc">Here are the admin members. Here you can edit or add an admin member</p> -->

                            <table id="user_table" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
										<th>Code</th>
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>State</th>
										<th>City</th>
										<th>Latitude</th>
										<th>Longitude</th>
										<th>Pincode</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach ($temples as $res)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $res->code }}</td>
                                        <td>{{ $res->name }}</td>
                                        <td>{{ $res->country->name }}</td>
										<td>{{ $res->state->name }}</td>
										<td>{{ $res->city->name }}</td>
										<td>{{ $res->latitude }}</td>
										<td>{{ $res->longitude }}</td>
										<td>{{ $res->pincode }}</td>
                                        <td>@if($res->is_active=='1')
                                            <button class="btn btn-success  waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'0');">
                                                Active</button>
                                            @elseif($res->is_active=='2')
                                            <button class="btn btn-success  waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'1');">
                                                Not Verified</button>
                                            @else
                                            <button class="btn btn-danger  waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'1');">
                                                Inactive</button>
                                            @endif

                                        </td>
                                        <td align="center"><a href="edit_temple/{{ $res->id }}"
                                                class="btn btn-primary  waves-effect waves-light" href="#"><i
                                                    class="ti-pencil mr-2"></i>Edit</a></td>
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
        Swal.fire({
            text: "Are you sure want to change the status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "{{ url('/change_temple_status')}}" + '/' +
                    id + '/' + status + '/';
            }
        });
    }
    </script>
    @endsection