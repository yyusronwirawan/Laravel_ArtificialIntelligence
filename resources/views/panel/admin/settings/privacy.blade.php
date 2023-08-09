@extends('panel.layout.app')
@section('title', __('Privacy Policy and Terms Settings'))

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
                        {{__('Privacy Policy and Terms Settings')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <form id="settings_form" onsubmit="return privacySettingsSave();" enctype="multipart/form-data">
                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="privacy_enable" {{ $setting->privacy_enable ? 'checked' : '' }}>
                                        <span class="form-check-label">{{ __('Enable Privacy Policy and Terms') }}</span>
                                    </label>
                                </div>
                                <div class="mb-3 hide-page-element">
                                    <label class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="privacy_enable_login" {{ $setting->privacy_enable_login ? 'checked' : '' }}>
                                        <span class="form-check-label">{{ __('Show on the Login Page') }}</span>
                                    </label>
                                </div>
                            </div>

                            <h3 class="mb-2 mt-4 text-[20px] inline-flex items-baseline gap-x-2 hide-page-element">{{__('Privacy Policy')}} <a class="mb-4 text-gray-400 text-[12px]" target="_blank" href="{{url('/')}}/privacy-policy">/privacy-policy <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 7l-10 10"></path><path d="M8 7l9 0l0 9"></path></svg></a></h3>
                            
                            <div class="col-md-12 hide-page-element">
                                <div class="mb-3">
                                    <textarea class="form-control" id="privacy_content" name="privacy_content">{{$setting->privacy_content}}</textarea>
                                </div>
                            </div>
                            
                            <h3 class="mb-2 mt-4 text-[20px] inline-flex items-baseline gap-x-2 hide-page-element">{{__('Terms & Conditions')}} <a class="mb-4 text-gray-400 text-[12px]" target="_blank" href="{{url('/')}}/terms">/terms <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 7l-10 10"></path><path d="M8 7l9 0l0 9"></path></svg></a></h3>
                            
                            <div class="col-md-12 hide-page-element">
                                <div class="mb-3">
                                    <textarea class="form-control" id="terms_content" name="terms_content">{{$setting->terms_content}}</textarea>
                                </div>
                            </div>

                        </div>

                        <button form="settings_form" id="settings_button" class="btn btn-primary w-100">
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
    <script src="/assets/libs/tinymce/tinymce.min.js"></script>
	<script>
		tinymce.init({
			selector: '#privacy_content,#terms_content',
			plugins: 'quickbars advlist link image lists',
			//toolbar:'advlist link image lists'
			toolbar:'undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | lists | indent outdent | image',
  			quickbars_insert_toolbar: false
		});
	</script>
	<script>
        (() => {
            checkPrivacy();
            // Checkbox değeri değiştiğinde kontrol et
            $("#privacy_enable").change(function() {
                checkPrivacy();
            });

            function checkPrivacy() {
                if ($("#privacy_enable").is(":checked")) {
                    $(".hide-page-element").removeClass("hidden");
                } else {
                    $(".hide-page-element").addClass("hidden");
                }
            }
        })();
	</script>
@endsection
