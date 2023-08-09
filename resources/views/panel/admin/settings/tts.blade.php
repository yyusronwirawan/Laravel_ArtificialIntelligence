@extends('panel.layout.app')
@section('title', __('TTS Settings'))
@section('additional_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
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
                        {{__('TTS Settings')}}
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
					<form id="settings_form" onsubmit="return ttsSettingsSave();" enctype="multipart/form-data">
						<h3 class="mb-[25px] text-[20px]">{{__('OpenAI Settings')}}</h3>
						<div class="row">

                            @if(env('APP_STATUS') == 'Demo')
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{__('GCS File (JSON) path')}}</label>
                                    <input type="text" class="form-control" id="gcs_file" name="gcs_file" placeholder="{{$placeholder}}" value="*********************">
                                </div>
                                <div class="mb-3">
									<label class="form-label">{{__('GCS Project Name')}}</label>
                                    <input type="text" class="form-control" id="gcs_name" name="gcs_name" placeholder="{{__('my-project-123')}}" value="*********************">
                                </div>
                            </div>
                            @else
							<div class="col-md-12">
                                <div class="mb-3">
									<label class="form-label">{{__('GCS File (JSON) path')}}</label>
                                    <input type="text" class="form-control" id="gcs_file" name="gcs_file" placeholder="googlefile.json" value="{{$setting->gcs_file}}">
									<div class="bg-orange-100 text-orange-600 rounded-xl !p-3 !mt-2 dark:bg-orange-600/20 dark:text-orange-200">
											<svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z"></path> <path d="M12 9v4"></path> <path d="M12 17h.01"></path> </svg>
											{{__('Please upload your file to the /public_html/storage folder within your project and provide the file name in the space provided.')}}
										</div>
                                </div>
                                <div class="mb-3">
									<label class="form-label">{{__('GCS Project Name')}}</label>
                                    <input type="text" class="form-control" id="gcs_name" name="gcs_name" placeholder="{{__('my-project-123')}}" value="{{$setting->gcs_name}}">
                                </div>
                            </div>
                            @endif

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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
