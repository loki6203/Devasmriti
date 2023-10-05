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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- <h4 class="card-title">Example</h4> -->
                            <form action="/update_password" enctype="multipart/form-data">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                                <div>
                                    <div class="row">
                                        <div class="form-group col-lg-3">
                                            <label for="old_pass">Old Password</label>
                                            <input type="password" id="old_pass" name="old_pass" class="form-control"
                                                placeholder="Enter Old Password" required />
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <label for="new_pass">New Password</label>
                                            <input type="password" id="new_pass" class="form-control" name="new_pass"
                                                placeholder="Enter New Password" required />
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <label for="c_pass">Confirm Password</label>
                                            <input type="password" name="c_pass" id="c_pass" class="form-control"
                                                placeholder="Enter Confirm Password" required />
                                        </div>
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