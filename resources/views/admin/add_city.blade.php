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
                        <h4 class="font-size-18">Add City</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">DevaSmriti</a></li>
                            <li class="breadcrumb-item"><a href="user_management">City</a></li>
                            <li class="breadcrumb-item active">Add City</li>
                        </ol>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right">
                        <a href="city" class="btn btn-primary waves-effect waves-light">
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
                            <form action="/save_city" enctype="multipart/form-data">
                                <div>
                                    <div class="row">
                                        <div class="form-group col-lg-4">
                                            <label for="country_id">Country</label>
                                            <select class="form-control select2" name="country_id" id="country_id"
                                                required onchange="Get_States(this.value);">
                                                <option value="">Select Country</option>
                                                @foreach ($country as $res)
                                                <option value="{{ $res->id }}">{{ $res->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="intState_id">State</label>
                                            <select class="form-control select2" name="intState_id" id="intState_id"
                                                required>
                                                <option value="">Select State</option>



                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="name">City</label>
                                            <input type="name" id="name" class="form-control" name="name"
                                                placeholder="Enter City" />
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
    <script>
    function Get_States(id) {
        if (id != '') {
            $.ajax({
                url: "{{ url('/get_states') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(data) {
                    var parse_data = JSON.parse(data);
                    $('#intState_id').find('option').not(':first').remove();
                    $.each(parse_data, function(index, value) {
                        $("#intState_id").append("<option value='" + value.id + "'>" +
                            value.name + "</option>");
                    });
                }
            })
        } else {
            $('#intState_id').find('option').not(':first').remove();
        }
    }
    </script>
    @endsection