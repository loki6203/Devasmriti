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

                                        <table id="user_table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>User IP</th>
                                                <th>Type</th>
                                                <th>Aadhaar No</th>
                                                <th>PAN No</th>
                                                <th>Gateway charge %</th>
                                                <th>Referal charge %</th>
                                                <th>Benificary acc charge %</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                            </thead>


                                            <tbody>
                                            <tr>
                                                <td>Tiger Nixon</td>
                                                <td>System@domain.com </td>
                                                <td>9988776655</td>
                                                <td>11-11-111-11-111</td>
                                                <td>Normal</td>
                                                <td>99887766550909</td>
                                                <td>ELAPH8754D</td>
                                                <td>18%</td>
                                                <td>18%</td>
                                                <td>18%</td>
                                                <td align="center"><button type="button" class="btn btn-success  waves-effect waves-light" href="#"> Active</button> <button type="button" class="btn btn-danger  waves-effect waves-light" href="#"> Inactive</button></td>
                                                <td align="center"><a href="user_transactions" class="btn btn-secondary waves-effect waves-light"><i class="ti-money mr-2"></i>Transactions</a> <a href="user_tpin_change" class="btn btn-warning  waves-effect waves-light"><i class="ti-key mr-2"></i>Change T pin</a> <a href="edit_user" class="btn btn-primary  waves-effect waves-light"><i class="ti-pencil mr-2"></i>Edit</a> <button class="btn btn-danger  waves-effect waves-light" id="sa-warning"><i class="ti-trash mr-2"></i> Delete</button></td>
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
