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
                            <h4 class="font-size-18">Admin Management</h4>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">PayAgent</a></li>
                                <li class="breadcrumb-item active">Admin Management</li>
                            </ol>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="float-right">
                                <a href="add_admin" class="btn btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-plus mr-2"></i> Add Admin
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

                                        <table id="admin_table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                            </thead>


                                            <tbody>
                                            <tr>
                                                <td>Tiger Nixon</td>
                                                <td>System@domain.com</td>
                                                <td>9988776655</td>
                                                <td align="center"><a href="edit_admin" class="btn btn-primary  waves-effect waves-light" href="#"><i class="ti-pencil mr-2"></i>Edit</a> <button class="btn btn-primary  waves-effect waves-light"><i class="ti-trash mr-2"></i> Delete</button></td>
                                            </tr>
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
