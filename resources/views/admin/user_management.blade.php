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
                        <h4 class="font-size-18">User Management</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">PayAgent</a></li>
                            <li class="breadcrumb-item active">User Management</li>
                        </ol>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right">
                        <a href="add_user" class="btn btn-primary waves-effect waves-light">
                            <i class="mdi mdi-plus mr-2"></i> Add User
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach ($user as $res)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $res->name }}</td>
                                        <td>{{ $res->email }}</td>
                                        <td>{{ $res->mobile_number }}</td>
                                        <td>@if($res->is_active=='active')
                                            <button class="btn btn-success  waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'inactive');">
                                                Active</button>
                                            @elseif($res->is_active=='not_verified')
                                            <button class="btn btn-success  waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'{{ $res->is_active }}');">
                                                Not Verified</button>
                                            @else
                                            <button class="btn btn-danger  waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'active');">
                                                Inactive</button>
                                            @endif

                                        </td>
                                        <td align="center"><a href="edit_user/{{ $res->id }}"
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