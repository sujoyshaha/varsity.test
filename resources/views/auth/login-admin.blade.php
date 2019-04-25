@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">

                    <!--  ==================================SESSION MESSAGES==================================  -->
                        @if (session()->has('message'))
                            <div class="alert alert-{!! session()->get('type')  !!} alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {!! session()->get('message')  !!}
                            </div>
                        @endif
                    <!--  ==================================SESSION MESSAGES==================================  -->


                    <!--  ==================================VALIDATION ERRORS==================================  -->
                        @if($errors->any())
                            @foreach ($errors->all() as $error)

                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {!!  $error !!}
                                </div>

                        @endforeach
                     @endif
                    <!--  ==================================SESSION MESSAGES==================================  -->
                    <form method="POST" action="{{ route($login) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

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
        </div> --}}
    
   <!--  ==================================SESSION MESSAGES==================================  -->
                        @if (session()->has('message'))
                            <div class="alert alert-{!! session()->get('type')  !!} alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {!! session()->get('message')  !!}
                            </div>
                        @endif
                    <!--  ==================================SESSION MESSAGES==================================  -->


                    <!--  ==================================VALIDATION ERRORS==================================  -->
                        @if($errors->any())
                            @foreach ($errors->all() as $error)

                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {!!  $error !!}
                                </div>

                        @endforeach
                     @endif

    </div>
<br>
<br>
<br>


        <div class="container h-100">
        <div class="d-flex justify-content-center h-100">

  



            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="{{ asset('assets/images/user.png') }}" class="brand_logo" alt="Logo">

                          
                    </div>
                </div>
                <div class="d-flex justify-content-center form_container">
                    <form method="POST" action="{{ route($login) }}">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            {{-- <input type="text" name="" class="form-control input_user" value="" placeholder="username"> --}}

                            <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus placeholder="email">

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            {{-- <input type="password" name="" class="form-control input_pass" value="" placeholder="password"> --}}

                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} input_pass" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                {{-- <input type="checkbox" class="custom-control-input" id="customControlInline"> --}}
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customControlInline">Remember me</label>
                            </div>
                        </div>


                   
                <div class="d-flex justify-content-center mt-3 login_container">
                    {{-- <button type="button" name="button" class="btn login_btn">Login</button> --}}
                    <button type="submit" class="btn login_btn">
                                    {{ __('Login') }}
                                </button>
                </div>
                <div class="mt-4">
                    {{-- <div class="d-flex justify-content-center links">
                        Don't have an account? <a href="#" class="ml-2">Sign Up</a>
                    </div> --}}
                    <div class="d-flex justify-content-center links">

                        @if (Route::has('password.request'))
                                    <a style="color:#000;" class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                        
                    </div>
                </div>
 </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
