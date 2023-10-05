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
                        <h4 class="font-size-18">Wallet Management</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">DevaSmriti</a></li>
                            <li class="breadcrumb-item active">Wallet Management</li>
                        </ol>
                    </div>
                </div>

                <!-- <div class="col-sm-6">
                        <div class="float-right">
                        <a href="add_user" class="btn btn-primary waves-effect waves-light">
                            <i class="mdi mdi-plus mr-2"></i> Add User
                        </a>
                        </div>
                    </div> -->
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
                                        <th>Name</th>
                                        <th>Transaction ID</th>
                                        <th>Credits or Debits</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th class="all">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($acc_history as $res)
                                    <tr>
                                        <td>{{ $res->id }}</td>
                                        <td>{{ $res->transaction_id }}</td>
                                        <td>{{ $res->cr_or_dr }}</td>
                                        <td>{{ $res->amount }}</td>
                                        <td>{{ $res->description }} </td>
                                        <td> <span style="color:#ec4561;font-weight:500">Failed</span></td>
                                    </tr>
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