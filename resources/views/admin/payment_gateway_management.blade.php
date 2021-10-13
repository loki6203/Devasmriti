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
                                     <div class="row">
                                         <div class="col-sm-12 col-md-6">
                                         <div class="form-group row">
                                            <label for="input-ip" class="col-sm-12 col-form-label">
                                              Card Number</label>
                                            <div class="col-sm-12">
                                              <input id="cardno" class="form-control input-mask" data-inputmask="'alias': 'cardno'" placeholder="Enter Card Number">
                                          </div>
                                         </div>
                                         </div>
                                         <div class="col-sm-12 col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">Name on Card</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="Artisanal kale" id="example-text-input">
                                                </div>
                                            </div>
                                         </div>
                                         <div class="col-sm-12 col-md-6">
                                         <div class="form-group row">
                                                <label class="col-sm-12 col-form-label">Expiry / Validity</label>
                                                <div class="col-sm-12">
                                                    <div class="input-group">
                                                        <input id="mmyyyy" class="form-control input-mask" data-inputmask="'alias': 'mmyyyy'" placeholder="mm/yyyy">
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                         <div class="col-sm-12 col-md-6">
                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-12 col-form-label">CVV</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="text" value="Artisanal kale" id="example-text-input">
                                                </div>
                                            </div>
                                         </div>
                                         <div class="col-12">
                                             <div class="card_submit mt-4">
                                                <button class="btn-primary btn" type="submit"><i class="ti-plus mr-2"></i> Add Card</button>
                                             </div>
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
