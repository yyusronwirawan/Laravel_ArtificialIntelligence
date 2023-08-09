@extends('panel.layout.app')
@section('title', 'Subscription Payment')

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
                        {{__('Subscription Payment')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-sm-8 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-xl-12">
                            <form id="payment-form" action="{{ route('dashboard.user.payment.subscription.payment.pay') }}" method="post" >
                                @csrf
                                <input type="hidden" name="plan" id="plan" value="{{ $plan->id }}">
                                <div class="row">
                                    <div class="col-md-12 col-xl-12">

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="mb-3">
                                                    <label class="form-label">{{__('Name On Card')}}</label>
                                                    <input type="text" class="form-control" name="name" id="card-holder-name">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label required">{{__('Card Information')}}</label>
                                                    <div class="position-relative form-control form-control-solid" id="card-element"></div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="pt-2 !text-end">
                                            <button type="submit" id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-success">
                                                {{__('Pay')}} {{currency()->symbol}}{{$plan->price}} {{__('with')}}<img src="/images/payment/stripe.svg" height="29px" alt="Stripe">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <p>{{__('By purchase you confirm our')}} <a href="#">{{__('Terms and Conditions')}}</a> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-4">
                    <div class="card card-md">
                        @if($plan->is_featured == 1)
                            <div class="ribbon ribbon-top ribbon-bookmark bg-green">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                            </div>
                        @endif
                        <div class="card-body text-center">
                            <div class="text-uppercase text-muted font-weight-medium">{{$plan->name}}</div>
                            <div class="display-5 fw-bold my-3">{{currency()->symbol}}{{$plan->price}}</div>
                            <div class="text-uppercase text-muted font-weight-medium mb-2">{{$plan->frequency}} PAYMENTS</div>

                            <ul class="list-unstyled lh-lg">
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                    {{__('Access')}} <strong>{{$plan->plan_type}}</strong> {{__('Templates')}}
                                </li>
                                @foreach(explode(',', $plan->features) as $item)
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                        {{$item}}
                                    </li>
                                @endforeach

                            </ul>
                            <div class="text-center mt-4">
                                <a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.payment.subscription') ) }}" class="btn w-100">{{__('Change Plan')}}</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
		(() => {
			"use strict";

			const stripe = Stripe('{{$setting->stripe_key}}');

			const elements = stripe.elements();

			const cardElement = elements.create('card');

			cardElement.mount('#card-element');

			const form = document.getElementById('payment-form')
			const cardHolderName = document.getElementById('card-holder-name');
			const cardButton = document.getElementById('card-button');
			const clientSecret = cardButton.dataset.secret;

			form.addEventListener('submit', async (e) => {
				e.preventDefault()
				cardButton.disabled = true
				cardButton.innerHTML = 'Please Wait, Processing...'

				const { setupIntent, error } = await stripe.confirmCardSetup(
					clientSecret, {
						payment_method: {
							card: cardElement,
							billing_details: { name: cardHolderName.value }
						}
					}
				);

				if(error) {
					cardButton.disabled = false
					cardButton.innerHTML = 'Pay with Stripe'

					toastr.error(error.message);
				} else {
					let token = document.createElement('input')
					token.setAttribute('type', 'hidden')
					token.setAttribute('name', 'token')
					token.setAttribute('value', setupIntent.payment_method)
					form.appendChild(token)
					form.submit();
				}
			})
		})();
    </script>
@endsection
