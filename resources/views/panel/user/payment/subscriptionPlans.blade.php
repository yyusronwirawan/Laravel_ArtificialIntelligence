@extends('panel.layout.app')
@section('title', __('Subscription Plans'))
@inject('paymentControls', 'App\Http\Controllers\PaymentController')
@inject('gatewayControls', 'App\Http\Controllers\GatewayController')

@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
					<a href="{{ LaravelLocalization::localizeUrl(route('dashboard.index')) }}" class="page-pretitle flex items-center">
						<svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
						</svg>
						{{__('Back to dashboard')}}
					</a>
                    <h2 class="page-title mb-2">
                        {{__('Subscription Plans')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-8">
        <div class="container-xl">
            <div class="row row-cards">
				<div class="col-12">
					<h2>{{__('Current plan')}}</h2>
					@include('panel.user.payment.subscriptionStatus')
				</div>
				<div class="grid gap-3 grid-cols-4 max-lg:grid-cols-2 max-md:grid-cols-1">
					@foreach($plans as $plan)
					<div class="w-full border-solid border-[--tblr-border-color] rounded-3xl {{$plan->is_featured == 1 ? 'shadow-[0_7px_20px_rgba(0,0,0,0.04)]' : ''}}">
						<div class="flex flex-col h-full p-[1rem]">
							<div class="flex items-start mb-2 text-[50px] leading-none text-heading font-bold">
								{{$plan->price}}
								<div class="inline-flex flex-col items-start gap-2 mt-2 ms-2 text-[0.3em]">
									{{currency()->code}} / {{$plan->frequency}}
									@if($plan->is_featured == 1)
										<div class="inline-flex rounded-full py-[0.25rem] px-[0.75rem] bg-gradient-to-r from-[#ece7f7] via-[#e7c5e6] to-[#e7ebf9] text-[11px] text-black">
											{{__('Popular plan')}}
										</div>
									@endif
								</div>
							</div>
							<p class="font-medium text-[15px] leading-none text-muted">{{$plan->name}}</p>

							<ul class="list-none p-0 my-6 text-[15px] text-heading">
								@if($plan->trial_days != 0)
								<li class="mb-3">
									<span class="inline-flex items-center justify-center w-[20px] h-[20px] mr-1 bg-[rgba(var(--tblr-primary-rgb),0.1)] text-primary rounded-xl align-middle">
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
								</span>
								{{ number_format($plan->trial_days)." ".__('Days of free trial.') }} 
								</li>
								@endif
								<li class="mb-3">
									<span class="inline-flex items-center justify-center w-[20px] h-[20px] mr-1 bg-[rgba(var(--tblr-primary-rgb),0.1)] text-primary rounded-xl align-middle">
										<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
									</span>
									{{__('Access')}} <strong>{{$plan->plan_type}}</strong> {{__('Templates')}}
								</li>
								@foreach(explode(',', $plan->features) as $item)
									<li class="mb-3">
										<span class="inline-flex items-center justify-center w-[20px] h-[20px] mr-1 bg-[rgba(var(--tblr-primary-rgb),0.1)] text-primary rounded-xl align-middle">
										<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
									</span>
										{{$item}}
									</li>
								@endforeach
								<li class="mb-[0.625em]">
										<span class="inline-flex items-center justify-center w-[19px] h-[19px] mr-1 bg-[rgba(var(--tblr-primary-rgb),0.1)] text-primary rounded-xl align-middle">
											<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
										</span>
										@if((int)$plan->total_words >= 0)
										<strong>{{number_format($plan->total_words)}}</strong> {{__('Word Tokens')}}
										@else
										<strong>{{__('Unlimited')}}</strong> {{__('Word Tokens')}}
										@endif
									</li>
									<li class="mb-[0.625em]">
										<span class="inline-flex items-center justify-center w-[19px] h-[19px] mr-1 bg-[rgba(var(--tblr-primary-rgb),0.1)] text-primary rounded-xl align-middle">
											<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
										</span>
										@if((int)$plan->total_images >= 0)
										<strong>{{number_format($plan->total_images)}}</strong> {{__('Image Tokens')}}
										@else
										<strong>{{__('Unlimited')}}</strong> {{__('Image Tokens')}}
										@endif
									</li>
							</ul>
							@if($activesubid == $plan->id)
							<div class="mt-auto -mx-[1rem] mb-[1rem] text-center">
								<div class="vstack gap-2">
									<span class="text-success"><b>{{__('Already Subscribed')}}</b></span>
									<a onclick="return confirm('Are you sure to cancel your plan? You will lose your remaining usage.');" href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.payment.cancelActiveSubscription') ) }}" class="text-muted">{{__('Cancel Subscription')}}</a>
								</div>
							</div>
							@elseif($activesubid != null)
							<div class="mt-auto -mx-[1rem] mb-[1rem] text-center">
								<div class="vstack gap-2">
									<span class="text-muted"><b>{{__('You have an active subscription.')}}</b></span>
								</div>
							</div>
							@else
							<div class="mt-auto -mx-[1rem] -mb-[1rem] text-center">
								@if($is_active_gateway == 1)
								@php($planid=$plan->id)
								<a class="btn rounded-3xl py-[0.75rem] -mx-px -mb-px w-full border border-[--tblr-border-color] text-[15px] font-semibold shadow-none hover:bg-[--tblr-primary] hover:text-white" 
								href = "#" role="button" data-bs-toggle="modal" data-bs-target="#gatewayModal_{{ $planid }}">{{__('Choose plan')}}</a>
								<div class="modal fade" id="gatewayModal_{{ $planid }}" tabindex="-1" aria-labelledby="gatewayModalLabel_{{ $planid }}" aria-hidden="true">
									<div class="modal-dialog modal-sm modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h1 class="modal-title" id="gatewayModalLabel_{{ $planid }}">Continue with</h1>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body vstack gap-3">
											@foreach($activeGateways as $gateway)
											@php($data=$gatewayControls->gatewayData($gateway->code))
											<a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.payment.startSubscriptionProcess',['planId' => $planid, 'gatewayCode' => $data['code'] ]) ) }}" 
											class="btn rounded-3xl px-3 py-0 -mx-px -mb-px w-full h-[36px] flex items-center border border-[--tblr-border-color] text-[15px] font-semibold shadow-none hover:bg-[--tblr-primary] hover:text-white">
												<div class="flex justify-between w-100 align-middle items-center h-[36px] m-0 p-0"> 
													@if($data['whiteLogo'] == 1)
													<img src="{{ $data['img'] }}" style="max-height:24px;" alt="{{ $data['title'] }}"  class="rounded-3xl bg-[--tblr-primary] "/>
													@else
													<img src="{{ $data['img'] }}" style="max-height:24px;" alt="{{ $data['title'] }}"/>
													@endif
													<span class="">{{ $data['title'] }}</span>
												</div>
											</a>
											@endforeach
											</div>
										</div>
									</div>
								</div>
								@else
								<p>{{__('Please enable a payment gateway')}}</p>
								@endif
							</div>
							@endif
						</div>
					</div>
					@endforeach
				</div>
				<div class="page-header pt-4">
					<div class="container-xl">
						<div class="row g-2 items-center">
							<div class="col">
								<h2 class="page-title mb-2">
									{{__('Token Packs')}}
								</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="grid gap-3 grid-cols-4 max-lg:grid-cols-2 max-md:grid-cols-1">
					@foreach($prepaidplans as $plan)
						<div class="w-full border-solid border-[--tblr-border-color] rounded-3xl {{$plan->is_featured == 1 ? 'shadow-[0_7px_20px_rgba(0,0,0,0.04)]' : ''}}">
							<div class="flex flex-col h-full p-[1rem]">
								<div class="flex items-start mb-2 text-[50px] leading-none text-heading font-bold">
									{{$plan->price}}
									<div class="inline-flex flex-col items-start gap-2 mt-2 ms-2 text-[0.3em]">
										{{currency()->code}} / {{__('One time')}}
										@if($plan->is_featured == 1)
											<div class="inline-flex rounded-full py-[0.25rem] px-[0.75rem] bg-gradient-to-r from-[#ece7f7] via-[#e7c5e6] to-[#e7ebf9] text-[11px] text-black">
												{{__('Popular pack')}}
											</div>
										@endif
									</div>
								</div>
								<p class="font-medium text-[15px] leading-none text-muted">{{$plan->name}}</p>

								<ul class="list-none p-0 my-6 text-[15px] text-heading">
									<li class="mb-3">
										<span class="inline-flex items-center justify-center w-[20px] h-[20px] mr-1 bg-[rgba(var(--tblr-primary-rgb),0.1)] text-primary rounded-xl align-middle">
											<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
										</span>
										{{__('Access')}} <strong>{{$plan->plan_type}}</strong> {{__('Templates')}}
									</li>
									@foreach(explode(',', $plan->features) as $item)
										<li class="mb-3">
											<span class="inline-flex items-center justify-center w-[20px] h-[20px] mr-1 bg-[rgba(var(--tblr-primary-rgb),0.1)] text-primary rounded-xl align-middle">
											<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
										</span>
											{{$item}}
										</li>
									@endforeach
									<li class="mb-[0.625em]">
										<span class="inline-flex items-center justify-center w-[19px] h-[19px] mr-1 bg-[rgba(var(--tblr-primary-rgb),0.1)] text-primary rounded-xl align-middle">
											<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
										</span>
										<strong>{{number_format($plan->total_words)}}</strong> {{__('Word Tokens')}}
									</li>
									<li class="mb-[0.625em]">
										<span class="inline-flex items-center justify-center w-[19px] h-[19px] mr-1 bg-[rgba(var(--tblr-primary-rgb),0.1)] text-primary rounded-xl align-middle">
											<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
										</span>
										<strong>{{number_format($plan->total_images)}}</strong> {{__('Image Tokens')}}
									</li>
								</ul>
								<div class="mt-auto -mx-[1rem] -mb-[1rem] text-center">
									@if($is_active_gateway == 1)
									@php($planid=$plan->id)
									<a class="btn rounded-3xl py-[0.75rem] -mx-px -mb-px w-full border border-[--tblr-border-color] text-[15px] font-semibold shadow-none hover:bg-[--tblr-primary] hover:text-white" 
									href="#" role="button" data-bs-toggle="modal" data-bs-target="#gatewayPrepaidModal_{{ $planid }}" >{{__('Choose pack')}}</a>
									<div class="modal fade" id="gatewayPrepaidModal_{{ $planid }}" tabindex="-1" aria-labelledby="gatewayPrepaidModalLabel_{{ $planid }}" aria-hidden="true">
										<div class="modal-dialog modal-sm modal-dialog-centered">
											<div class="modal-content">
												<div class="modal-header">
													<h1 class="modal-title" id="gatewayPrepaidModalLabel_{{ $planid }}">Continue with</h1>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body vstack gap-3">
												@foreach($activeGateways as $gateway)
												@php($data=$gatewayControls->gatewayData($gateway->code))
												<a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.payment.startPrepaidPaymentProcess',['planId' => $planid, 'gatewayCode' => $data['code'] ]) ) }}" 
												class="btn rounded-3xl px-3 py-0 -mx-px -mb-px w-full h-[36px] flex items-center border border-[--tblr-border-color] text-[15px] font-semibold shadow-none hover:bg-[--tblr-primary] hover:text-white">
													<div class="flex justify-between w-100 align-middle items-center h-[36px] m-0 p-0"> 
														@if($data['whiteLogo'] == 1)
														<img src="{{ $data['img'] }}" style="max-height:24px;" alt="{{ $data['title'] }}"  class="rounded-3xl bg-[--tblr-primary] "/>
														@else
														<img src="{{ $data['img'] }}" style="max-height:24px;" alt="{{ $data['title'] }}"/>
														@endif
														<span class="">{{ $data['title'] }}</span>
													</div>
												</a>
												@endforeach
												</div>
											</div>
										</div>
									</div>

									@else
									<p>{{__('Please enable a payment gateway')}}</p>
									@endif
								</div>
							</div>
						</div>
					@endforeach
				</div>
            </div>
        </div>
    </div>

@endsection
