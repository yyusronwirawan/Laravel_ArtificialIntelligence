@extends('panel.layout.app')
@section('title', __('SMTP Settings'))

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
                    <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.index') ) }}" class="page-pretitle flex items-center">
                        <svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
                        </svg>
                        {{__('Back to dashboard')}}
                    </a>
                    <h2 class="page-title mb-2">
                        {{__('SMTP Settings')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-5 mx-auto">
                    <form id="settings_form" onsubmit="return smtpSettingsSave();" enctype="multipart/form-data">
                        <h3 class="mb-[25px] text-[20px]">{{__('SMTP Settings')}}</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{__('SMTP Host')}}</label>
                                    <input type="text" class="form-control" id="smtp_host" name="smtp_host" value="{{$setting->smtp_host}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{__('SMTP Port')}}</label>
                                    <input type="text" class="form-control" id="smtp_port" name="smtp_port" value="{{$setting->smtp_port}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{__('SMTP Username')}}</label>
                                    <input type="text" class="form-control" id="smtp_username" name="smtp_username" value="{{$setting->smtp_username}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{__('SMTP Password')}}</label>
                                    <input type="password" class="form-control" id="smtp_password" name="smtp_password" value="{{$setting->smtp_password}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{__('SMTP Sender Email')}}</label>
                                    <input type="text" class="form-control" id="smtp_email" name="smtp_email" value="{{$setting->smtp_email}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{__('SMTP Sender Name')}}</label>
                                    <input type="text" class="form-control" id="smtp_sender_name" name="smtp_sender_name" value="{{$setting->smtp_email}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{__('SMTP Encryption')}}</label>
                                    <input type="text" class="form-control" id="smtp_encryption" name="smtp_encryption" value="{{$setting->smtp_encryption}}">
                                </div>
                            </div>


                        </div>
                        <button form="settings_form" id="settings_button" class="btn btn-primary w-100">
                            {{__('Save')}}
                        </button>
                    </form>
                </div>


                <div class="col-md-5 mx-auto">
                    <form id="smtp_test_form" action="{{route('dashboard.admin.settings.smtp.test')}}" method="POST">
                        @csrf
                        <h3 class="mb-[25px] text-[20px]">{{__('SMTP Test')}}</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{__('Test Email')}}</label>
                                    <input type="text" class="form-control" name="test_email" placeholder="Email to send test email.">
                                </div>
                            </div>
                        </div>
                        <button form="smtp_test_form" id="smtp_button" class="btn btn-primary w-100">
                            {{__('Save')}}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/assets/js/panel/settings.js"></script>
@endsection
