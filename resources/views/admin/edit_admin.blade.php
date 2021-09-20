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
                                <a href="admin_management" class="btn btn-primary waves-effect waves-light">
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
                                        <form class="repeater" enctype="multipart/form-data">
                                            <div data-repeater-list="group-a">
                                                <div data-repeater-item class="row">
                                                    <div  class="form-group col-lg-4">
                                                        <label for="name">Name</label>
                                                        <input type="text" id="name" name="untyped-input" class="form-control"/>
                                                    </div>

                                                    <div  class="form-group col-lg-4">
                                                        <label for="email">Email</label>
                                                        <input type="email" id="email" class="form-control"/>
                                                    </div>

                                                    <div  class="form-group col-lg-4">
                                                        <label for="subject">Phone</label>
                                                        <input type="text" id="subject" class="form-control"/>
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
