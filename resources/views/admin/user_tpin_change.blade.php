@extends('layouts.layout')
@section('content')
<div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title-box">
                    <h4 class="font-size-18">Change User T-PIN</h4>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">PayAgent</a></li>
                        <li class="breadcrumb-item"><a href="user_management">User Management</a></li>
                        <li class="breadcrumb-item active">Change T-PIN</li>
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

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden mt-5">
                            <div class="bg-primary">
                                <div class="text-primary text-center p-4">
                                    <h5 class="text-white font-size-20 p-2">Change T-PIN</h5>

                                </div>
                            </div>

                            <div class="card-body">

                                <div class="p-3">

                                    <div class="alert alert-success mt-2" role="alert">
                                        Enter your T PIN
                                    </div>

                                    <form class="form-horizontal mt-4" action="index.html">

                                        <div class="form-group">
                                            <label for="useremail">Enter T-PIN</label>
                                            <input type="email" class="form-control" id="useremail">
                                        </div>
                                        <div class="form-group">
                                            <label for="useremail">Re-enter T-PIN</label>
                                            <input type="email" class="form-control" id="useremail">
                                        </div>
                                        <div class="form-group row  mb-0">
                                            <div class="col-12 text-right">
                                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Confirm</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
@endsection
