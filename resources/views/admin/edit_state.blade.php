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
                        <h4 class="font-size-18">Edit State</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">DevaSmriti</a></li>
                            <li class="breadcrumb-item"><a href="admin_management">State</a></li>
                            <li class="breadcrumb-item active">Edit State</li>
                        </ol>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="float-right">
                        <a href="{{ url('state') }}" class="btn btn-primary waves-effect waves-light">
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
                            <form action="/update_state/{{ $state['id'] }}" class=" repeater"
                                enctype="multipart/form-data">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}" />

                                <div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="country_id">Country</label>
                                            <select class="form-control select2" name="country_id" id="country_id"
                                                required>
                                                <option value="">Select Country</option>
                                                @foreach ($country as $cunt)
                                                <option value="{{ $cunt['id'] }}"
                                                    <?php if($state['country_id'] == $cunt['id']) { ?>
                                                    selected="selected" <?php } ?>>{{ $cunt['name'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="name">State</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ $state['name'] }}" placeholder="Enter State" />
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