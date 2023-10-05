@extends('layouts.beforelogin')
@section('content')

    <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary">
                                <div class="text-primary text-center p-4">
                                    <h5 class="text-white font-size-20 p-2">Reset Password</h5>
                                    <a href="index.html" class="logo logo-admin">
                                        <img src="assets/images/logo-sm.png" height="30" alt="logo">
                                    </a>
                                </div>
                            </div>

                            <div class="card-body p-4">

                                <div class="p-3">

                                    <div class="alert alert-success mt-5" role="alert">
                                        Enter your Email and instructions will be sent to you!
                                    </div>

                                    <form class="form-horizontal mt-4" action="index.html">

                                        <div class="form-group">
                                            <label for="useremail">Email</label>
                                            <input type="email" class="form-control" id="useremail" placeholder="Enter email">
                                        </div>

                                        <div class="form-group row  mb-0">
                                            <div class="col-12 text-right">
                                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <p>Remember It ? <a href="/" class="font-weight-medium text-primary"> Sign In here </a> </p>
                            <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> DevaSmriti. Crafted with <i class="mdi mdi-heart text-danger"></i> by Headrun</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
