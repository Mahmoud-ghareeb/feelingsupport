@extends('layouts.login')

@section('title')
{{ __('messages.Login') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="margin-top: 30px;">
            <div class="card" style="border-radius: 39px;">
                <!-- <div class="card-header login-card-header text-center">{{ __('Login') }}</div> -->

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="identity" class="col-md-4 col-form-label text-md-end">{{ __('messages.Email Address / User Name') }}</label>

                            <div class="col-md-6">
                                <input id="identity" type="text" class="form-control @error('identity') is-invalid @enderror" name="identity" value="{{ old('identity') }}" required autocomplete="identity" autofocus>

                                @error('identity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('messages.Password') }}</label>

                            <!-- eye-slash -->
                            <div class="col-md-6"> 
                                <i class="fa-solid fa-eye" style="position: absolute;@if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl') left: 17px; @else right: 17px; @endif top: 8px;font-size: 17px;cursor: pointer;"></i>
                                <i class="fa-solid fa-eye-slash" style="display:none;position: absolute;@if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl') left: 17px; @else right: 17px; @endif top: 8px;font-size: 17px;cursor: pointer;"></i>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" style="display:none">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>

                                    <label class="form-check-label" for="remember">
                                        {{ __('messages.Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="center-element">
                                <button type="submit" class="btn btn-primary" style="width: 150px;">
                                    {{ __('messages.Login') }}
                                </button>
                                
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" style="color: #bf1b2c;" href="{{ route('password.request') }}">
                                        {{ __('messages.Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                            
                            
                        </div>
                        <div class="center-element" style="margin-top: 20px;">
                            <p class="message">{{__('messages.Not registered?')}} <a href="{{ route('register') }}">{{__('messages.Create an account')}}</a></p>
                            </div>
                    </form>
                    <div>

                    </div>
                    <div class="social-login">
                        <a href="{{ route('facebook.login') }}" style="margin: 0px auto;padding-bottom: 10px;    display: block;">
                            <img width="197" height="42" style="border: 1px solid #4e6fa5;border-radius: 21px;" src="{{ asset('assets/images/fb_login.jpg') }}" alt="facebook login">
                        </a>
                        <a href="{{ route('google.login') }}" style="margin: 0px auto;padding-bottom: 10px;    display: block;">
                            <img width="197" height="42" style="border: 1px solid #de2000;border-radius: 21px;" src="{{ asset('assets/images/gl.png') }}" alt="google login">
                        </a>
                    </div>
                    <div class="social-login">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('.fa-eye').on('click', function(){
            $("#password").prop("type", "text");
            $(this).css('display', 'none');
            $('.fa-eye-slash').css('display', 'block');
        });
        $('.fa-eye-slash').on('click', function(){
            $("#password").prop("type", "password");
            $(this).css('display', 'none');
            $('.fa-eye').css('display', 'block');
        });
    });
    
</script>
@endsection
