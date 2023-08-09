@extends('panel.layout.app')
@section('title', __('Subscriptions and Packs'))

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
                        {{__('Manage Subscription and Token Packs')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
            @if($gatewayError == true)
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="bg-amber-100 text-amber-600 rounded-xl !p-3 !mt-2 dark:bg-amber-600/20 dark:text-amber-200">
                        <svg class="inline !me-1" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path> <path d="M12 9h.01"></path> <path d="M11 12h1v4h1"></path> </svg>
                        {{ __('Gateway is set to use sandbox. Please set mode to development!') }}<br><br>
                        <ul>
                            <li>
                                {{__('To use live settings:')}}
                                <ul>
                                    <li>{{__('Set mode to Production')}}</li>
                                    <li>{{__('Save gateway settings')}}</li>
                                    <li>{{__('Know that all defined products and prices will reset.')}}</li>
                                </ul>
                            </li>
                            <li>
                                {{__('To use sandbox settings:')}}
                                <ul>
                                    <li>{{__('Set mode to Development')}}</li>
                                    <li>{{__('Save gateway settings')}}</li>
                                    <li>{{__('Know that all defined products and prices will reset.')}}</li>
                                </ul>
                            </li>
                            <li>{{__('Beware of that order is important. First set mode then save gateway settings.')}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            <div class="d-flex mb-3">
                @if(env('APP_STATUS') == 'Demo')
                <a onclick="return toastr.info('This feature is disabled in Demo version.')" class="btn btn-success mx-2">{{__('Create New Subscription')}}</a>
                <a onclick="return toastr.info('This feature is disabled in Demo version.')" class="btn btn-primary mx-2">{{__('Create New Token Pack')}}</a>
                @else
                <a href="{{route('dashboard.admin.finance.plans.SubscriptionNewOrEdit')}}" class="btn btn-success mx-2">{{__('Create New Subscription')}}</a>
                <a href="{{route('dashboard.admin.finance.plans.PlanNewOrEdit')}}" class="btn btn-primary mx-2">{{__('Create New Token Pack')}}</a>
                @endif
            </div>
            <div class="card">
				<div id="table-default" class="card-table table-responsive">
					<table class="table">
						<thead>
						<tr>
							<th>{{__('Status')}}</th>
							<th>{{__('Type')}}</th>
							<th>{{__('Name')}}</th>
							<th>{{__('Price')}}</th>
							<th>{{__('Total Words')}}</th>
							<th>{{__('Total Images')}}</th>
							<th>{{__('Updated At')}}</th>
							<th>{{__('Actions')}}</th>
						</tr>
						</thead>
						<tbody class="table-tbody align-middle text-heading">
						@foreach($plans as $entry)
							<tr>
								<td class="sort-name">
									@if($entry->active == 1)
										<div class="badge bg-success">{{__('Active')}}</div>
									@else
										<div class="badge bg-danger">{{__('Passive')}}</div>
									@endif
								</td>
								<td class="sort-group">{{ $entry->type == 'prepaid' ? __('Token Pack') : __('Subscription') }}</td>
								<td class="sort-remaining-words">{{$entry->name}}</td>
								<td class="sort-remaining-images">{{$entry->price}}</td>
								<td class="sort-country">{{ (int)$entry->total_words > 0 ? $entry->total_words : __('Unlimited') }}</td>
								<td class="sort-status">{{ (int)$entry->total_images > 0 ? $entry->total_images : __('Unlimited')}}</td>
								<td class="sort-date" data-date="{{strtotime($entry->updated_at)}}">
									<p class="m-0">{{date("j.n.Y", strtotime($entry->updated_at))}}</p>
									<p class="m-0 text-muted">{{date("H:i:s", strtotime($entry->updated_at))}}</p>
								</td>
								<td class="whitespace-nowrap">
                                    @if(env('APP_STATUS') == 'Demo')
									<a onclick="return toastr.info('This feature is disabled in Demo version.')"
										class="btn w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white" title="Edit">
										<svg width="13" height="12" viewBox="0 0 15 14" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path d="M8.71875 2.43988L11.9688 5.58995M10.75 11.4963H14M4.25 13.0714L12.7812 4.80248C12.9946 4.59564 13.1639 4.35009 13.2794 4.07984C13.3949 3.8096 13.4543 3.51995 13.4543 3.22744C13.4543 2.93493 13.3949 2.64528 13.2794 2.37504C13.1639 2.10479 12.9946 1.85924 12.7812 1.6524C12.5679 1.44557 12.3145 1.28149 12.0357 1.16955C11.7569 1.05761 11.458 1 11.1562 1C10.8545 1 10.5556 1.05761 10.2768 1.16955C9.99799 1.28149 9.74465 1.44557 9.53125 1.6524L1 9.92135V13.0714H4.25Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</a>
									<a onclick="return toastr.info('This feature is disabled in Demo version.')" class="btn w-[36px] h-[36px] p-0 border hover:bg-red-500 hover:text-white" title="Delete">
										<svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path d="M9.08789 1.74609L5.80664 5L9.08789 8.25391L8.26758 9.07422L4.98633 5.82031L1.73242 9.07422L0.912109 8.25391L4.16602 5L0.912109 1.74609L1.73242 0.925781L4.98633 4.17969L8.26758 0.925781L9.08789 1.74609Z"/>
										</svg>
									</a>
                                    @else
                                        <a
                                            @if($entry->type == 'subscription')
                                                href="{{route('dashboard.admin.finance.plans.SubscriptionNewOrEdit', $entry->id)}}"
                                            @else
                                                href="{{route('dashboard.admin.finance.plans.PlanNewOrEdit', $entry->id)}}"
                                            @endif
                                            class="btn w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white" title="Edit">
                                            <svg width="13" height="12" viewBox="0 0 15 14" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.71875 2.43988L11.9688 5.58995M10.75 11.4963H14M4.25 13.0714L12.7812 4.80248C12.9946 4.59564 13.1639 4.35009 13.2794 4.07984C13.3949 3.8096 13.4543 3.51995 13.4543 3.22744C13.4543 2.93493 13.3949 2.64528 13.2794 2.37504C13.1639 2.10479 12.9946 1.85924 12.7812 1.6524C12.5679 1.44557 12.3145 1.28149 12.0357 1.16955C11.7569 1.05761 11.458 1 11.1562 1C10.8545 1 10.5556 1.05761 10.2768 1.16955C9.99799 1.28149 9.74465 1.44557 9.53125 1.6524L1 9.92135V13.0714H4.25Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                        <a onclick="return confirm('Do you want to delete this plan? All subscriptions will be cancelled. This is not reversible.');" href="{{route('dashboard.admin.finance.plans.delete', $entry->id)}}" class="btn w-[36px] h-[36px] p-0 border hover:bg-red-500 hover:text-white" title="Delete">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.08789 1.74609L5.80664 5L9.08789 8.25391L8.26758 9.07422L4.98633 5.82031L1.73242 9.07422L0.912109 8.25391L4.16602 5L0.912109 1.74609L1.73242 0.925781L4.98633 4.17969L8.26758 0.925781L9.08789 1.74609Z"/>
                                            </svg>
                                        </a>
                                    @endif
								</td>
							</tr>
						@endforeach

						</tbody>
					</table>
				</div>
            </div>
        </div>
    </div>
@endsection
