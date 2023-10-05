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
                        <h4 class="font-size-18">Transactions</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">DevaSmriti</a></li>
                            <li class="breadcrumb-item active">Transactions</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="admin_table" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Name</th>
                                        <th>Transaction Id</th>
                                        <th>Amount</th>
                                        <th>Credit or Debit</th>
                                        <th>Transaction Type</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach ($transactions as $res)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $res->user->name }}</td>
                                        <td>{{ $res->transaction_id }}</td>
                                        <td>{{ $res->amount }}</td>
                                        <td>{{ $res->cr_or_dr }}</td>
                                        <td>{{ $res->action_type }}</td>
                                        <td>{{ $res->description }}</td>
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