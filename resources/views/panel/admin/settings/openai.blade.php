@extends('panel.layout.app')
@section('title', __('Openai Settings'))
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
                        {{__('OpenAI Settings')}}
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
					<form id="settings_form" onsubmit="return openaiSettingsSave();" enctype="multipart/form-data">
						<h3 class="mb-[25px] text-[20px]">{{__('OpenAI Settings')}}</h3>
						<div class="row">
                            <!-- TODO OPENAI API KEY -->
                            @if(env('APP_STATUS') == 'Demo')
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">{{__('OpenAi API Secret')}}</label>
                                    <input type="text" class="form-control" id="openai_api_secret" name="openai_api_secret" value="*********************">
                                </div>
                            </div>
                            @else
                                <div class="col-md-12">
                                    <div class="form-control border-none p-0 mb-3 [&_.select2-selection--multiple]:!border-[--tblr-border-color] [&_.select2-selection--multiple]:!p-[1em_1.23em] [&_.select2-selection--multiple]:!rounded-[--tblr-border-radius]">
                                        <label class="form-label">{{__('OpenAi API Secret')}}</label>
                                        <select class="form-control select2" name="openai_api_secret" id="openai_api_secret" multiple>
                                            @foreach(explode(',', $setting->openai_api_secret) as $secret)
                                                <option value="{{$secret}}" selected>{{$secret}}</option>
                                            @endforeach
                                        </select>
										<div class="bg-blue-100 text-blue-600 rounded-xl !p-3 !mt-2 dark:bg-blue-600/20 dark:text-blue-200">
											<svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
											{{__('You can enter as much API KEY as you want. Click "Enter" after each api key.')}}
										</div>
										<div class="bg-orange-100 text-orange-600 rounded-xl !p-3 !mt-2 dark:bg-orange-600/20 dark:text-orange-200">
											<svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z"></path> <path d="M12 9v4"></path> <path d="M12 17h.01"></path> </svg>
											{{__('Please ensure that your OpenAI API key is fully functional and billing defined on your OpenAI account.')}}
										</div>
                                        <a href="{{route('dashboard.admin.settings.openai.test')}}" target="_blank" class="btn btn-primary w-100 mt-2 mb-2">
                                            {{__('After Saving Setting, Click Here to Test Your Api Keys')}}
                                        </a>
                                    </div>
                                </div>
                            @endif




							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">{{__('Default Openai Model')}}</label>
									<select class="form-select" name="openai_default_model" id="openai_default_model">
										<!--
										<option value="text-ada-001" {{$setting->openai_default_model == 'text-ada-001' ? 'selected' : null}}>{{__('Ada (Cheapest &amp; Fastest)')}}</option>
										<option value="text-babbage-001" {{$setting->openai_default_model == 'text-babbage-001' ? 'selected' : null}}>{{__('Babbage')}}</option>
										<option value="text-curie-001" {{$setting->openai_default_model == 'text-curie-001' ? 'selected' : null}}>{{__('Curie')}}</option>
										-->
										<option value="text-davinci-003" {{$setting->openai_default_model == 'text-davinci-003' ? 'selected' : null}}>{{__('Davinci (Expensive &amp; Capable)')}}</option>
										<option value="gpt-3.5-turbo" {{$setting->openai_default_model == 'gpt-3.5-turbo' ? 'selected' : null}}>{{__('ChatGPT (Most Expensive & Fastest & Most Capable)')}}</option>
										<option value="gpt-4" {{$setting->openai_default_model == 'gpt-4' ? 'selected' : null}}>{{__('ChatGPT-4 (Most Expensive & Fastest & Most Capable)')}}</option>
									</select>
									<div class="bg-blue-100 text-blue-600 rounded-xl !p-3 !mt-2 dark:bg-blue-600/20 dark:text-blue-200">
										<svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
										{{__('Please note GPT-4 is not working with every api_key. You have to have an api key which can work with GPT-4.')}}
										<br>
										{{__('Also please note that Chat models works with ChatGPT and GPT-4 models. So if you choose below it will automatically use ChatGPT.')}}
									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">{{__('Default Openai Language')}}</label>
									<select class="form-select" name="openai_default_language" id="openai_default_language">
									   @include('panel.admin.settings.languages')
									</select>
								</div>
							</div>


							<div class="col-md-12">
								<div class="mb-3">
									<label class="form-label">{{__('Default Tone of Voice')}}</label>
									<select class="form-select" name="openai_default_tone_of_voice" id="openai_default_tone_of_voice">
										<option value="Professional" {{$setting->openai_default_tone_of_voice == 'Professional' ? 'selected' : null}}>{{__('Professional')}}</option>
										<option value="Funny" {{$setting->opena_default_tone_of_voice == 'Funny' ? 'selected' : null}}>{{__('Funny')}}</option>
										<option value="Casual" {{$setting->openai_default_tone_of_voice == 'Casual' ? 'selected' : null}}>{{__('Casual')}}</option>
										<option value="Excited" {{$setting->openai_default_tone_of_voice == 'Excited' ? 'selected' : null}}>{{__('Excited')}}</option>
										<option value="Witty" {{$setting->openai_default_tone_of_voice == 'Witty' ? 'selected' : null}}>{{__('Witty')}}</option>
										<option value="Sarcastic" {{$setting->openai_default_tone_of_voice == 'Sarcastic' ? 'selected' : null}}>{{__('Sarcastic')}}</option>
										<option value="Feminine" {{$setting->openai_default_tone_of_voice == 'Feminine' ? 'selected' : null}}>{{__('Feminine')}}</option>
										<option value="Masculine" {{$setting->openai_default_tone_of_voice == 'Masculine' ? 'selected' : null}}>{{__('Masculine')}}</option>
										<option value="Bold" {{$setting->openai_default_tone_of_voice == 'Bold' ? 'selected' : null}}>{{__('Bold')}}</option>
										<option value="Dramatic" {{$setting->openai_default_tone_of_voice == 'Dramatic' ? 'selected' : null}}>{{__('Dramatic')}}</option>
										<option value="Grumpy" {{$setting->openai_default_tone_of_voice == 'Grumpy' ? 'selected' : null}}>{{__('Grumpy')}}</option>
										<option value="Secretive" {{$setting->openai_default_tone_of_voice == 'Secretive' ? 'selected' : null}}>{{__('Secretive')}}</option>
									</select>
								</div>
							</div>

							<div class="col-md-12">
								<div class="mb-3">
                                    <label class="form-label">{{__('Default Creativity')}}</label>
                                    <select type="text" class="form-select" name="openai_default_creativity" id="openai_default_creativity" required>
                                        <option value="0.25" {{$setting->openai_default_creativity == 0.25 ? 'selected' : ''}}>{{__('Economic')}}</option>
                                        <option value="0.5" {{$setting->openai_default_creativity == 0.5 ? 'selected' : ''}}>{{__('Average')}}</option>
                                        <option value="0.75" {{$setting->openai_default_creativity == 0.75 ? 'selected' : ''}}>{{__('Good')}}</option>
                                        <option value="1" {{$setting->openai_default_creativity == 1 ? 'selected' : ''}}>{{__('Premium')}}</option>
                                    </select>
								</div>
							</div>

							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">{{__('Maximum Input Length')}}</label>
									<input type="number" class="form-control" id="openai_max_input_length" name="opena_max_input_length" min="10" max="2000" value="{{$setting->openai_max_input_length}}" required>
									<div class="bg-blue-100 text-blue-600 rounded-xl !p-3 !mt-2 dark:bg-blue-600/20 dark:text-blue-200">
										<svg xmlns="http://www.w3.org/2000/svg" class="inline !me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
										{{__('In Characters')}}
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="mb-3">
									<label class="form-label">{{__('Maximum Output Length')}}</label>
									<input type="number" class="form-control" id="openai_max_output_length" name="opena_max_output_length" min="0" max="2000" value="{{$setting->openai_max_output_length}}" required>
									<div class="bg-blue-100 text-blue-600 rounded-xl !p-3 !mt-2 dark:bg-blue-600/20 dark:text-blue-200">
										<svg xmlns="http://www.w3.org/2000/svg" class="inline !me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
										{{__('In Words. OpenAI has a hard limit based on Token limits for each model. Refer to OpenAI documentation to learn more. As a recommended by OpenAI, max result length is capped at 2000 words')}}
									</div>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
