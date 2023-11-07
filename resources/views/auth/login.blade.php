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
                                <img src="assets/images/logo-sm.png" height="30" alt="logo">
                            </a>
                        </div>
                    </div>
					
					
                <!--div class="card-header">{{ __('Login') }}</div-->

                <div class="card-body p-4">
				<div class="p-3">
                    <form class="form-horizontal mt-4" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="">{{ __('Email') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="">{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="custom-control-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        

                        <div class="col-sm-6 text-right">
                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">
                                    {{ __('Login') }}
                                </button>
								</div>
								</div>
								<div class="form-group mt-2 mb-0 row">
                                    <div class="col-12 mt-4">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
								</div>
								</div>
                    </form>
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
</div>
@endsection