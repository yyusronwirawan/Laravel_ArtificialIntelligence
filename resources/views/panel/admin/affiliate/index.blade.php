@extends('panel.layout.app')
@section('title', 'My Affiliates')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center justify-between max-md:flex-col max-md:items-start max-md:gap-4">
                <div class="col">
                    <a href="/dashboard" class="page-pretitle flex items-center">
                        <svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
                        </svg>
                        {{__('Back to dashboard')}}
                    </a>
                    <h2 class="page-title mb-2">
                        {{__('Affiliate Requests')}}
                    </h2>
                </div>
                <div class="col-auto">
                    <a class="btn btn-primary" href="{{route('dashboard.admin.settings.affiliate')}}">{{__('Settings')}}</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
            <h2>{{__('Withdrawal Requests')}}</h2>
            <div class="card">
				<div id="table-default-2" class="card-table table-responsive">
					<table class="table">
						<thead>
						<tr>
							<th>#</th>
							<th>{{__('Amount')}}</th>
							<th>{{__('Bank Information')}}</th>
							<th>{{__('Status')}}</th>
							<th>{{__('Date')}}</th>
							<th>{{__('Action')}}</th>
						</tr>
						</thead>
						<tbody class="table-tbody align-middle text-heading">
						@foreach($list as $entry)
							<tr>
								<td class="sort-id">AFF-WTHDRWL-{{$entry->id}}</td>
								<td class="sort-amount">{{$entry->amount}}</td>
								<td class="sort-account">{{$entry->user->affiliate_bank_account}}</td>
								<td class="sort-status">{{$entry->status}}</td>
								<td class="sort-date" data-date="{{strtotime($entry->created_at)}}">
									<p class="m-0">{{date("j.n.Y", strtotime($entry->created_at))}}</p>
									<p class="m-0 text-muted">{{date("H:i:s", strtotime($entry->created_at))}}</p>
								</td>
								<td>
									<a class="btn btn-success" href="{{route('dashboard.admin.affiliates.sent', $entry->id)}}">{{__('Set as Sent')}}</a>
								</td>
							</tr>
						@endforeach

						@if(count($list) == 0)
							<tr>
								<td colspan="4" class="text-center">{{__('There is no withdraval request')}}</td>
							</tr>
						@endif

						</tbody>
					</table>
				</div>
            </div>

            <hr class="my-5">

            <h2>{{__('Succesfull Withdrawal Requests')}}</h2>
            <div class="card">
				<div id="table-default" class="card-table table-responsive">
					<table class="table">
						<thead>
						<tr>
							<th>#</th>
							<th>{{__('Amount')}}</th>
							<th>{{__('Bank Information')}}</th>
							<th>{{__('Status')}}</th>
							<th>{{__('Date')}}</th>
							<th>{{__('Action')}}</th>
						</tr>
						</thead>
						<tbody class="table-tbody align-middle text-heading">
						@foreach($list2 as $entry)
							<tr>
								<td class="sort-id">AFF-WTHDRWL-{{$entry->id}}</td>
								<td class="sort-amount">{{$entry->amount}}</td>
								<td class="sort-account">{{$entry->user->affiliate_bank_account}}</td>
								<td class="sort-status">{{$entry->status}}</td>
								<td class="sort-date" data-date="{{strtotime($entry->created_at)}}">
									<p class="m-0">{{date("j.n.Y", strtotime($entry->created_at))}}</p>
									<p class="m-0 text-muted">{{date("H:i:s", strtotime($entry->created_at))}}</p>
								</td>
								<td>
									<a class="btn btn-success" href="{{route('dashboard.admin.affiliates.sent', $entry->id)}}">Set as Sent</a>
								</td>
							</tr>
						@endforeach

						@if(count($list2) == 0)
							<tr>
								<td colspan="4" class="text-center">{{__('There is no succesfull withdraval request')}}</td>
							</tr>
						@endif

						</tbody>
					</table>
				</div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/assets/js/panel/affiliate.js"></script>
@endsection
