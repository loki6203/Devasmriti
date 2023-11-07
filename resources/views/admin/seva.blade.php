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
                        <h4 class="font-size-18">Sevas</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">DevaSmriti</a></li>
                            <li class="breadcrumb-item active">Sevas</li>
                        </ol>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-right">
                        <a href="add_seva" class="btn btn-primary waves-effect waves-light">
                            <i class="mdi mdi-plus mr-2"></i> Add Seva
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

                            <table id="user_table" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Title</th>
                                        <th>Code</th>
                                        <th>Event</th>
										<th>Location</th>
										<th>Temple</th>
										<th>Seva Type</th>
										<th>Start|End</th>
										<th>Ext.Charg.</th>
										<th>Reward Pts.</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach ($sevas as $res)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $res->title }}</td>
                                        <td>{{ $res->sku_code }}</td>
                                        <td>{{ $res->event }}</td>
										<td>{{ $res->location }}</td>
										<td title="{{$res->temple->name}}">{{ strlen($res->temple->name)>15?substr($res->temple->name, 0, 15).'..':substr($res->temple->name, 0, 15) }}</td>
										<td>{{ $res->seva_type->name }}</td>
										<td>{{ date('d M Y' ,strtotime($res->start_date)).'|'.date('d M Y' ,strtotime($res->expairy_date)) }}</td>
										<td>{{ $res->extracharges_label }}</td>
										<td>{{ $res->reward_points }}</td>
                                        <td>@if($res->is_active=='1')
                                            <button class="btn btn-success  waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'0');">
                                                Active</button>
                                            @else
                                            <button class="btn btn-danger  waves-effect waves-light"
                                                onclick="change_status({{ $res->id }},'1');">
                                                Inactive</button>
                                            @endif

                                        </td>
                                        <td align="center"><a href="edit_seva/{{ $res->id }}"
                                                class="btn btn-primary btn-sm waves-effect waves-light" href="#"><i
                                                    class="ti-pencil mr-2"></i>Edit</a>
													<!--a href="user_family/{{ $res->id }}"
                                                class="btn btn-info btn-sm waves-effect waves-light" href="#"><i
                                                    class="ti-user mr-2"></i>Family</a>
													<a href="user_address/{{ $res->id }}"
                                                class="btn btn-warning btn-sm waves-effect waves-light" href="#"><i
                                                    class="ti-user mr-2"></i>Address</a-->
													</td>
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
    <script>
    function change_status(id, status) {
        Swal.fire({
            text: "Are you sure want to change the status?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "{{ url('/change_seva_status')}}" + '/' +
                    id + '/' + status;
            }
        });
    }
    </script>
    @endsection