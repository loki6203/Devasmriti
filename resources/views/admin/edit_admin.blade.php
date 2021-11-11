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
                        <h4 class="font-size-18">Edit Admin</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">PayAgent</a></li>
                            <li class="breadcrumb-item"><a href="admin_management">Admin Management</a></li>
                            <li class="breadcrumb-item active">Edit Admin</li>
                        </ol>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="float-right">
                        <a href="{{ url('admin_management') }}" class="btn btn-primary waves-effect waves-light">
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
                            <form action="/update_admin/{{ $user['id'] }}" class=" repeater"
                                enctype="multipart/form-data">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}" />

                                <div>
                                    <div class="row">
                                        <div class="form-group col-lg-4">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ $user['name'] }}" />
                                        </div>

                                        <div class="form-group col-lg-4">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                value="{{ $user['email'] }}" />
                                        </div>

                                        <div class="form-group col-lg-4">
                                            <label for="subject">Phone</label>
                                            <input type="text" name="mobile_number" id="mobile_number"
                                                class="form-control" value="{{ $user['mobile_number'] }}" />
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