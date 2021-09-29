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
                            <h4 class="font-size-18">Payment Gateway</h4>
                            <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">PayAgent</a></li>
                                <li class="breadcrumb-item active">Payment Gateway</li>
                            </ol>
                        </div>
                    </div>
                    </div>

                    <!-- <div class="col-sm-6">
                        <div class="float-right">
                        <a href="add_user" class="btn btn-primary waves-effect waves-light">
                            <i class="mdi mdi-arrow-left mr-2"></i> Add User
                        </a>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                     <h4 class="card-title">Add Card</h4>
                                     <p class="card-title-desc">Fill the below fields to add a card.</p>
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">Text</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" value="Artisanal kale" id="example-text-input">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-2 col-form-label">Search</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="search" value="How do I shoot web" id="example-search-input">
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

@endsection
