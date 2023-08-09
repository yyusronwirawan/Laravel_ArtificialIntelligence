@extends('panel.layout.app')
@section('title', 'My Orders')

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
                        {{__('My Orders')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
			<div id="table-default" class="table-responsive">
				<table class="table">
					<thead>
					<tr>
						<th>{{__('Order Id')}}</th>
						<th>{{__('Plan Name')}}</th>
						<th>{{__('Words')}}</th>
						<th>{{__('Images')}}</th>
						<th>{{__('Price')}}</th>
						<th>{{__('Type')}}</th>
						<th>{{__('Date')}}</th>
						<th>{{__('Actions')}}</th>
					</tr>
					</thead>
					<tbody class="table-tbody align-middle text-heading">
					@foreach($list as $entry)
						<tr>
							<td class="sort-id">{{$entry->order_id}}</td>
							<td class="sort-name">{{@$entry->plan->name ?? 'Archived'}}</td>
							<td class="sort-words">{{@$entry->plan->total_words ?? '-'}}</td>
							<td class="sort-images">{{@$entry->plan->total_images ?? '-'}}</td>
							<td class="sort-price">{{currency()->symbol}}{{$entry->price}}</td>
							<td class="sort-type text-capitalize">{{$entry->type}}</td>
							<td class="sort-date" data-date="{{strtotime($entry->created_at)}}">
								<p class="m-0">{{date("j.n.Y", strtotime($entry->created_at))}}</p>
								<p class="m-0 text-muted">{{date("H:i:s", strtotime($entry->created_at))}}</p>
							</td>
							<td>
								<a href="{{ LaravelLocalization::localizeUrl( route('dashboard.user.orders.invoice', $entry->order_id) ) }}" class="btn border p-0 w-[36px] h-[36px] hover:bg-[var(--tblr-primary)] hover:text-white" title="{{__('Invoice')}}">
									<svg width="16" height="16" viewBox="0 0 18 18" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path d="M13 3H16C16.2652 3 16.5196 3.10536 16.7071 3.29289C16.8946 3.48043 17 3.73478 17 4V15C17 15.5304 16.7893 16.0391 16.4142 16.4142C16.0391 16.7893 15.5304 17 15 17M15 17C14.4696 17 13.9609 16.7893 13.5858 16.4142C13.2107 16.0391 13 15.5304 13 15V2C13 1.73478 12.8946 1.48043 12.7071 1.29289C12.5196 1.10536 12.2652 1 12 1H2C1.73478 1 1.48043 1.10536 1.29289 1.29289C1.10536 1.48043 1 1.73478 1 2V14C1 14.7956 1.31607 15.5587 1.87868 16.1213C2.44129 16.6839 3.20435 17 4 17H15ZM5 5H9M5 9H9M5 13H9" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</a>
							</td>
						</tr>
					@endforeach

					</tbody>
				</table>
			</div>
        </div>
    </div>
@endsection

