@extends('panel.layout.app_without_sidebar')
@section('title', __('Reset Password'))
@section('content')

    <div class="page page-auth page-login">
        <div class="absolute top-0 left-0 right-0 container-fluid">
            <div class="items-center p-8 row">
                <div class="col">
                    <a href="{{route('index')}}" class="navbar-brand navbar-brand-autodark">
                        @if(isset($setting->logo_dashboard))
                            <img src="/{{$setting->logo_dashboard_path}}" @if ( isset($setting->logo_dashboard_2x_path) ) srcset="/{{$setting->logo_dashboard_2x_path}} 2x" @endif alt="{{$setting->site_name}}" class="group-[.navbar-shrinked]/body:hidden dark:hidden">
                            <img src="/{{$setting->logo_dashboard_dark_path}}" @if ( isset($setting->logo_dashboard_dark_2x_path) ) srcset="/{{$setting->logo_dashboard_dark_2x_path}} 2x" @endif alt="{{$setting->site_name}}" class="hidden group-[.navbar-shrinked]/body:hidden dark:block">
                        @else
                            <img src="/{{$setting->logo_path}}" @if ( isset($setting->logo_2x_path) ) srcset="/{{$setting->logo_2x_path}} 2x" @endif alt="{{$setting->site_name}}" class="group-[.navbar-shrinked]/body:hidden dark:hidden">
                            <img src="/{{$setting->logo_dark_path}}" @if ( isset($setting->logo_dark_2x_path) ) srcset="/{{$setting->logo_dark_2x_path}} 2x" @endif alt="{{$setting->site_name}}" class="hidden group-[.navbar-shrinked]/body:hidden dark:block">
                        @endif
                    </a>
                </div>
                <div class="col !text-end">
                    <a href="{{route('index')}}" class="text-heading !no-underline lg:text-white bg-transparent">
                        <svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
                        </svg>
                        {{__('Back to Home')}}
                    </a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row items-stretch min-h-[100vh] max-lg:py-11">
                <div class="flex flex-col justify-center col-lg-6">
                    <div class="row">
                        <div class="mx-auto col-lg-6">
                            <h1 class="text-center mb-[25px]">{{__('Forgot Password')}}</h1>
                            <form novalidate="novalidate" id="password_reset_form" onsubmit="return PasswordResetMailForm();">
                                <div class="mb-[20px]">
                                    <label class="form-label">{{__('Email Address')}}</label>
                                    <input type="email" class="form-control" id="password_reset_email" placeholder="{{__('your@email.com')}}" autocomplete="off" required>
                                </div>
                                <div class="row">
                                    <div class="col !text-end">
                                        <a href="{{route('login')}}">{{__('Remember Your Password?')}}</a>
                                    </div>
                                </div>
                                <div class="row mt-[25px]">
                                    <div class="col">
                                        <button id="PasswordResetFormButton" form="password_reset_form" class="btn btn-primary w-100">{{__('Send Instructions')}}</button>
                                    </div>
                                </div>
                                <!-- TODO Openai Demo -->
                            </form>
                            @if($setting->register_active == 1)
                                <div class="mt-20 text-center text-muted">
                                    {{__("Don't have account yet?")}} <a href="{{route('register')}}" tabindex="-1" class="font-medium underline">{{__('Sign up')}}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex flex-col justify-center overflow-hidden bg-center bg-cover col-lg-6 max-lg:hidden" style="background-image: url(/images/bg/bg-auth.jpg)">
                    <img src="/images/bg/dash-mockup.jpg" alt="MagicAI Dashboard Mockup" class="rounded-[36px] shadow-[0_24px_88px_rgba(0,0,0,0.55)] translate-x-[27%]">
                </div>
            </div>
        </div>
    </div>
@endsection
