@extends('layouts.beforelogin')
@section('content')

<div class="account-pages my-5 pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-primary">
                        <div class="text-primary text-center p-4">
                            <h5 class="text-white font-size-20">Welcome Back !</h5>
                            <p class="text-white-50">Sign in to continue to DevaSmriti.</p>
                            <a href="index.html" class="logo logo-admin">
                                <img src="assets/images/logo.svg" height="30" alt="logo">
                            </a>
                        </div>
                    </div>
					@if(isset(Auth::user()->username))
						<script>window.location="/main/successlogin";</script>
					@endif

					@if ($message = Session::get('error'))
						<div class="alert alert-danger alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>{{ $message }}</strong>
						</div>
					@endif

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<ul>
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
                    <div class="card-body p-4">
                        <div class="p-3">
                            <form class="form-horizontal mt-4" method="post" action="/check_login">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Enter username" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter password" required>
                                </div>

                                <div class="form-group row">
                                    <!-- <div class="col-sm-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                id="customControlInline">
                                            <label class="custom-control-label" for="customControlInline">Remember
                                                me</label>
                                        </div>
                                    </div> -->
                                    <div class="col-sm-6 text-right">
                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>
                                </div>

                                <div class="form-group mt-2 mb-0 row">
                                    <div class="col-12 mt-4">
                                        <a href="password_recovery"><i class="mdi mdi-lock"></i> Forgot your
                                            password?</a>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>

                <div class="mt-5 text-center">
                    <p class="mb-0">© <script>
                        document.write(new Date().getFullYear())
                        </script> DevaSmriti. Crafted with <i class="mdi mdi-heart text-danger"></i> by Vibho</p>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection