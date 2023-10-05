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
                            <h4 class="font-size-18">User transactions</h4>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">DevaSmriti</a></li>
                                <li class="breadcrumb-item"><a href="user_management">User Management</a></li>
                                <li class="breadcrumb-item active">User Transactions</li>
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

                                        <!-- <h4 class="card-title">Admin Members</h4>
                                        <p class="card-title-desc">Here are the admin members. Here you can edit or add an admin member</p> -->

                                        <table id="user_table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Name</th>
                                                <th>Transaction ID</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Amount(Rs)</th>
                                            </tr>
                                            </thead>


                                            <tbody>
                                            <tr>
                                                <td>27-09-2021</td>
                                                <td>System Name</td>
                                                <td>998877665544</td>
                                                <td>Description here Description here Description here </td>
                                                <td style="color:#f8b425;font-weight:500;">Pending</td>
                                                <td>100000</td>
                                            </tr>
                                            <tr>
                                                <td>27-09-2021</td>
                                                <td>System Name</td>
                                                <td>998877665544</td>
                                                <td>Description here Description here Description here </td>
                                                <td>Failed</td>
                                                <td>100000</td>
                                            </tr>
                                            <tr>
                                                <td>27-09-2021</td>
                                                <td>System Name</td>
                                                <td>998877665544</td>
                                                <td>Description here Description here Description here </td>
                                                <td style="color:#02a499;font-weight:500">Success</td>
                                                <td>100000</td>
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
