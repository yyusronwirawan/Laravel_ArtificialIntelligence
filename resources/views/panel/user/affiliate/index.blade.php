@extends('panel.layout.app')
@section('title', 'Affiliate')

@section('content')
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
                        {{__('Affiliate')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body pt-6">
        <div class="container-xl">
            <div class="row row-deck row-cards">
				<div class="col-12">
					<div class="card bg-[#F3E2FD] shadow-sm">
						<div class="card-body p-10">
							<div class="row">
								<div class="col-12 col-md-5">
									<h4 class="w-10/12 mb-10 text-[20px] leading-[1.3em]">{{__('Invite your friends and earn commision from their first purchase.')}}🎁</h4>
									<p class="mb-2 text-heading text-[13px]">{{__('Affiliate Link')}}</p>
									<div class="flex items-center relative">
										<input id="ref-code" class="form-control h-10 bg-white border-0 dark:!border-[1px] dark:!border-solid dark:!border-[#243049] dark:!bg-transparent dark:text-white" type="text" disabled value="{{url('/')}}/register?aff={{\Illuminate\Support\Facades\Auth::user()->affiliate_code}}">
										<button class="copy-aff-link btn flex items-center h-full absolute top-0 !end-0 px-3 bg-transparent shadow-none hover:scale-125">
											<svg width="13" height="16" viewBox="0 0 13 16" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M9.34375 0.65625V2H1.34375V11.3438H0V2C0 1.625 0.125 1.3125 0.375 1.0625C0.645833 0.791667 0.96875 0.65625 1.34375 0.65625H9.34375ZM11.3438 3.34375C11.6979 3.34375 12 3.47917 12.25 3.75C12.5208 4 12.6562 4.30208 12.6562 4.65625V14C12.6562 14.375 12.5208 14.6875 12.25 14.9375C12 15.2083 11.6979 15.3438 11.3438 15.3438H4C3.625 15.3438 3.30208 15.2083 3.03125 14.9375C2.78125 14.6875 2.65625 14.375 2.65625 14V4.65625C2.65625 4.30208 2.78125 4 3.03125 3.75C3.30208 3.47917 3.625 3.34375 4 3.34375H11.3438ZM11.3438 14V4.65625H4V14H11.3438Z" fill="currentColor"/>
											</svg>
										</button>
									</div>
								</div>
								<div class="col-12 col-md-4 ms-auto text-center text-heading font-semibold max-md:-order-1 max-md:!text-start max-md:mb-3">
									<h4 class="mb-0 text-[16px]">{{__('Earnings')}}</h4>
									<p class="mb-2 text-[58px]">${{$totalEarnings-$totalWithdrawal}}</p>
									<p class="mb-0"><span class="opacity-60">{{__('Comission Rate')}}:</span> {{$setting->affiliate_commission_percentage}}%</p>
									<p class="mb-0"><span class="opacity-60">{{__('Referral Program')}}:</span> {{__('All Purchases')}}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card text-heading">
						<div class="card-body flex flex-col py-6 px-8">
							<h2 class="mb-[1em]">{{__('How it works')}}</h2>
							<ol class="list-none p-0 ml-0 mb-7">
								<li class="mb-[18px]">
									<span class="inline-flex items-center justify-center w-[26px] h-[26px] me-[1em] bg-[rgba(var(--tblr-primary-rgb),0.2)] text-primary rounded-2xl">
										<svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M0.522461 12V9.63199H2.98646V3.69599L0.522461 5.45599V2.57599L3.00246 0.799988H5.88246V9.63199H7.88246V12H0.522461Z" fill="#7A63DF"/> </svg>
									</span>
									{!! __('You <strong>send your invitation link</strong> to your friends.') !!}
								</li>
								<li class="mb-[18px]">
									<span class="inline-flex items-center justify-center w-[26px] h-[26px] me-[1em] bg-[rgba(var(--tblr-primary-rgb),0.2)] text-primary rounded-2xl">
										<svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M0.400391 12V9.95198L4.11239 6.87998C4.59239 6.48531 4.98172 6.13865 5.28039 5.83998C5.58972 5.53065 5.80839 5.24265 5.93639 4.97598C6.07506 4.70931 6.14439 4.43731 6.14439 4.15998C6.14439 3.78665 6.04306 3.49865 5.84039 3.29598C5.63772 3.09331 5.34439 2.99198 4.96039 2.99198C4.45906 2.99198 4.08039 3.15198 3.82439 3.47198C3.56839 3.79198 3.44039 4.26131 3.44039 4.87998H0.560391C0.560391 3.96265 0.720391 3.18931 1.04039 2.55998C1.37106 1.91998 1.86172 1.43465 2.51239 1.10398C3.16306 0.762647 3.97906 0.59198 4.96039 0.59198C5.87772 0.59198 6.63506 0.746647 7.23239 1.05598C7.84039 1.35465 8.29372 1.77065 8.59239 2.30398C8.89106 2.83731 9.04039 3.45598 9.04039 4.15998C9.04039 4.67198 8.92306 5.16265 8.68839 5.63198C8.45372 6.09065 8.13372 6.52798 7.72839 6.94398C7.33372 7.34931 6.87506 7.75465 6.35239 8.15998L4.41639 9.63198H9.20039V12H0.400391Z" fill="#7A63DF"/> </svg>
									</span>
									{!! __('<strong>They subscribe</strong> to a paid plan by using your refferral link.') !!}
								</li>
								<li class="mb-[18px]">
									<span class="inline-flex items-center justify-center w-[26px] h-[26px] me-[1em] bg-[rgba(var(--tblr-primary-rgb),0.2)] text-primary rounded-2xl">
										<svg width="10" height="13" viewBox="0 0 10 13" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.80047 12.208C3.85114 12.208 3.05114 12.0373 2.40047 11.696C1.76047 11.3546 1.28047 10.8853 0.960469 10.288C0.640469 9.69065 0.480469 9.00798 0.480469 8.23998H3.36047C3.36047 8.76265 3.4778 9.15731 3.71247 9.42398C3.9578 9.67998 4.35247 9.80798 4.89647 9.80798C5.34447 9.80798 5.67514 9.69598 5.88847 9.47198C6.11247 9.23731 6.22447 8.92798 6.22447 8.54398C6.22447 8.13865 6.11247 7.82931 5.88847 7.61598C5.66447 7.40265 5.3018 7.29598 4.80047 7.29598H3.85647V5.18398H4.80047C5.22714 5.18398 5.5418 5.08798 5.74447 4.89598C5.9578 4.70398 6.06447 4.42131 6.06447 4.04798C6.06447 3.71731 5.96314 3.46131 5.76047 3.27998C5.5578 3.08798 5.2698 2.99198 4.89647 2.99198C4.42714 2.99198 4.08047 3.10931 3.85647 3.34398C3.63247 3.57865 3.52047 3.93065 3.52047 4.39998H0.640469C0.640469 3.59998 0.800469 2.91731 1.12047 2.35198C1.44047 1.78665 1.9098 1.35465 2.52847 1.05598C3.1578 0.746647 3.91514 0.59198 4.80047 0.59198C5.6858 0.59198 6.4378 0.725314 7.05647 0.991981C7.67514 1.24798 8.14447 1.61065 8.46447 2.07998C8.79514 2.54931 8.96047 3.08798 8.96047 3.69598C8.96047 4.30398 8.7898 4.82131 8.44847 5.24798C8.10714 5.67465 7.64847 5.97865 7.07247 6.15998C7.74447 6.34131 8.25113 6.65065 8.59247 7.08798C8.94447 7.52531 9.12047 8.09598 9.12047 8.79998C9.12047 9.47198 8.94447 10.0693 8.59247 10.592C8.24047 11.104 7.73914 11.504 7.08847 11.792C6.44847 12.0693 5.6858 12.208 4.80047 12.208Z" fill="#7A63DF"/> </svg>
									</span>
									{!! __('You <strong>start earning commision</strong> from their first purchase.') !!}
								</li>
							</ol>
							<p class="mb-2 mt-auto text-heading text-[13px]">{{__('Affiliate Link')}}</p>
                            <form id="send_invitation_form" onsubmit="return sendInvitationForm();">
                                <div class="flex items-center relative">
                                    <input class="form-control h-10" type="email" name="to_mail" id="to_mail" placeholder="{{__('Email address')}}" required>
                                    <span class="flex items-center h-full absolute top-0 !end-0 px-3">
									<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"> <g clip-path="url(#clip0_253_1239)"> <path d="M17.4167 4.58331H4.58333C3.57081 4.58331 2.75 5.40412 2.75 6.41665V15.5833C2.75 16.5958 3.57081 17.4166 4.58333 17.4166H17.4167C18.4292 17.4166 19.25 16.5958 19.25 15.5833V6.41665C19.25 5.40412 18.4292 4.58331 17.4167 4.58331Z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/> <path d="M2.75 6.41669L11 11.9167L19.25 6.41669" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/> </g> <defs> <clipPath id="clip0_253_1239"> <rect width="22" height="22" fill="white"/> </clipPath> </defs> </svg>
								</span>
                                </div>
                                <button type="submit" id="send_invitation_button" form="send_invitation_form" class="btn btn-primary mt-2 w-100 rounded-[10px]">{{__('Send')}}</button>
                            </form>

                        </div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card">
						<div class="card-body py-6 px-8">
							<h2 class="mb-[1em]">{{__('Withdrawal Form')}}</h2>
							<form id="send_request_form" onsubmit="return sendRequestForm();">
								<div class="mb-[15px]">
									<label class="form-label" for="affiliate_bank_account">{{__('Your Bank Information')}}</label>
									<textarea class="form-control" rows="2" name="affiliate_bank_account" id="affiliate_bank_account" placeholder="{{__('Bank of America - 2382372329 3843749 2372379')}}">{{Auth::user()->affiliate_bank_account ?? null}}</textarea>
								</div>

								<div class="mb-[20px]">
									<label class="form-label" for="affiliate_bank_account">{{__('Amount')}}</label>
									<input type="number" class="form-control h-10" name="amount" id="amount" min="{{$setting->affiliate_minimum_withdrawal}}" placeholder="{{__('Minimum Withdrawal Amount is')}} {{$setting->affiliate_minimum_withdrawal}}">
								</div>

								<button type="submit" id="send_request_button" form="send_request_form" class="btn btn-primary w-100 rounded-[10px]">{{__('Send Request')}}</button>
							</form>
						</div>
					</div>
				</div>
                <div class="col-12">
					<div class="card">
						<div class="card-body">
							<h2>{{__('Withdrawal Requests')}}</h2>
							<div id="table-default-2" class="table-responsive">
								<table class="table">
									<thead>
									<tr>
										<th><button class="table-sort" data-sort="sort-id">{{__('No')}}</button></th>
										<th><button class="table-sort" data-sort="sort-amount">{{__('Amount')}}</button></th>
										<th><button class="table-sort" data-sort="sort-status">{{__('Status')}}</button></th>
										<th><button class="table-sort" data-sort="sort-date">{{__('Date')}}</button></th>
									</tr>
									</thead>
									<tbody class="table-tbody">
									@foreach($list2 as $entry)
										<tr>
											<td class="sort-id">AFF-WTHDRWL-{{$entry->id}}</td>
											<td class="sort-amount">{{$entry->amount}}</td>
											<td class="sort-status">{{$entry->status}}</td>
											<td class="sort-date" data-date="{{strtotime($entry->created_at)}}">{{$entry->created_at}}</td>
										</tr>
									@endforeach

									@if(count($list) == 0)
										<tr>
											<td colspan="4" class="text-center">{{__('You have no withdraval request')}}</td>
										</tr>
									@endif

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="/assets/js/panel/affiliate.js"></script>
@endsection

