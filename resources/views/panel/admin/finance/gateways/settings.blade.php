@extends('panel.layout.app')
@section('title', __($options['title']).' '.__('Settings'))

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
                    <div class="hstack gap-1">
                        <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.index') ) }}" class="page-pretitle flex items-center">
                            <svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
                            </svg>
                            {{__('Back to dashboard')}}
                        </a>
                        <a href="{{route('dashboard.admin.finance.paymentGateways.index')}}" class="page-pretitle flex items-center">
                            / {{__('Back to Payment Gateways')}}
                        </a>
                    </div>
                    <h2 class="page-title mb-2">
                        {{ __($options['title']).' '.__('Settings')}}
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
					<form id="settings_form" onsubmit="return settingsSave();" enctype="multipart/form-data" method="post">
						<h3 class="mb-[25px] text-[20px]">{{ __($options['title']).' '.__('Settings')}}</h3>

                        <div class="vstack gap-3">

                            <input type="hidden" name="code" id="code" value="{{$options['code']}}" />
                            
                            <div class="form-check form-switch">
                                @if($settings['is_active'] == true)
                                <input class="form-check-input rounded" type="checkbox" role="switch" id="is_active" name="is_active" checked="checked" >
                                @else
                                <input class="form-check-input rounded" type="checkbox" role="switch" id="is_active" name="is_active">
                                @endif

                                <label class="form-check-label" for="is_active">{{__('Enable Gateway')}}</label>
                            </div>
                            
                            @if($options['currency'] == 1)
                            <div class="vstack gap-1">
                                <label class="form-label">{{__('Default Currency')}}</label>
                                <select class="form-control" id="currency" name="currency" required> <!-- style='font-family: "Courier New", Courier, monospace;' -->
                                    {!! $currencies !!}
                                </select>
                            </div>
                            @endif

                            @if($options['currency_locale'] == 1)
                            <div class="vstack gap-1">
                                <label class="form-label">{{__('Currency Locale')}}</label>
                                <input type="text" class="form-control" id="currency_locale" name="currency_locale" value="{{$settings->currency_locale}}" required>
                            </div>
                            @endif


                            @if(env('APP_STATUS') == 'Demo')
                            @if($options['live_client_id'] == 1)
                            <div class="vstack gap-1">
                                <label class="form-label">{{__('Api Key')}}</label>
								<input type="text" class="form-control" id="sandbox_client_id" name="sandbox_client_id" value="*************">
                            </div>
                            @endif
                            @if($options['live_client_secret'] == 1)
                            <div class="vstack gap-1">
                                <label class="form-label">{{__('Api Secret')}}</label>
                                <input type="text" class="form-control" id="sandbox_client_secret" name="sandbox_client_secret" value="*****************">
                            </div>
                            @endif
                            @else
                            @if($options['live_client_id'] == 1)
                            <div class="vstack gap-1">
                                <label class="form-label">{{__('Api Key')}}</label>
                                <input type="text" class="form-control" id="live_client_id" name="live_client_id" value="{{$settings->live_client_id}}" required>
                            </div>
                            @endif
                            @if($options['live_client_secret'] == 1)
                            <div class="vstack gap-1">
                                <label class="form-label">{{__('Api Secret')}}</label>
                                <input type="text" class="form-control" id="live_client_secret" name="live_client_secret" value="{{$settings->live_client_secret}}" required>
                            </div>
                            @endif
                            @if($options['live_app_id'] == 1)
                            <div class="vstack gap-1">
                                <label class="form-label">{{__('App ID')}}</label>
                                <input type="text" class="form-control" id="live_app_id" name="live_app_id" value="{{$settings->live_app_id}}" required>
                            </div>
                            @endif
                            @if($options['base_url'] == 1)
                            <div class="vstack gap-1">
                                <label class="form-label">{{__('Base URL')}}</label>
                                <input type="text" class="form-control" id="base_url" name="base_url" value="{{$settings->base_url ?? ($options['code'] == 'stripe' ? 'https://api.stripe.com' : '') }}" required>
                            </div>
                            @endif
                            @endif
                            
                            @if(env('APP_ENV') == 'development')@endif
                            @if($options['sandbox_client_id'] == 1)
                            <div class="vstack gap-1">
                                <label class="form-label">{{__('Api Key')}}&nbsp;({{__('Sandbox')}})</label>
                                <input type="text" class="form-control" id="sandbox_client_id" name="sandbox_client_id" value="{{$settings->sandbox_client_id}}">
                            </div>
                            @endif
                            @if($options['sandbox_client_secret'] == 1)
                            <div class="vstack gap-1">
                                <label class="form-label">{{__('Api Secret')}}&nbsp;({{__('Sandbox')}})</label>
                                <input type="text" class="form-control" id="sandbox_client_secret" name="sandbox_client_secret" value="{{$settings->sandbox_client_secret}}">
                            </div>
                            @endif
                            @if($options['sandbox_app_id'] == 1)
                            <div class="vstack gap-1">
                                <label class="form-label">{{__('App ID')}}&nbsp;({{__('Sandbox')}})</label>
                                <input type="text" class="form-control" id="sandbox_app_id" name="sandbox_app_id" value="{{$settings->sandbox_app_id}}">
                            </div>
                            @endif
                            @if($options['sandbox_url'] == 1)
                            <div class="vstack gap-1">
                                <label class="form-label">{{__('Base URL')}}&nbsp;({{__('Sandbox')}})</label>
                                <input type="text" class="form-control" id="sandbox_url" name="sandbox_url" value="{{$settings->sandbox_url}}">
                            </div>
                            @endif
                            

                            

                        

                            <button form="settings_form" id="settings_button" class="btn btn-primary w-100 mt-2" >
                                {{__('Save')}}
                            </button>

                            @if($options['mode'] == 1)
                            <input type="hidden" id="mode" name="mode" value="{{ env('APP_ENV') == 'development' ? 'sandbox' : 'live' }}" />
                            @endif

                            <input type="hidden" id="title" name="title" value="{{ $options['title'] }}" />
                        </div>

					</form>

                    <div class="bg-blue-100 text-blue-600 rounded-xl !p-3 mt-3 dark:bg-blue-600/20 dark:text-blue-200">
                        <svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
                        {{__("What happens when you save?")}}
                        <ul class="ml-2 mt-2">
                            <li>{{__('Save your settings.')}}</li>
                            <li>{{__('Check all membership plans for this gateway.')}}</li>
                            <li>{{__('Remove all products and prices defined before for old settings.')}}</li>
                            <li>{{__('Cancel all old subscriptions. Acquired amounts do not reset.')}}</li>
                            <li>{{__('Generate new product definitions in your new gateway account.')}}</li>
                            <li>{{__('Generate new price definitions in your new gateway account.')}}</li>
                            <!-- <li>{{__('')}}</li> -->
                        </ul>
                        
                        <svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
                        {{__('Note that we do not store old keys. So every save action is new.')}}
                        <br><br>
                    
                        <svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
                        {{__('This process will take time. So, please be patient and wait until success message appears.')}}
                    
                    
                    </div>

				</div>
			</div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/assets/js/gateways/settings.js"></script>
@endsection
